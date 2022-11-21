<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', 'Name:', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>

<!-- Email Field -->
<div class="form-group row mb-3">
    {!! Form::label('email', 'Email:', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
    {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>

<!-- Password Field -->
@if (!isset($user))
<div class="form-group row mb-3">
    {!! Form::label('password', 'Password:', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
    {!! Form::password('password', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>
@endif

<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/workshifts.fields.employee_id').':', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
        {!! Form::select('employee_id', $employeeItems, null, array_merge(['class' => 'form-control select2', 'id' => 'employee_id', 'data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository'], config('local.select2.ajax')) ) !!} 
    </div>
</div>

<!-- List Permission Field -->
@include('base.users.role_fields')

<!-- Submit Field -->
<div class="form-group col-sm-12 mt-2">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('base.users.index') }}" class="btn btn-secondary">Cancel</a>
</div>
