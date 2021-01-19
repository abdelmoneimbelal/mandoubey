<?php

namespace App\Http\Controllers;

use App\Client;
use App\Delegate;
use App\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::all();
        $clients = Client::all();
        $delegates = Delegate::all();


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 250])
            ->labels(['الطلبات', 'العملاء', 'المندوبين'])
            ->datasets([
                [
                    "label" => "الطلبات",
                    'backgroundColor' => ['rgb(1, 94, 234)'],
                    'data' => [$orders]
                ],
                [
                    "label" => "العملاء",
                    'backgroundColor' => ['rgb(248, 87, 113)'],
                    'data' => [$clients]
                ],
                [
                    "label" => "المندوبين",
                    'backgroundColor' => ['rgb(243, 136, 70)'],
                    'data' => [$delegates]
                ],


            ])
            ->options([]);

//        $chartjs_2 = app()->chartjs
//            ->name('pieChartTest')
//            ->type('pie')
//            ->size(['width' => 350, 'height' => 280])
//            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
//            ->datasets([
//                [
//                    'backgroundColor' => ['rgb(248, 87, 113)', 'rgb(38, 183, 136)', 'rgb(243, 136, 70)'],
//                    'data' => [$nspainvoices2, $nspainvoices1, $nspainvoices3]
//                ]
//            ])
//            ->options([]);


        return view('home', compact('orders', 'clients', 'delegates', 'chartjs'));
    }
}
