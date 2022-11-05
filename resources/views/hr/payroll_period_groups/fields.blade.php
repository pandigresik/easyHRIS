<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/payrollPeriodGroups.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Type Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('type_period', __('models/payrollPeriodGroups.fields.type_period').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('type_period', $periodItems ,null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/payrollPeriodGroups.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4 ,'maxlength' => 255]) !!}
</div>
</div>
