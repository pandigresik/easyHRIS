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
        if (!_.isEmpty($(elm).val())) {
            $('#employee_id').data('filter', {
                supervisor_id: $(elm).val()
            })
        }
    }
</script>
@endpush