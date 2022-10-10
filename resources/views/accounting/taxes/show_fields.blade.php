<!-- Period Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('period_id', __('models/taxes.fields.period_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $tax->period_id }}</p>
    </div>
</div>

<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/taxes.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $tax->employee_id }}</p>
    </div>
</div>

<!-- Tax Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_group', __('models/taxes.fields.tax_group').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $tax->tax_group }}</p>
    </div>
</div>

<!-- Untaxable Field -->
<div class="form-group row mb-3">
    {!! Form::label('untaxable', __('models/taxes.fields.untaxable').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $tax->untaxable }}</p>
    </div>
</div>

<!-- Taxable Field -->
<div class="form-group row mb-3">
    {!! Form::label('taxable', __('models/taxes.fields.taxable').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $tax->taxable }}</p>
    </div>
</div>

<!-- Tax Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_value', __('models/taxes.fields.tax_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $tax->tax_value }}</p>
    </div>
</div>

<!-- Tax Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_key', __('models/taxes.fields.tax_key').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $tax->tax_key }}</p>
    </div>
</div>

