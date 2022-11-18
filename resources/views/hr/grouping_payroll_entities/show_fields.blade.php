<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/groupingPayrollEntities.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $groupingPayrollEntity->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/groupingPayrollEntities.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $groupingPayrollEntity->name }}</p>
    </div>
</div>

