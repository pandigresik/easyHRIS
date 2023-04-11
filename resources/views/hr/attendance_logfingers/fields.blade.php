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
@endcan


<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/attendanceLogfingers.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9">
    @if (empty($employeeItems))
    {!! Form::select('employee_id[]', $employeeItems, null, array_merge(['class' => 'form-control select2','id' => 'employee_id', 'data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple' ], config('local.select2.ajax')) ) !!}    
    @else
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2','id' => 'employee_id', 'data-filter' => json_encode([])] ) !!}
    @endif
    
</div>
</div>

<!-- Type Absen Field -->
<div class="form-group row mb-3">
    {!! Form::label('type_absen', __('models/attendanceLogfingers.fields.type_absen').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('type_absen', $absentTypeItems, null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Fingertime Field -->
<div class="form-group row mb-3">
    {!! Form::label('fingertime', __('models/attendanceLogfingers.fields.fingertime').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('fingertime', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( config('local.datetime') ),'id'=>'fingertime']) !!}
</div>
</div>

<!-- Fingerprint Device Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('fingerprint_device_id', __('models/attendanceLogfingers.fields.fingerprint_device_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('fingerprint_device_id', $fingerprintDeviceItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Fingerprint Reason Field -->
<div class="form-group row mb-3">
    {!! Form::label('reason', __('models/attendanceLogfingers.fields.reason').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('reason', $reasonItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

@push('scripts')
<script>
    function updateFilterEmployee(elm) {
        $('#employee_id').data('filter', {})
        if (!_.isEmpty($(elm).val())) {
            $('#employee_id').data('filter', {
                supervisor_id: $(elm).val()
            })
        }
    }
</script>
@endpush