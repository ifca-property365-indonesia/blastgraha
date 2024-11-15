<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Invoice\InvoiceView;

use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function index()
    {
        $comboProject = $this->getProject();

        return view('invoice.index', compact('comboProject'));
    }

    public function getTable(Request $request)
    {
        $dt = $request->all();

        $project_no = $dt['project'];

        $data = InvoiceView::where('send_flag', '=', 'N')
            ->where('submit_pay', '=', 'Y')
            ->where('entity_cd', '=', '1001');

        if ($project_no != 'all') {
            $data->where('project_no', '=', $project_no);
        }

        return DataTables::of($data)->make(true);
    }

    public function showPopupSend()
    {
        return view('invoice.popup_send');
    }

    public function show($doc_no)
    {
        $data = InvoiceHeader::where('send_flag', '=', 'N')
            ->where('doc_no', '=', $doc_no)
            ->where('entity_cd', '=', '1001')
            ->get();
        return response()->json($data);
    }

    public function storeWA($data)
    {
        $dt = $data['models'];
        $company = Session::get('company_cd');

        if (!empty($dt)) {
            for ($i = 0; $i < count($dt); $i++) {
                $debtor_acct = $dt[$i]['debtor_acct'];
                $debtor_name = $dt[$i]['cust_name'];
                $transaction_number = $dt[$i]['transaction_number'];
                $project_name = $dt[$i]['entity_induk_name'];
                $cluster_descs = $dt[$i]['cluster_descs'];
                $lot_no = $dt[$i]['lot_no'];
                // $link_pembayaran = $dt[$i]['redirect_url'];
                $link_pembayaran = url('/payment' . '/' . base64_encode($transaction_number));
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
                    'environment' => env('GAK_PAYMENT_MODE')
                );

                $where = array(
                    'rowID' => $dt[$i]['rowID']
                );

                $filePath = env('ROOT_INVOICE_FILE_PATH') . 'invoice/' . $filenames;
                $headers = get_headers($filePath);

                // mengecek file ada atau tidak 
                if ($headers && strpos($headers[0], '200 OK') !== false) {
                    $check_data = InvoiceHeader::where('entity_cd', '=', '1001')
                        ->where('debtor_acct', '=', $debtor_acct)
                        ->where('paid_flag', '=', 'N')
                        ->whereIn('send_flag', ['Y', 'D', 'R'])
                        ->first();

                    if (!is_null($check_data)) {
                        $where_update = [
                            'rowID' => $check_data->rowID
                        ];

                        InvoiceHeader::where($where_update)->update([
                            'paid_flag' => 'C',
                        ]);

                        $response = Http::post(
                            env('API_WHATSAPP') . 'api/sendwa-bas',
                            $data_send
                        );

                        $statusCode = $response->status();

                        if ($statusCode == 200 || $statusCode == 201) {
                            $responseData = $response->json();

                            $data_hdr_success = array(
                                'whatsapp_id' => $responseData['messages'][0]['id'],
                                'url_masking' => $link_pembayaran,
                                'send_flag' => 'Y',
                                'send_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                            );

                            InvoiceHeader::where($where)->update($data_hdr_success);

                            Http::post(
                                env('API_GATEWAY') . 'whatsapp/save',
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
                                'send_flag' => 'F',
                                'whatsapp_id' => '-',
                                'send_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                            );

                            InvoiceHeader::where($where)->update($data_hdr_failed);

                            $callback = array(
                                "Error" => false,
                                "Pesan" => "Failed Send to WhatsApp"
                            );
                        }
                    } else {
                        $response = Http::post(
                            env('API_WHATSAPP') . 'api/sendwa-bas',
                            $data_send
                        );

                        $statusCode = $response->status();

                        if ($statusCode == 200 || $statusCode == 201) {
                            $responseData = $response->json();

                            $data_hdr_success = array(
                                'whatsapp_id' => $responseData['messages'][0]['id'],
                                'url_masking' => $link_pembayaran,
                                'send_flag' => 'Y',
                                'send_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                            );

                            InvoiceHeader::where($where)->update($data_hdr_success);

                            Http::post(
                                env('API_GATEWAY') . 'whatsapp/save',
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
                    }
                } else {
                    // File does not exist."
                    $callback = array(
                        "Error" => true,
                        "Pesan" => "Unable to process send, because the file does not exist"
                    );
                }
            }

            return $callback;
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        $criteria = array(
            'send_flag' => 'N',
            'entity_cd' => '1001',
            'doc_no' => $data['doc_no']
        );

        $invoice_detail = InvoiceHeader::where($criteria)->first();

        if (!is_null($invoice_detail)) {
            $filenames = $invoice_detail->filenames;

            $ftpServer = env('FTP_INVOICE_SERVER');
            $ftpUser = env('FTP_INVOICE_USER');
            $ftpPassword = env('FTP_INVOICE_PASSWORD');

            $ftp = ftp_connect($ftpServer);

            // login with username and password
            $loginResult = ftp_login($ftp, $ftpUser, $ftpPassword);

            // turn passive mode on
            ftp_pasv($ftp, true);

            if (!$loginResult) {
                $response = array(
                    "Error" => true,
                    "Pesan" => "Can't Login FTP Server"
                );
            } else {
                // get contents of the current directory
                $contents = ftp_nlist($ftp, './invoice/');
                $remoteFilePath = './invoice/' . $filenames;

                if (in_array($remoteFilePath, $contents)) {
                    // delete file in server folder
                    ftp_delete($ftp, $remoteFilePath);
                } else {
                    // File does not exist.
                    $response = array(
                        "Error" => true,
                        "Pesan" => "File does not exist"
                    );
                }
            }

            // close the connection
            ftp_close($ftp);

            $invoice_delete = InvoiceHeader::where($criteria)->delete();

            if ($invoice_delete) {
                $response = array(
                    "Error" => false,
                    "Pesan" => "Deleted Successfully"
                );
            } else {
                $response = array(
                    "Error" => true,
                    "Pesan" => $invoice_delete
                );
            }
        } else {
            $response = array(
                "Error" => true,
                "Pesan" => "Data not found."
            );
        }

        return response()->json($response);
    }

    public function storeMultiPlatform(Request $request)
    {
        $data = $request->all();

        $typesToSend = array_column($data['datafrm'], 'value');

        if (in_array('email', $typesToSend)) {
            $res = $this->store($data);

            return response()->json($res);
        } else if (in_array('whatsapp', $typesToSend)) {
            $res = $this->storeWA($data);

            return response()->json($res);
        } else if (in_array('email', $typesToSend) && in_array('whatsapp', $typesToSend)) {
            $res = $this->storeJoin($data);

            return response()->json($res);
        } else {
            $res = array(
                'Error' => true,
                'Pesan' => 'Please select at least 1 and no more than 2 options for sending.'
            );

            return response()->json($res);
        }
    }
}
