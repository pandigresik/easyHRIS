<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class RevenueMonthlyChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        return $this->chart->lineChart()
            ->setHeight(140)
            //->setTitle('Sales during 2021.')
            ->addData('Physical sales', [40, 93, 35, 42, 18, 82])
            ->addData('Physical sales 2', [50, 193, 135, 142, 108, 82])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June'])
            ->setGrid()
            // ->setOptions([
            //     'title' => ['text' => null],
            //     'stroke' => [
            //         'curve' => 'smooth',
            //         'width' => 2,
            //     ],
            //     'colors' => ['#DDAA34', '#DD4567'],
            //     'xaxis' => [
            //         'labels' => ['show' => false],
            //         'axisBorder' => ['show' => false],
            //     ],
            //     'tooltip' => [
            //         'theme' => 'dark',
            //     ],
            //     'legend' => ['show' => false],
            // ])
        ;
    }
}
