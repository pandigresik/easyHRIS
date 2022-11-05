<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/payrollPeriodGroups.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriodGroup->name }}</p>
    </div>
</div>

<!-- Type Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('type_period', __('models/payrollPeriodGroups.fields.type_period').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriodGroup->type_period }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/payrollPeriodGroups.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriodGroup->description }}</p>
    </div>
</div>

