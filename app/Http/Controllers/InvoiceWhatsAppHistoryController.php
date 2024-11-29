<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Invoice\InvoiceView;

use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class InvoiceWhatsAppHistoryController extends Controller
{
    public function index()
    {
        $comboProject = $this->getProject();

        return view('invoice_history.index_whatsapp', compact('comboProject'));
    }

    public function getTableSuccess(Request $request)
    {
        $dt = $request->all();

        $start_date = Carbon::createFromFormat('d/m/Y', $dt['start_date'])->format('Ymd');
        $end_date = Carbon::createFromFormat('d/m/Y', $dt['end_date'])->format('Ymd');
        $project_no = $dt['project'];
        $status = $dt['status'];

        $data = InvoiceView::whereIn('send_flag', ['Y', 'D', 'R'])
            ->where('entity_cd', '=', '2001')
            ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) >= ?', [$start_date])
            ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) <= ?', [$end_date])
            ->orderBy('send_date', 'desc');

        if ($project_no != 'all') {
            $data->where('project_no', '=', $project_no);
        }

        if ($status != 'all') {
            $data->where('send_flag', '=', $status);
        }

        $result = $data->get();

        return DataTables::of($result)->make(true);
    }

    public function getTableFailed(Request $request)
    {
        $dt = $request->all();

        $start_date = Carbon::createFromFormat('d/m/Y', $dt['start_date'])->format('Ymd');
        $end_date = Carbon::createFromFormat('d/m/Y', $dt['end_date'])->format('Ymd');
        $project_no = $dt['project'];

        $data = InvoiceView::whereIn('send_flag', ['F', 'E'])
            ->where('entity_cd', '=', '2001')
            ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) >= ?', [$start_date])
            ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) <= ?', [$end_date])
            ->orderBy('send_date', 'desc');

        if ($project_no != 'all') {
            $data->where('project_no', '=', $project_no);
        }

        $result = $data->get();

        return DataTables::of($result)->make(true);
    }

    public function show($row_id)
    {
        $data = InvoiceHeader::where('rowID', '=', $row_id)->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $dt = $data['models'];
        $company = Session::get('company_cd');

        if (!empty($dt)) {
            for ($i = 0; $i < count($dt); $i++) {
                $debtor_name = $dt[$i]['cust_name'];
                $project_name = $dt[$i]['entity_induk_name'];
                $cluster_descs = $dt[$i]['cluster_descs'];
                $lot_no = $dt[$i]['lot_no'];
                $link_pembayaran = $dt[$i]['url_masking'];
                $doc_date = Carbon::createFromFormat('Y-m-d H:i:s.u', $dt[$i]['doc_date'])->format('F Y');
                $pic_project_telno = isset($dt[$i]['prj_contact_telno']) ? $dt[$i]['prj_contact_telno'] : '-';
                $pic_project_email = isset($dt[$i]['prj_contact_email']) ? $dt[$i]['prj_contact_email'] : '-';
                $pic_project_person = isset($dt[$i]['prj_contact_person']) ? $dt[$i]['prj_contact_person'] : '-';
                $filenames = $dt[$i]['file_name'];
                $wa_no = $dt[$i]['wa_no'];
                $access_code = "3";

                $data_send = array(
                    'cust_name' => $debtor_name,
                    'entity_induk_name' => $project_name,
                    'cluster_descs' => $cluster_descs,
                    'lot_no' => $lot_no,
                    'redirect_url' => $link_pembayaran,
                    'doc_date' => $doc_date,
                    'prj_contact_telno' => $pic_project_telno,
                    'prj_contact_email' => $pic_project_email,
                    'prj_contact_person' => $pic_project_person,
                    'file_name' => $filenames,
                    'wa_no' => $wa_no,
                    'access_code' => $access_code,
                    'environment' => env('PAYMENT_MODE_GAK')
                );

                $where = array(
                    'rowID' => $dt[$i]['rowID']
                );

                $env = env(key: 'PAYMENT_MODE_GAK');

                if($env == 'sandbox') {
                    $url = env(key: 'API_GATEWAY_SANDBOX_GAK');
                    $url_filepath = env(key: 'ROOT_INVOICE_FILE_PATH_GAK');
                } else {
                    $url = env(key : 'API_GATEWAY_GAK');
                    $url_filepath = env(key: 'ROOT_INVOICE_FILE_PATH_PROD_GAK');
                }

                $filePath = $url_filepath . 'invoice/' . $filenames;
                $headers = get_headers($filePath);

                // mengecek file ada atau tidak 
                if ($headers && strpos($headers[0], '200 OK') !== false) {
                    $response = Http::post(
                        env('API_WHATSAPP_GAK') . 'api/sendwa-bas',
                        $data_send
                    );

                    $statusCode = $response->status();

                    if ($statusCode == 200) {
                        $responseData = $response->json();

                        $data_hdr_success = array(
                            'whatsapp_id' => $responseData['messages'][0]['id'],
                            'send_flag' => 'Y',
                            'send_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                        );

                        InvoiceHeader::where($where)->update($data_hdr_success);

                        Http::post(
                            $url . 'whatsapp/save',
                            [
                                'company_cd' => $company,
                                'type_blast' => "invoice",
                                'send_total' => "1"
                            ]
                        );

                        $callback = array(
                            "Error" => false,
                            "Pesan" => "WhatsApp send successfully"
                        );
                    } else {
                        $data_hdr_failed = array(
                            'whatsapp_id' => '-',
                            'send_flag' => 'F',
                            'send_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                        );

                        InvoiceHeader::where($where)->update($data_hdr_failed);

                        $callback = array(
                            "Error" => false,
                            "Pesan" => "Failed Send to WhatsApp"
                        );
                    }
                } else {
                    // File does not exist."
                    $response = array(
                        "Error" => true,
                        "Pesan" => "Unable to process send, because the file does not exist"
                    );
                }
            }
        }

        return response()->json($callback);
    }

}
