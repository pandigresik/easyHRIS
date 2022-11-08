<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/payrollPeriods.fields.company_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' =>
        'required']) !!}
    </div>
</div>

<!-- Period group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('payroll_period_group_id', __('models/payrollPeriods.fields.payroll_period_group_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('payroll_period_group_id', $periodItems, null, ['class' => 'form-control select2', 'required' =>
        'required', 'onchange' => 'updateFilterEmployee(this)']) !!}
    </div>
</div>

<!-- Start Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/payrollPeriods.fields.employee_id').':', ['class' => 'col-md-3
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
    {!! Form::label('range_period', __('models/payrollPeriods.fields.range_period').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('range_period', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode( array_merge(['startDate' => $startDate, 'endDate' => $endDate
        ],config('local.daterange')) ),'id'=>'range_period']) !!}
    </div>
</div>

<!-- Start Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('bpjs_fee', __('models/payrollPeriods.fields.bpjs_fee').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        @foreach($bpjsFees as $idBpjs => $bpjsName)
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" name="bpjs_fee[]" value="{{ $idBpjs }}" class="form-check-input">
                {{ $bpjsName }}
                <i class="input-helper"></i>
            </label>
        </div>
        @endforeach
        
    </div>
</div>


@push('scripts')
<script>
    function updateFilterEmployee(elm){
        if(!_.isEmpty($(elm).val())){
            $('#employee_id').data('filter', {payroll_period_group_id : $(elm).val()});
        }        
    }

</script>
@endpush