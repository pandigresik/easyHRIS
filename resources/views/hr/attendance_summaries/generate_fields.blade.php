<div class="alert alert-danger">
    Pastikan data absensi sudah diproses dan tidak ada yang berstatus <span class="badge bg-danger">INVALID</span> untuk periode tanggal yang akan dihitung summary kehadiran sebagai dasar perhitungan premi kehadiran
</div>
<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/attendanceSummaries.fields.company_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' =>
        'required']) !!}
    </div>
</div>

<!-- Payroll Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('payroll_group_period_id', __('models/payrollPeriods.fields.payroll_period_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9"> 
        {!! Form::select('payroll_group_period_id[]', $payrollGroupItems, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
    </div>
</div>

<!-- Start Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/attendanceSummaries.fields.employee_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('employee_id[]', [], null, array_merge(['class' => 'form-control select2','id' =>
        'employee_id', 'data-filter' => json_encode([]), 'data-url' =>
        route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple' ],
        config('local.select2.ajax')) ) !!}        
    </div>
</div>

<!-- Start Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('range_period', __('models/attendanceSummaries.fields.range_period').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('range_period', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode( array_merge(['ranges' => $range, 'startDate' => $startDate, 'endDate' => $endDate, 'showCustomRangeLabel' => false],config('local.daterange')) ),'id'=>'range_period']) !!}
    </div>
</div>
