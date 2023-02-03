<?php

namespace App\Exports\Hr;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceReportExport implements FromView
{
    use Exportable;

    /**
     * @var Collection
     */
    protected $collection;
    private $absentReason;
    private $view;
    private $startDate;
    private $endDate;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function view(): View
    {
        return view($this->getView(), [
            'datas' => $this->collection,
            'absentReason' => $this->getAbsentReason(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
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
     * Get the value of absentReason
     */ 
    public function getAbsentReason()
    {
        return $this->absentReason;
    }

    /**
     * Set the value of absentReason
     *
     * @return  self
     */ 
    public function setAbsentReason($absentReason)
    {
        $this->absentReason = $absentReason;

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
}
