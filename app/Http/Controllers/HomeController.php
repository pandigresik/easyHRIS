<?php

namespace App\Http\Controllers;

use App\Models\Hr\JobLevel;
use App\Models\Hr\Leaf;
use App\Models\Hr\Overtime;
use App\Models\Hr\RequestWorkshift;

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
        $needApproval = $this->generateApprovalData();
        return view('home', ['needApproval' => $needApproval]);
    }

    public function tes(){
        
        $tes = (new JobLevel())->generateChartData(3);
        dd($tes);
    }    

    private function generateApprovalData(){
        $result = [];
        $employee = \Auth::user()->employee;
        $urlRequestWorkshiftApproval = route('hr.requestWorkshiftApproves.index');
        if(!$employee) return $result;
        $requestWorkshiftApproval = (new RequestWorkshift())->getNeedApproval($employee->id, $urlRequestWorkshiftApproval);
        
        if($requestWorkshiftApproval){
            $result[] = [
                'title' => 'Request Ganti Shift',
                'datas' => $requestWorkshiftApproval
            ];
        }
        $urlOvertimeApproval = route('hr.overtimeApproves.index');
        $overtimeApproval = (new Overtime())->getNeedApproval($employee->id, $urlOvertimeApproval);
        if($overtimeApproval){
            $result[] = [
                'title' => 'Request Overtime',
                'datas' => $overtimeApproval
            ];
        }

        $urlLeafApproval = route('hr.leaveApproves.index');
        $leafApproval = (new Leaf())->getNeedApproval($employee->id, $urlLeafApproval);
        if($leafApproval){
            $result[] = [
                'title' => 'Request Leave',
                'datas' => $leafApproval
            ];
        }
        return $result;   
    }
}
