<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\ResponseResource;

use App\Models\Invoice\InvoiceHeader;

class NotificationCallbackWhatsAppController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $whatsappId = $data['statuses'][0]['id'];
            $status = $data['statuses'][0]['status'];

            $checking = InvoiceHeader::where([
                'whatsapp_id' => $whatsappId
            ])->first();

            if (!is_null($checking)) {
                if ($status == 'sent') {
                    $send_flag = 'Y';
                } else if ($status == 'delivered') {
                    $send_flag = 'D';
                } else if ($status == 'read') {
                    $send_flag = 'R';
                } else {
                    $send_flag = 'E';
                }

                $data_callback = array(
                    'send_flag' => $send_flag
                );

                $update_callback = InvoiceHeader::where([
                    'whatsapp_id' => $whatsappId
                ])->update($data_callback);

                if ($update_callback) {
                    return (new ResponseResource(true, 'Data has been updated successfully', []))
                        ->response()
                        ->setStatusCode(200);
                } else {
                    return (new ResponseResource(false, 'Failed insert into table', []))
                        ->response()
                        ->setStatusCode(400);
                }
            } else {
                return (new ResponseResource(false, 'Data not found', []))
                    ->response()
                    ->setStatusCode(400);
            }
        } catch (\Exception $e) {
            return (new ResponseResource(false, 'error', $e->getMessage()))
                ->response()
                ->setStatusCode(500);
        }
    }
}
