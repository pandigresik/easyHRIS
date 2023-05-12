@extends('layouts.app')

@section('content')
@push('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">
        <a href="{!! route('hr.requestWorkshiftPermanents.index') !!}">@lang('models/requestWorkshifts.singular') Permanent</a>
    </li>
</ol>
@endpush
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open(['route' => 'hr.requestWorkshiftPermanents.index']) !!}
                <div class="card">
                    <div class="card-header">                        
                        <strong>@lang('models/requestWorkshifts.singular') Permanent and Update Workshift Employee</strong>
                    </div>
                    <div class="card-body">
                        <!-- Period Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('period', __('models/requestWorkshifts.fields.startFrom').':', ['class' =>
                            'col-md-3 col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('start_from', null, ['class' => 'form-control datetime', 'data-optiondate' =>
                                json_encode(config('local.datesingle') + ['minDate' => $minDate]), 'onchange' => 'updateFilterEmployee(this)']) !!}
                            </div>
                        </div>              
                        
                        <!-- Employee Supervisor Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('supervisor_id', __('models/employees.fields.supervisor_id').':', ['class' => 'col-md-3 col-form-label'])
                            !!}
                            <div class="col-md-9">
                                {!! Form::select('supervisor_id', $supervisorItems, null, ['class' => 'form-control select2', 'onchange' =>
                                'updateFilterEmployee(this)'] ) !!}
                            </div>
                        </div>
                        
                        <!-- Fingerprint Device Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('payroll_group_period', __('models/payrollPeriods.fields.payroll_period_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
                            <div class="col-md-9"> 
                                {!! Form::select('payroll_period_group_id', $payrollGroupItems, null, ['class' => 'form-control select2', 'onchange' => 'updateFilterEmployee(this)']) !!}
                            </div>
                        </div>

                        <!-- Company Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('company_id', __('models/employees.fields.company_id').':', ['class' => 'col-md-3
                            col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' =>
                                'required', 'onchange' => 'updateFilterEmployee(this)']) !!}
                            </div>
                        </div>

                        <!-- Department Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('department_id', __('models/employees.fields.department_id').':', ['class' => 'col-md-3
                            col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('department_id', $departmentItems, null, ['class' => 'form-control select2', 'onchange' => 'updateFilterEmployee(this)']) !!}
                            </div>
                        </div>

                        <!-- Business Unit Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('business_unit_id', __('models/employees.fields.business_unit_id').':', ['class' => 'col-md-3
                            col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('business_unit_id[]', $businessUnitItems, null, ['class' => 'form-control select2',
                                'multiple' => 'multiple', 'onchange' => 'updateFilterEmployee(this)']) !!}
                            </div>
                        </div>

                        <!-- Joblevel Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('joblevel_id', __('models/employees.fields.joblevel_id').':', ['class' => 'col-md-3
                            col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('joblevel_id[]', $joblevelItems, null, ['class' => 'form-control select2', 'multiple' =>
                                'multiple', 'onchange' => 'updateFilterEmployee(this)']) !!}
                            </div>
                        </div>    

                        <!-- Jobtitle Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('jobtitle_id', __('models/employees.fields.jobtitle_id').':', ['class' => 'col-md-3
                            col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('jobtitle_id[]', $jobtitleItems, null, ['class' => 'form-control select2', 'multiple' =>
                                'multiple', 'onchange' => 'updateFilterEmployee(this)']) !!}
                            </div>
                        </div>
                        
                        <!-- Shiftment Group Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('shiftment_group_id', __('models/requestWorkshifts.fields.shiftment_group_id_current').':', ['class' =>
                            'col-md-3 col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('shiftment_group_id', $shiftmentGroupItems, null, ['id' => 'shiftment_group_id', 'class' => 'form-control select2', 'required' => 'required', 'onchange' => 'updateFilterEmployee(this)']) !!}                                
                            </div>
                        </div>

                        <div class="form-group row mb-3">    
                            <div class="col-md-9 offset-3"> 
                                <button type="button" class="btn btn-warning" onclick="loadEmployeeFiltered(this)">Select All Employee (Filtered)</button>
                            </div>
                        </div>
                        <hr>
                        <!-- Employee Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('employee_id', __('models/workshifts.fields.employee_id').':', ['class' => 'col-md-3
                            col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('employee_id[]', [], null, array_merge(['class' => 'form-control select2',
        'required' => 'required', 'id' => 'employee_id','data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository'
        => 'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple' ], config('local.select2.ajax')) ) !!}
                            </div>
                        </div>                                                

                        <!-- Shiftment Group Id Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('shiftment_group_id_destination', __('models/requestWorkshifts.fields.shiftment_group_id_destination').':', ['class' =>
                            'col-md-3 col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('shiftment_group_id_destination', $shiftmentGroupItems, null, ['id' => 'shiftment_group_id_destination', 'class' => 'form-control select2', 'required' => 'required']) !!}                                
                            </div>
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group row mb-3">
                            <div class="col-md-9 offset-3">
                                {!! Form::button('simulasi', ['class' => 'btn btn-danger','value'=> 1, 'data-url' => route('hr.requestWorkshiftPermanents.index'), 'data-target' => '#list-workshift-simulation', 'data-ref' => 'input[name=start_from],select[name=payroll_group_period_id],select[name^=employee_id],select[name=shiftment_group_id],select[name=shiftment_group_id_destination]' ,'onclick' => 'main.loadDetailPage(this, \'get\')']) !!}
                            </div>                            
                        </div> 

                        <div class="">
                            <div class="table-responsive" id="list-workshift-simulation"></div>
                        </div>
                    </div>                    
                </div>
                <div class="card-footer">
                    <!-- Submit Field -->
                    <div class="form-group col-sm-12 mt-2">
                        {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('hr.requestWorkshifts.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateFilterEmployee(elm) {
        $('#employee_id').data('filter', {})
        $('#employee_id').val('').trigger('change')
        let _filter = {}
        let _payrollPeriod = $('select[name=payroll_period_group_id]').val()
        let _supervisor = $('select[name=supervisor_id]').val()
        let _company = $('select[name=company_id]').val()
        let _groupingPayroll = $('select[name=grouping_payroll_entity_id]').val()
        let _department = $('select[name=department_id]').val()
        let _bussines = $('select[name^=business_unit_id]').val()
        let _joblevel = $('select[name^=joblevel_id]').val()
        let _jobtitle = $('select[name^=jobtitle_id]').val()
        let _shiftmentGroup = $('select[name=shiftment_group_id]').val()
        
        if(!_.isEmpty(_payrollPeriod)){
            _filter['payroll_period_group_id'] = _payrollPeriod
        }
        if(!_.isEmpty(_supervisor)){
            _filter['supervisor_id'] = _supervisor
        }

        if(!_.isEmpty(_company)){
            _filter['company_id'] = _company
        }

        if(!_.isEmpty(_department)){
            _filter['department_id'] = _department
        }

        if(!_.isEmpty(_bussines)){
            _filter['business_unit_id'] = _bussines
        }

        if(!_.isEmpty(_jobtitle)){
            _filter['jobtitle_id'] = _jobtitle
        }

        if(!_.isEmpty(_joblevel)){
            _filter['joblevel_id'] = _joblevel
        }

        if(!_.isEmpty(_shiftmentGroup)){
            _filter['shiftment_group_id'] = _shiftmentGroup
        }

        if (!_.isEmpty(_filter)) {
            $('#employee_id').data('filter', _filter)
        }
    }

    function loadEmployeeFiltered(elm){
        let _filter = $('#employee_id').data('filter')
        let _url = $('#employee_id').data('url')
        let _repository = $('#employee_id').data('repository')

        $.ajax({
            url: _url,
            type: 'get',
            dataType: 'json',
            delay: 500,
            data: {                
                repository: _repository,
                filter: _filter,
                limit: 1000000 // set unlimited
            },
            beforeSend: function(){
                main.showLoading(true)
            },
            success: function(data){
                main.showLoading(false)
                let _employees = data.data                                
                for(let i in _employees){
                    var newOption = new Option(_employees[i].text, _employees[i].id, true, true)
                    // Append it to the select
                    $('#employee_id').append(newOption)
                }
                $('#employee_id').trigger('change');
            },
            error: function (xhr, status, text) {
                main.showLoading(false)
				const pesan = xhr.responseText;
				bootbox.alert('Terjadi error di server \n' + pesan, function () {});
			}
        })
    }
</script>
@endpush