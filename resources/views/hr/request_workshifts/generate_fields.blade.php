@can('user-hr')
<!-- Employee Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('supervisor_id', __('models/employees.fields.supervisor_id').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        {!! Form::select('supervisor_id', $supervisorItems, null, ['class' => 'form-control select2', 'onchange' =>
        'updateFilterEmployee(this)'] ) !!}
    </div>
</div>

<!-- Payroll Period Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('payroll_period_group_id', __('models/employees.fields.payroll_period_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9"> 
        {!! Form::select('payroll_period_group_id', $payrollPeriodGroupItems, null, ['class' => 'form-control select2', 'onchange' =>
        'updateFilterEmployee(this)'] ) !!}
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
        {!! Form::select('shiftment_group_id', $shiftmentGroupItems, null, ['id' => 'shiftment_group_id', 'class' => 'form-control select2', 'onchange' => 'updateFilterEmployee(this)']) !!}
    </div>
</div>

<div class="form-group row mb-3">    
    <div class="col-md-9 offset-3"> 
        <button type="button" class="btn btn-warning" onclick="loadEmployeeFiltered(this)">Select All Employee (Filtered)</button>
    </div>
</div>
@endcan
<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/requestWorkshifts.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id[]', [], null, array_merge(['class' => 'form-control select2','id' => 'employee_id', 'data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple'], config('local.select2.ajax')) ) !!}
</div>
</div>

<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/requestWorkshifts.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('shiftment_id', $shiftmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Work Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_date', __('models/requestWorkshifts.fields.work_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('work_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( config('local.daterange')),'id'=>'work_date']) !!}
</div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/requestWorkshifts.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('description', null, ['class' => 'form-control','rows' => 4,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>



@push('scripts')
<script>
    function updateFilterEmployee(elm) {
        $('#employee_id').data('filter', {})
        $('#employee_id').val('').trigger('change')
        let _filter = {}
        let _payrollPeriod = $('select[name=payroll_period_group_id]').val()
        let _supervisor = $('select[name=supervisor_id]').val()
        let _jobtitle = $('select[name^=jobtitle_id]').val()
        let _shiftmentGroup = $('select[name=shiftment_group_id]').val()

        if(!_.isEmpty(_payrollPeriod)){
            _filter['payroll_period_group_id'] = _payrollPeriod
        }
        if(!_.isEmpty(_supervisor)){
            _filter['supervisor_id'] = _supervisor
        }

        if(!_.isEmpty(_jobtitle)){
            _filter['jobtitle_id'] = _jobtitle
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