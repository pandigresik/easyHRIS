<!-- Serial Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('serial_number', __('models/fingerprintDevices.fields.serial_number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $fingerprintDevice->serial_number }}</p>
    </div>
</div>

<!-- Ip Field -->
<div class="form-group row mb-3">
    {!! Form::label('ip', __('models/fingerprintDevices.fields.ip').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $fingerprintDevice->ip }}</p>
    </div>
</div>

<!-- Display Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('display_name', __('models/fingerprintDevices.fields.display_name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $fingerprintDevice->display_name }}</p>
    </div>
</div>

