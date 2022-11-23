<!-- Serial Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('serial_number', __('models/fingerprintDevices.fields.serial_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('serial_number', null, ['class' => 'form-control','maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Ip Field -->
<div class="form-group row mb-3">
    {!! Form::label('ip', __('models/fingerprintDevices.fields.ip').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('ip', null, ['class' => 'form-control','maxlength' => 30,'maxlength' => 30, 'required' => 'required']) !!}
</div>
</div>

<!-- Port Field -->
<div class="form-group row mb-3">
    {!! Form::label('port', __('models/fingerprintDevices.fields.port').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('port', null, ['class' => 'form-control', 'placeholder' => 'default 4370','required' => 'required']) !!}
</div>
</div>

<!-- Display Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('display_name', __('models/fingerprintDevices.fields.display_name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('display_name', null, ['class' => 'form-control','maxlength' => 30,'maxlength' => 30, 'required' => 'required']) !!}
</div>
</div>
