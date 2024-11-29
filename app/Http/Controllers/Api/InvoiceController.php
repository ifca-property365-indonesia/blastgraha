<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Resources\ResponseResource;
use Carbon\Carbon;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Invoice\InvoiceView;

class InvoiceController extends Controller
{
    public function store()
    {
        try {
            $data = InvoiceView::limit(50)
                ->where('send_flag', '=', 'N')
                ->where('submit_pay', '=', 'Y')
                ->where('entity_cd', '=', '2001')
                ->get();

            $dt = $data;
            $company = 'LVNW44';

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

                    $filePath = $url_filepath . 'invoices/' . $filenames;
                    $headers = get_headers($filePath);

                    // mengecek file ada atau tidak 
                    if ($headers && strpos($headers[0], '200 OK') !== false) {
                        $check_data = InvoiceHeader::where('entity_cd', '=', '2001')
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
                                env('API_WHATSAPP_GAK') . 'api/sendwa-bas',
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
                                    $url . 'whatsapp/save',
                                    [
                                        'company_cd' => $company,
                                        'type_blast' => "invoice",
                                        'send_total' => "1"
                                    ]
                                );

                                return (new ResponseResource(true, 'WhatsApp send successfully', []))
                                    ->response()
                                    ->setStatusCode(200);
                            } else {
                                $data_hdr_failed = array(
                                    'send_flag' => 'F',
                                    'whatsapp_id' => '-',
                                    'send_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                                );

                                InvoiceHeader::where($where)->update($data_hdr_failed);

                                return (new ResponseResource(false, 'Failed Send to WhatsApp', []))
                                    ->response()
                                    ->setStatusCode(400);
                            }
                        } else {
                            $response = Http::post(
                                $url . 'api/sendwa-bas',
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
                                    $url . 'whatsapp/save',
                                    [
                                        'company_cd' => $company,
                                        'type_blast' => "invoice",
                                        'send_total' => "1"
                                    ]
                                );

                                return (new ResponseResource(true, 'WhatsApp send successfully', []))
                                    ->response()
                                    ->setStatusCode(200);
                            } else {
                                $data_hdr_failed = array(
                                    'whatsapp_id' => '-',
                                    'send_flag' => 'F',
                                    'send_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                                );

                                InvoiceHeader::where($where)->update($data_hdr_failed);

                                return (new ResponseResource(false, 'Failed Send to WhatsApp', []))
                                    ->response()
                                    ->setStatusCode(400);
                            }
                        }
                    } else {
                        // File does not exist.
                        return (new ResponseResource(false, 'Unable to process send, because the file does not exist', []))
                            ->response()
                            ->setStatusCode(404);
                    }
                }
            }
        } catch (\Exception $e) {
            return (new ResponseResource(false, 'error', $e->getMessage()))
                ->response()
                ->setStatusCode(500);
        }
    }
}
