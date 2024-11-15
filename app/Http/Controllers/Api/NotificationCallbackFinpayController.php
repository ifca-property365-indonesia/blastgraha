<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\ResponseResource;
use Carbon\Carbon;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Api\Finpay\NotificationCallbackFinpay;

class NotificationCallbackFinpayController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $orderId = $data['order']['id'];
            $signature = $data['signature'];
            $payment_date = $data['result']['payment']['datetime'];
            $pay_date = Carbon::createFromFormat('Y-m-d H:i:s', $payment_date)->format('d M Y H:i:s'); //untuk kebutuhan insert ke table notif callback
            $f_pay = Carbon::createFromFormat('Y-m-d H:i:s', $payment_date)->format('d/m/Y'); //untuk kebutuhan exec sp
            $payment_status = $data['result']['payment']['status'];
            // $payment_total = $data['result']['payment']['amount'];
            $payment_total = $data['order']['amount'];
            $payment_metode = $data['sourceOfFunds']['type'];
            $payment_code = $data['sourceOfFunds']['paymentCode'];
            $fields = $request->getContent();
            $responseArray = json_decode($fields, true);
            unset($responseArray['signature']);
            $payloadJson = json_encode($responseArray, JSON_UNESCAPED_SLASHES);

            if (env('GAK_PAYMENT_MODE') == 'sandbox') {
                $merchantKey = env('MERCHANT_KEY_SANDBOX');

                $hashSignature = hash_hmac("sha512", $payloadJson, $merchantKey);

            } else {
                $merchantKey = env('MERCHANT_KEY');

                $hashSignature = hash_hmac("sha512", $payloadJson, $merchantKey);
            }

            if ($hashSignature == $signature) {
                $checking = InvoiceHeader::where([
                    'transaction_number' => $orderId
                ])->first();

                if (!is_null($checking)) {
                    $entity_cd = $checking->entity_cd;
                    $project_no = $checking->project_no;
                    $debtor_acct = $checking->debtor_acct;
                    $cust_name = $checking->cust_name;
                    $lot_no = $checking->lot_no;
                    $doc_no = $checking->doc_no;
                    $line_no = $checking->line_no;
                    $rowID = $checking->rowID;

                    $data_callback = array(
                        'entity_cd' => $entity_cd,
                        'project_no' => $project_no,
                        'debtor_acct' => $debtor_acct,
                        'debtor_name' => $cust_name,
                        'lot_no' => $lot_no,
                        'transaction_id' => $orderId,
                        'payment_metode' => $payment_metode,
                        'payment_code' => $payment_code,
                        'payment_status' => $payment_status,
                        'payment_date' => $pay_date,
                        'payment_total' => $payment_total,
                        'json' => json_encode($data),
                        'audit_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                    );

                    if ($payment_status == 'PAID' || $payment_status == 'CAPTURED') {
                        $check_callback = NotificationCallbackFinpay::where([
                            'transaction_id' => $orderId
                        ])->first();

                        if (!is_null($check_callback)) {
                            $data_callback = array(
                                'payment_status' => $payment_status,
                                'audit_date' => Carbon::now('Asia/Jakarta')->format('d M Y H:i:s')
                            );

                            $update_callback = NotificationCallbackFinpay::where([
                                'transaction_id' => $orderId
                            ])->update($data_callback);

                            if ($update_callback) {
                                $data_update = array(
                                    'paid_flag' => 'Y'
                                );

                                $update_tbl = InvoiceHeader::where([
                                    'entity_cd' => $entity_cd,
                                    'doc_no' => $doc_no,
                                    'transaction_number' => $orderId
                                ])->update($data_update);

                                if ($update_tbl) {
                                    $statement_1 = "EXEC mgr.xar_receipt_blast ?, ?, ?, ?, ?, ?";

                                    DB::connection('sqlsrv')->statement(
                                        $statement_1,
                                        [$entity_cd, $f_pay, $doc_no, $line_no, $orderId, $rowID]
                                    );

                                    $statement_2 = "EXEC mgr.xar_receipt_blast_alloc ?, ?, ?, ?, ?, ?";

                                    DB::connection('sqlsrv')->statement(
                                        $statement_2,
                                        [$entity_cd, $f_pay, $doc_no, $line_no, $orderId, $rowID]
                                    );

                                    return (new ResponseResource(true, 'Your payment has been successful!', []))
                                        ->response()
                                        ->setStatusCode(200);
                                } else {
                                    return (new ResponseResource(false, 'Failed update into table', []))
                                        ->response()
                                        ->setStatusCode(400);
                                }
                            } else {
                                return (new ResponseResource(false, 'Failed insert into table', []))
                                    ->response()
                                    ->setStatusCode(400);
                            }
                        } else {
                            $insert_callback = NotificationCallbackFinpay::create($data_callback);

                            if ($insert_callback) {
                                $data_update = array(
                                    'paid_flag' => 'Y'
                                );

                                $update_tbl = InvoiceHeader::where([
                                    'entity_cd' => $entity_cd,
                                    'doc_no' => $doc_no,
                                    'transaction_number' => $orderId
                                ])->update($data_update);

                                if ($update_tbl) {
                                    $statement_1 = "EXEC mgr.xar_receipt_blast ?, ?, ?, ?, ?, ?";

                                    DB::connection('sqlsrv')->statement(
                                        $statement_1,
                                        [$entity_cd, $f_pay, $doc_no, $line_no, $orderId, $rowID]
                                    );

                                    $statement_2 = "EXEC mgr.xar_receipt_blast_alloc ?, ?, ?, ?, ?, ?";

                                    DB::connection('sqlsrv')->statement(
                                        $statement_2,
                                        [$entity_cd, $f_pay, $doc_no, $line_no, $orderId, $rowID]
                                    );

                                    return (new ResponseResource(true, 'Your payment has been successful!', []))
                                        ->response()
                                        ->setStatusCode(200);
                                } else {
                                    return (new ResponseResource(false, 'Failed update into table', []))
                                        ->response()
                                        ->setStatusCode(400);
                                }
                            } else {
                                return (new ResponseResource(false, 'Failed insert into table', []))
                                    ->response()
                                    ->setStatusCode(400);
                            }
                        }
                    } else {
                        $insert_callback = NotificationCallbackFinpay::create($data_callback);

                        if ($insert_callback) {
                            $data_update = array(
                                'paid_flag' => 'E'
                            );

                            $update_tbl = InvoiceHeader::where([
                                'entity_cd' => $entity_cd,
                                'doc_no' => $doc_no,
                                'transaction_number' => $orderId
                            ])->update($data_update);

                            if ($update_tbl) {
                                return (new ResponseResource(true, 'Your transaction is no longer valid', []))
                                    ->response()
                                    ->setStatusCode(200);
                            } else {
                                return (new ResponseResource(false, 'Failed update into table', []))
                                    ->response()
                                    ->setStatusCode(400);
                            }
                        } else {
                            return (new ResponseResource(false, 'Failed insert into table', []))
                                ->response()
                                ->setStatusCode(400);
                        }
                    }
                } else {
                    return (new ResponseResource(false, 'Data not found', []))
                        ->response()
                        ->setStatusCode(400);
                }
            } else {
                return (new ResponseResource(false, 'Invalid Signature', []))
                    ->response()
                    ->setStatusCode(409);
            }
        } catch (\Exception $e) {
            return (new ResponseResource(false, 'error', $e->getMessage()))
                ->response()
                ->setStatusCode(500);
        }
    }
}
