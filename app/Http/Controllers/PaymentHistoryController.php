<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api\Finpay\NotificationCallbackFinpay;

use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        $comboProject = $this->getProject();

        return view('payment_history.index', compact('comboProject'));
    }

    public function getTable(Request $request)
    {
        $data = $request->all();

        $start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->format('Ymd');
        $end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->format('Ymd');
        $project_no = $data['project'];

        $notification = NotificationCallbackFinpay::whereRaw('year(payment_date)*10000+month(payment_date)*100+day(payment_date) >= ?', [$start_date])
            ->whereRaw('year(payment_date)*10000+month(payment_date)*100+day(payment_date) <= ?', [$end_date]);

        if ($project_no != 'all') {
            $notification->where('project_no', '=', $project_no);
        }

        $result = $notification->get();

        return DataTables::of($result)->make(true);
    }
}
