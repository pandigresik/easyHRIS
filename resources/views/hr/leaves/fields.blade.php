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

<div class="form-group row mb-3">    
    <div class="col-md-9 offset-3"> 
        <button type="button" class="btn btn-warning" onclick="loadEmployeeFiltered(this)">Select All Employee (Filtered)</button>
    </div>
</div>
@endcan

<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/leaves.fields.employee_id').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        @if(empty($employeeItems))
        {!! Form::select('employee_id[]', $employeeItems, null, array_merge(['class' => 'form-control select2',
        'required' => 'required', 'id' => 'employee_id','data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository'
        => 'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple' ], config('local.select2.ajax')) ) !!}
        @else
        {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2'] ) !!}
        @endif
    </div>
</div>

<!-- Reason Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('reason_id', __('models/leaves.fields.reason_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('reason_id', $reasonItems, null, ['class' => 'form-control select2', 'required' => 'required'])
        !!}
    </div>
</div>

<!-- Leave Start Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_start', __('models/leaves.fields.leave_start').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        {!! Form::text('leave_start', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode(config('local.datetime')),'id'=>'leave_start']) !!}
    </div>
</div>

<!-- Leave End Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_end', __('models/leaves.fields.leave_end').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('leave_end', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode(config('local.datetime')),'id'=>'leave_end']) !!}
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/leaves.fields.description').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3,'maxlength' => 255,'maxlength'
        => 255, 'required' => 'required']) !!}
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('file_upload', __('models/leaves.fields.file_upload').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        @if (isset($leaf) && !empty($leaf->path_file))
        <div>
            <a href="{{ Storage::url('').'?path='.$leaf->path_file }}" target="_blank" rel="noopener noreferrer">file
                attachment</a>
        </div>
        @endif
        {!! Form::file('file_upload') !!}
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
        if(!_.isEmpty(_payrollPeriod)){
            _filter['payroll_period_group_id'] = _payrollPeriod
        }
        if(!_.isEmpty(_supervisor)){
            _filter['supervisor_id'] = _supervisor
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