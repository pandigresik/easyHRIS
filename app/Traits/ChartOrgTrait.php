<?php

namespace App\Traits;

trait ChartOrgTrait
{
    protected $viewChart = 'chart.org';
    public function displayChart($id = null){
        return view($this->viewChart, ['source' => $this->getDataChart($id)]);
    }

    protected function getDataChart($id = null){
        return [];
    }
}
