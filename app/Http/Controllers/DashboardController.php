<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Invoice\InvoiceView;

class DashboardController extends Controller
{
    public function index()
    {
        $company = Session::get('company_cd');
        $year = Carbon::now('Asia/Jakarta')->format('Y');
        $month = Carbon::now('Asia/Jakarta')->format('m');

        $env = env('PAYMENT_MODE_GAK');

        if($env == 'sandbox'){
            $url = env('API_GATEWAY_SANDBOX_GAK');
        } else {
            $url = env('API_GATEWAY_GAK');
        }

        $data_whatsapp = Http::get($url . 'whatsapp/kuota?company_cd=' . $company . '&year=' . $year . '&month=' . $month);
        $data_kuota_whatsapp = $data_whatsapp->json('Data');

        return view('dashboard.index', compact('data_kuota_whatsapp'));
    }

    public function indexWhatsappQuota()
    {
        return view('dashboard.index_whatsapp_quota');
    }

    public function showWhatsappChart(Request $request)
    {
        $data = $request->all();

        $start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->format('Ymd');
        $end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->format('Ymd');

        if ($data['type_blast'] == 'invoice') {
            $process_date = InvoiceHeader::where('send_flag', '=', 'N')
                ->where('entity_cd', '=', '2001')
                ->whereRaw('year(audit_date)*10000+month(audit_date)*100+day(audit_date) >= ?', [$start_date])
                ->whereRaw('year(audit_date)*10000+month(audit_date)*100+day(audit_date) <= ?', [$end_date])
                ->count();

            $deliver_date = InvoiceHeader::where('send_flag', '=', 'Y')
                ->where('entity_cd', '=', '2001')
                ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) >= ?', [$start_date])
                ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) <= ?', [$end_date])
                ->count();

            $reject_date = InvoiceHeader::where('send_flag', '=', 'F')
                ->where('entity_cd', '=', '2001')
                ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) >= ?', [$start_date])
                ->whereRaw('year(send_date)*10000+month(send_date)*100+day(send_date) <= ?', [$end_date])
                ->count();
        }

        $pending = InvoiceView::all()
            ->where('entity_cd', '=', '2001')
            ->count();
        $process = InvoiceHeader::where('send_flag', '=', 'N')
            ->where('entity_cd', '=', '2001')
            ->count();
        $deliver = InvoiceHeader::where('send_flag', '=', 'S')
            ->where('entity_cd', '=', '2001')
            ->count();
        $reject = InvoiceHeader::where('send_flag', '=', 'F')
            ->where('entity_cd', '=', '2001')
            ->count();

        $dataset[] = array(
            'label' => 'Total Data',
            'data' => [$process_date, $deliver_date, $reject_date],
            'backgroundColor' => '#1b84ff',
            'borderWidth' => 1
        );

        $response = array(
            'count' => [
                'pending' => $pending,
                'process' => $process,
                'deliver' => $deliver,
                'reject' => $reject,
            ],
            'labels' => ['Processed', 'Delivered', 'Rejected'],
            'datasets' => $dataset
        );

        return response()->json($response);
    }

    public function showWhatsappChartMonth(Request $request)
    {
        $data = $request->all();

        $company = Session::get('company_cd');
        $year = $data['year'];
        $month = Carbon::now('Asia/Jakarta')->format('m');

        $env = env('PAYMENT_MODE_GAK');

        if($env == 'sandbox'){
            $url = env('API_GATEWAY_SANDBOX_GAK');
        } else {
            $url = env('API_GATEWAY_GAK');
        }

        $email_month = Http::get($url . 'whatsapp/kuota_month?company_cd=' . $company . '&year=' . $year);
        $data_kuota_month = $email_month->json('Data');

        $totalJan = $data_kuota_month['Januari'];
        $totalFeb = $data_kuota_month['Februari'];
        $totalMar = $data_kuota_month['Maret'];
        $totalApr = $data_kuota_month['April'];
        $totalMei = $data_kuota_month['Mei'];
        $totalJun = $data_kuota_month['Juni'];
        $totalJul = $data_kuota_month['Juli'];
        $totalAgust = $data_kuota_month['Agustus'];
        $totalSep = $data_kuota_month['September'];
        $totalOkt = $data_kuota_month['Oktober'];
        $totalNov = $data_kuota_month['November'];
        $totalDes = $data_kuota_month['Desember'];

        $data_email = Http::get($url . 'whatsapp/kuota?company_cd=' . $company . '&year=' . $year . '&month=' . $month);
        $data_kuota_email = $data_email->json('Data');
        $total_kuota = (int) $data_kuota_email['total_kuota'];

        $dataset1 = array(
            'label' => 'Used',
            'data' => [
                $totalJan,
                $totalFeb,
                $totalMar,
                $totalApr,
                $totalMei,
                $totalJun,
                $totalJul,
                $totalAgust,
                $totalSep,
                $totalOkt,
                $totalNov,
                $totalDes,
            ],
            'backgroundColor' => '#90e0ef',
            'borderWidth' => 1
        );

        $sisaJan = $total_kuota - $totalJan;
        $sisaFeb = $total_kuota - $totalFeb;
        $sisaMar = $total_kuota - $totalMar;
        $sisaApr = $total_kuota - $totalApr;
        $sisaMei = $total_kuota - $totalMei;
        $sisaJun = $total_kuota - $totalJun;
        $sisaJul = $total_kuota - $totalJul;
        $sisaAgust = $total_kuota - $totalAgust;
        $sisaSep = $total_kuota - $totalSep;
        $sisaOkt = $total_kuota - $totalOkt;
        $sisaNov = $total_kuota - $totalNov;
        $sisaDes = $total_kuota - $totalDes;

        $dataset2 = array(
            'label' => 'Available',
            'data' => [
                $sisaJan,
                $sisaFeb,
                $sisaMar,
                $sisaApr,
                $sisaMei,
                $sisaJun,
                $sisaJul,
                $sisaAgust,
                $sisaSep,
                $sisaOkt,
                $sisaNov,
                $sisaDes
            ],
            'backgroundColor' => '#81b29a',
            'borderWidth' => 1
        );

        $response = array(
            'labels' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ],
            'datasets' => [$dataset1, $dataset2]
        );

        return response()->json($response);
    }
}
