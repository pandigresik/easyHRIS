<?php

namespace App\Exports\Hr;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class OvertimeReportExport implements FromView
{
    use Exportable;

    /**
     * @var Collection
     */
    protected $collection;
    private $period;
    private $view;
    private $startDate;
    private $endDate;
    private $employees;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function view(): View
    {
        return view($this->getView(), [
            'datas' => $this->collection,
            'period' => $this->getPeriod(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
            'employees' => $this->getEmployees(),
            'excel' => true
        ]);
    }

    /**
     * Get the value of view
     */ 
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set the value of view
     *
     * @return  self
     */ 
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the value of period
     */ 
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set the value of period
     *
     * @return  self
     */ 
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of employees
     */ 
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * Set the value of employees
     *
     * @return  self
     */ 
    public function setEmployees($employees)
    {
        $this->employees = $employees;

        return $this;
    }
}
