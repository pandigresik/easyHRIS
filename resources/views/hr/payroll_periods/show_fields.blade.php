<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/payrollPeriods.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriod->company_id }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/payrollPeriods.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriod->name }}</p>
    </div>
</div>

<!-- Year Field -->
<div class="form-group row mb-3">
    {!! Form::label('year', __('models/payrollPeriods.fields.year').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriod->year }}</p>
    </div>
</div>

<!-- Month Field -->
<div class="form-group row mb-3">
    {!! Form::label('month', __('models/payrollPeriods.fields.month').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriod->month }}</p>
    </div>
</div>

<!-- Start Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_period', __('models/payrollPeriods.fields.start_period').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriod->start_period }}</p>
    </div>
</div>

<!-- End Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_period', __('models/payrollPeriods.fields.end_period').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriod->end_period }}</p>
    </div>
</div>

<!-- Closed Field -->
<div class="form-group row mb-3">
    {!! Form::label('closed', __('models/payrollPeriods.fields.closed').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollPeriod->closed }}</p>
    </div>
</div>

