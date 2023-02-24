<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\PayrollPeriodDataTable;

use App\Http\Requests\Hr\CreatePayrollPeriodRequest;
use App\Http\Requests\Hr\UpdatePayrollPeriodRequest;
use App\Repositories\Hr\PayrollPeriodRepository;
use App\Repositories\Base\CompanyRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\PayrollPeriod;
use Carbon\Carbon;
use Response;
use Exception;

class PayrollPeriodController extends AppBaseController
{
    /** @var  PayrollPeriodRepository */
    protected $repository;
    protected $type;
    protected $viewPath = 'hr.payroll_periods';
    protected $routePath = 'hr.payrollPeriods';
    
    public function __construct()
    {
        $this->repository = PayrollPeriodRepository::class;        
    }

    /**
     * Display a listing of the PayrollPeriod.
     *
     * @param PayrollPeriodDataTable $payrollPeriodDataTable
     * @return Response
     */
    public function index(PayrollPeriodDataTable $payrollPeriodDataTable)
    {
        if(!empty($this->type)){
            return $payrollPeriodDataTable->setRoutePath($this->routePath)->setTypePeriod($this->type)->render($this->viewPath.'.index', ['routePath' => $this->routePath]);    
        }
        return $payrollPeriodDataTable->render($this->viewPath.'.index', ['routePath' => $this->routePath]);
    }

    /**
     * Show the form for creating a new PayrollPeriod.
     *
     * @return Response
     */
    public function create()
    {
        $nextPeriod = $this->getNextPeriodPayroll();
        $paramDate = ['startDate' => is_null($nextPeriod) ? localFormatDate(Carbon::now()->startOfMonth()) : localFormatDate($nextPeriod)];
        $paramDate['endDate'] = localFormatDate($this->getEndNextPeriodPayroll($nextPeriod));
        return view($this->viewPath.'.create')->with($this->getOptionItems())->with($paramDate);
    }

    /**
     * Store a newly created PayrollPeriod in storage.
     *
     * @param CreatePayrollPeriodRequest $request
     *
     * @return Response
     */
    public function store(CreatePayrollPeriodRequest $request)
    {
        $input = $request->all();        
        $payrollPeriod = $this->getRepositoryObj()->setPayrollPeriod($this->type)->create($input);
        if($payrollPeriod instanceof Exception){
            $workDate = explode('__',$input['range_period']);
            $input['range_period'] = localFormatDate($workDate[0]).' - '.localFormatDate($workDate[1]);
            return redirect()->back()->withInput($input)->withErrors(['error', $payrollPeriod->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/payrollPeriods.singular')]));

        return redirect(route($this->routePath.'.index'));
    }

    /**
     * Display the specified PayrollPeriod.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('models/payrollPeriods.singular').' '.__('messages.not_found'));

            return redirect(route($this->routePath.'.index'));
        }

        return view($this->viewPath.'.show')->with('payrollPeriod', $payrollPeriod);
    }

    /**
     * Show the form for editing the specified PayrollPeriod.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriods.singular')]));

            return redirect(route($this->routePath.'.index'));
        }
        
        return view($this->viewPath.'.edit')->with('payrollPeriod', $payrollPeriod)->with($this->getOptionItems());
    }

    /**
     * Update the specified PayrollPeriod in storage.
     *
     * @param  int              $id
     * @param UpdatePayrollPeriodRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayrollPeriodRequest $request)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriods.singular')]));

            return redirect(route($this->routePath.'.index'));
        }

        $payrollPeriod = $this->getRepositoryObj()->update($request->all(), $id);
        if($payrollPeriod instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $payrollPeriod->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/payrollPeriods.singular')]));

        return redirect(route($this->routePath.'.index'));
    }

    /**
     * Remove the specified PayrollPeriod from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriods.singular')]));

            return redirect(route($this->routePath.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/payrollPeriods.singular')]));

        return redirect(route($this->routePath.'.index'));
    }

    /**
     * Provide options item based on relationship model PayrollPeriod from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    protected function getOptionItems(){
        $company = new CompanyRepository();        
        return [
            'companyItems' => $company->pluck(),
            'routePath' => $this->routePath         
        ];
    }

    protected function getNextPeriodPayroll(){
        $result = NULL;
        switch($this->type){
            case 'weekly':
                $lastPeriod = PayrollPeriod::weekly()->orderBy('end_period', 'desc')->first();
                break;
            case 'biweekly':
                $lastPeriod = PayrollPeriod::biweekly()->orderBy('end_period', 'desc')->first();
                break;
            default:            
                $lastPeriod = PayrollPeriod::monthly()->orderBy('end_period', 'desc')->first();                
        }
        
        if($lastPeriod){
            $result = Carbon::parse($lastPeriod->getRawOriginal('end_period'))->addDay()->format('Y-m-d');
        }
        
        return $result;
    }

    protected function getEndNextPeriodPayroll($startPeriod){
        $endPeriod = NULL;
        if(is_null($startPeriod)) return Carbon::now()->format('Y-m-d');
        $tmpPeriod = Carbon::parse($startPeriod);
        switch($this->type){
            case 'weekly':
                $tmpPeriod->addDays(6);
                break;
            case 'biweekly':
                $tmpPeriod->addDays(13);
                break;
            case 'monthly':
                // $tmpPeriod->endOfMonth();
                $tmpPeriod->addWeeks(2)->endOfMonth()->subDays(2);
                break;
        }
        $endPeriod = $tmpPeriod->format('Y-m-d');
        return $endPeriod;
    }
}
