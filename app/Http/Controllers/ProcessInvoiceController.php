<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Invoice\InvoiceView;

use App\Models\Api\Finpay\RequestFinpay;
use App\Models\Api\Finpay\ResponseRequestFinpay;

use App\Models\Api\Paper\RequestPaper;
use App\Models\Api\Paper\ResponseRequestPaper;

use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class ProcessInvoiceController extends Controller
{
    public function index()
    {
        $comboProject = $this->getProject();

        return view('process_invoice.index', compact('comboProject'));
    }

    public function getTable(Request $request)
    {
        $dt = $request->all();

        $project_no = $dt['project'];

        $data = InvoiceView::where('submit_pay', '=', 'N')
            ->where('entity_cd', '=', '2001');

        if ($project_no != 'all') {
            $data->where('project_no', '=', $project_no);
        }

        return DataTables::of($data)->make(true);
    }

    // Transaksi dengan PaperID

    // public function store(Request $request)
    // {
    //     $data = $request->all();

    //     $dt = $data['models'];

    //     if (!empty($dt)) {
    //         for ($i = 0; $i < count($dt); $i++) {
    //             $email = 'ahmad.prasetyo@ifca.co.id';
    //             $company_name = 'Bumi Arta Sedayu';
    //             $mobilePhone = $dt[$i]['wa_no'];
    //             $amount = (int) $dt[$i]['amount'];
    //             $doc_date = Carbon::createFromFormat('Y-m-d H:i:s.u', $dt[$i]['doc_date'])->format('Ymd');
    //             $descs = $dt[$i]['descs'] . '-' . $doc_date . '-' . $dt[$i]['debtor_acct'];
    //             $orderId = pathinfo($dt[$i]['file_name'], PATHINFO_FILENAME) . '_' . Str::random(6);

    //             $item_additional = "additional_info :{

    //             }";

    //             $customer = array(
    //                 'id' => $dt[$i]['rowID'],
    //                 'name' => $company_name,
    //                 'email' => $email,
    //                 'phone' => $mobilePhone,
    //             );

    //             $item = array(
    //                 'name' => $dt[$i]['descs'],
    //                 'description' => $descs,
    //                 'quantity' => 1,
    //                 'price' => $amount,
    //                 'discount' => 0,
    //                 'tax' => 0,
    //                 $item_additional
    //             );

    //             $send = array(
    //                 'email' => false,
    //                 'whatsapp' => false,
    //                 'sms' => false
    //             );

    //             $data_store = array(
    //                 'invoice_date' => Carbon::now('Asia/Jakarta')->format('d-m-Y'),
    //                 'due_date' => Carbon::now('Asia/Jakarta')->copy()->addMonths(1)->format('d-m-Y'),
    //                 'number' => $orderId,
    //                 'customer' => $customer,
    //                 'items' => array($item),
    //                 'total' => $amount,
    //                 'send' => $send
    //             );

    //             if (env('PAYMENT_MODE_GAK') == 'sandbox') {
    //                 $response = Http::withHeaders([
    //                     'client_id' => env('CLIENT_ID_SANDBOX'),
    //                     'client_secret' => env('CLIENT_SECRET_SANDBOX'),
    //                     'Content-Type' => 'application/json'
    //                 ])->post('https://open-api.stag-v2.paper.id/api/v1/store-invoice', $data_store);
    //             } else {
    //                 $response = Http::withHeaders([
    //                     'client_id' => env('CLIENT_ID'),
    //                     'client_secret' => env('CLIENT_SECRET'),
    //                     'Content-Type' => 'application/json'
    //                 ])->post('https://open-api.paper.id/api/v1/store-invoice', $data_store);
    //             }

    //             $res = $response->json();
    //             $statusCode = $response->status();

    //             if ($statusCode == 200 || $statusCode == 201) {
    //                 $success = $res['data'];

    //                 $data_request = array(
    //                     'entity_cd' => $dt[$i]['entity_cd'],
    //                     'project_no' => $dt[$i]['project_no'],
    //                     'project_name' => $company_name,
    //                     'debtor_acct' => $dt[$i]['debtor_acct'],
    //                     'debtor_name' => $dt[$i]['cust_name'],
    //                     'email_addr' => $email,
    //                     'mobile_customer' => $mobilePhone,
    //                     'order_id' => $orderId,
    //                     'order_amount' => $amount,
    //                     'order_descs' => $descs,
    //                     'total' => $amount,
    //                     'audit_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
    //                 );

    //                 $insert_request = RequestPaper::create($data_request);

    //                 if ($insert_request) {
    //                     $data_response = array(
    //                         'transaction_id' => $success['id'],
    //                         'transaction_number' => $success['number'],
    //                         'response_payper_url' => $success['payper_url'],
    //                         'json' => json_encode($success),
    //                         'audit_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
    //                     );

    //                     ResponseRequestPaper::create($data_response);

    //                     $data_submit = array(
    //                         'submit_pay' => 'Y',
    //                         'transaction_id' => $success['id'],
    //                         'transaction_number' => $orderId,
    //                         'redirect_url' => $success['payper_url']
    //                     );

    //                     $where = array(
    //                         'doc_no' => $dt[$i]['doc_no']
    //                     );

    //                     InvoiceHeader::where($where)->update($data_submit);

    //                     $callback = array(
    //                         "Error" => false,
    //                         "Pesan" => "Data has been processed successfully"
    //                     );
    //                 } else {
    //                     $callback = array(
    //                         "Error" => false,
    //                         "Pesan" => "Failed insert into table"
    //                     );
    //                 }
    //             } else {
    //                 $error = $res['error'];
    //                 $message = $error['message'];

    //                 $callback = array(
    //                     "Error" => true,
    //                     "Pesan" => $message
    //                 );
    //             }
    //         }
    //     }

    //     return response()->json($callback);
    // }

    // Transaksi dengan Finnet
    public function store(Request $request)
    {
        $data = $request->all();
        $dt = $data['models'];

        if (!empty($dt)) {
            for ($i = 0; $i < count($dt); $i++) {
                $email = 'pt.grahaartakencana@citraswarna.com';
                $company_name = 'Graha Artha Kencana';
                $mobilePhone = $dt[$i]['wa_no'];
                $amount = (int) $dt[$i]['amount'];
                $doc_date = Carbon::createFromFormat('Y-m-d H:i:s.u', $dt[$i]['doc_date'])->format('Ymd');
                $descs = $dt[$i]['descs'] . '-' . $doc_date . '-' . $dt[$i]['debtor_acct'];

                $orderId = pathinfo($dt[$i]['file_name'], PATHINFO_FILENAME) . '_' . Str::random(6);
                $customer_name = $this->separateName($company_name);
                $filenames = $dt[$i]['file_name'];

                $customer = [
                    'email' => $email,
                    'firstName' => $customer_name['firstName'],
                    'lastName' => $customer_name['lastName'],
                    'mobilePhone' => $mobilePhone
                ];

                $order = [
                    'id' => $orderId,
                    'amount' => $amount,
                    'description' => $descs,
                    'timeout' => '43200'
                ];

                $url_cb = [
                    'callbackUrl' => url('/api') . '/notification/payment'
                ];
                // dd($url);

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
                    if ($env == 'sandbox') {
                        $merchantID = env('MERCHANT_ID_SANDBOX_GAK');
                        $merchantKey = env('MERCHANT_KEY_SANDBOX_GAK');
                        $authentication = $merchantID . ":" . $merchantKey;
                        $encodeAuth = base64_encode($authentication);

                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Basic ' . $encodeAuth
                        ])->post('https://devo.finnet.co.id/pg/payment/card/initiate', [
                                    'customer' => $customer,
                                    'order' => $order,
                                    'url' => $url_cb
                                ]);
                    } else {
                        $merchantID = env('MERCHANT_ID_GAK');
                        $merchantKey = env('MERCHANT_KEY_GAK');
                        $authentication = $merchantID . ":" . $merchantKey;
                        $encodeAuth = base64_encode($authentication);

                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Basic ' . $encodeAuth
                        ])->post('https://live.finnet.co.id/pg/payment/card/initiate', [
                                    'customer' => $customer,
                                    'order' => $order,
                                    'url' => $url_cb
                        ]);
                    }

                    $res = $response->json();
                    $statusCode = $response->status();

                    if ($statusCode == 200) {
                        $data_request = array(
                            'entity_cd' => $dt[$i]['entity_cd'],
                            'project_no' => $dt[$i]['project_no'],
                            'project_name' => $company_name,
                            'debtor_acct' => $dt[$i]['debtor_acct'],
                            'debtor_name' => $dt[$i]['cust_name'],
                            'email_addr' => $email,
                            'mobile_customer' => $mobilePhone,
                            'order_id' => $orderId,
                            'order_amount' => $amount,
                            'order_descs' => $descs,
                            'total' => $amount,
                            'audit_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                        );

                        $insert_request = RequestFinpay::create($data_request);

                        if ($insert_request) {
                            $data_response = array(
                                'response_code' => $res['responseCode'],
                                'response_message' => $res['responseMessage'],
                                'response_url' => $res['redirecturl'],
                                'expiry_link' => Carbon::createFromFormat('Y-m-d H:i:s', $res['expiryLink'])->format('d M Y H:i:s'),
                                'transaction_id' => $orderId,
                                'json' => json_encode($res),
                                'audit_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                            );

                            ResponseRequestFinpay::create($data_response);

                            $data_submit = array(
                                'submit_pay' => 'Y',
                                'transaction_number' => $orderId,
                                'redirect_url' => $res['redirecturl']
                            );

                            $where = array(
                                'doc_no' => $dt[$i]['doc_no'],
                                'entity_cd' => $dt[$i]['entity_cd']
                            );

                            InvoiceHeader::where($where)->update($data_submit);

                            $callback = array(
                                "Error" => false,
                                "Pesan" => "Data has been processed successfully"
                            );
                        } else {
                            $callback = array(
                                "Error" => false,
                                "Pesan" => "Failed insert into table"
                            );
                        }
                    } else {
                        $callback = array(
                            "Error" => true,
                            "Pesan" => $res['responseMessage']
                        );
                    }
                } else {
                    // File does not exist."
                    $callback = array(
                        "Error" => true,
                        "Pesan" => "Unable to process send, because the file does not exist"
                    );
                }
            }
        }

        return response()->json($callback);
    }

    function separateName($fullName)
    {
        // Pisahkan nama menjadi array
        $nameArray = explode(' ', $fullName);

        // Tentukan panjang array
        $length = count($nameArray);

        // Inisialisasi variabel firstName dan lastName
        $firstName = "";
        $lastName = "";

        // Cek panjang array dan atur firstName dan lastName
        if ($length == 1) {
            $firstName = $nameArray[0];
        } elseif ($length == 2) {
            $firstName = $nameArray[0];
            $lastName = $nameArray[1];
        } elseif ($length >= 2) {
            $firstName = $nameArray[0] . ' ' . $nameArray[1];
            $lastName = implode(' ', array_slice($nameArray, 2));
        }

        // Kembalikan hasil dalam bentuk array
        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
        ];
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        $criteria = array(
            'submit_pay' => 'N',
            'entity_cd' => '2001',
            'doc_no' => $data['doc_no']
        );

        $invoice_detail = InvoiceHeader::where($criteria)->first();

        if (!is_null($invoice_detail)) {
            $filenames = $invoice_detail->file_name;

            $env = env(key: 'PAYMENT_MODE_GAK');

            if($env == 'sandbox'){
                $ftpServer = env(key: 'FTP_INVOICE_SERVER_GAK');
                $ftpUser = env(key: 'FTP_INVOICE_USER_GAK');
                $ftpPassword = env('FTP_INVOICE_PASSWORD_GAK');
            } else {
                $ftpServer = env(key: 'FTP_INVOICE_SERVER_PROD_GAK');
                $ftpUser = env(key: 'FTP_INVOICE_USER_PROD_GAK');
                $ftpPassword = env('FTP_INVOICE_PASSWORD_PROD_GAK');
            }

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

            $data_update = array(
                'gen_flag' => 'C'
            );

            $invoice_update = InvoiceHeader::where($criteria)->update($data_update);

            if ($invoice_update) {
                $response = array(
                    "Error" => false,
                    "Pesan" => "Deleted Successfully"
                );
            } else {
                $response = array(
                    "Error" => true,
                    "Pesan" => $invoice_update
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
}
