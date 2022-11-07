<?php

namespace App\Http\Controllers;

use App\Models\Hr\Overtime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $widgets = [];
        \Widget::group('main')->position(3)->addAsyncWidget('revenueWidget', ['bgcolor' => 'bg-gradient-danger']);
        \Widget::group('main')->position(5)->addAsyncWidget('revenueWidget', ['bgcolor' => 'bg-gradient-warning']);

        array_push($widgets, '<div class="row mb-3">'.\Widget::group('main')->wrap(function ($content, $index, $total) {
            // $total is a total number of widgets in a group.
            $width = intval(12 / $total);
            $classWidth = $width <= 2 ? 'col-lg-3 col-sm-6' : 'col-lg-'.$width.' col-sm-'.($width * 2 > 12 ? 12 : $width * 2);

            return "<div class='".$classWidth." widget-{$index}'>{$content}</div>";
        })->display().'</div>');
        array_push($widgets, \AsyncWidget::run('revenueWidget', ['bgcolor' => 'bg-gradient-danger']));
        array_push($widgets, \AsyncWidget::run('popularWidget', []));

        return view('home')->with(['widgets' => $widgets]);
    }

    public function tes(){
        $overtime = Overtime::with(['benefitValue'])->get();
        dd($overtime);
    }
}
