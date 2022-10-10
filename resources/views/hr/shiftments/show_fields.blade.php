<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/shiftments.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftment->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/shiftments.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftment->name }}</p>
    </div>
</div>

<!-- Start Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_hour', __('models/shiftments.fields.start_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftment->start_hour }}</p>
    </div>
</div>

<!-- End Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_hour', __('models/shiftments.fields.end_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftment->end_hour }}</p>
    </div>
</div>

