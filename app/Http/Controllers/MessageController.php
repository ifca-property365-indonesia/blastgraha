<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Api\Finpay\ResponseRequestFinpay;

class MessageController extends Controller
{
    public function index()
    {
        return view('message.index');
    }

    public function show($transaction_number)
    {
        $transaction_number = base64_decode($transaction_number);
        $find = InvoiceHeader::where('transaction_number', $transaction_number)->first();

        if (!is_null($find)) {
            $data = [
                'doc_no' => $find->doc_no,
                'name' => $find->cust_name,
                'lot_no' => $find->lot_no,
                'descs' => $find->descs,
                'amount' => "Rp. " . number_format($find->amount, 2, ',', '.'),
                'link' => $find->redirect_url,
            ];

            $paid_flag = $find->paid_flag;

            $exp_data = ResponseRequestFinpay::where('transaction_id', $transaction_number)->first();

            if (!is_null($exp_data)) {
                $expired_date = $exp_data->expiry_link;
                $now = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

                if ($expired_date > $now && $paid_flag == 'N') {
                    return view('message.index', $data);
                } else {
                    return view('message.failed');
                }
            } else {
                return view('message.not_found');
            }
        } else {
            return view('message.not_found');
        }
    }

    public function expiredLink()
    {
        return view('message.failed');
    }
    public function failedLink()
    {
        return view('message.not_found');
    }
}
