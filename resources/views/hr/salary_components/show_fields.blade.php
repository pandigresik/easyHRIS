<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/salaryComponents.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryComponent->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/salaryComponents.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryComponent->name }}</p>
    </div>
</div>

<!-- State Field -->
<div class="form-group row mb-3">
    {!! Form::label('state', __('models/salaryComponents.fields.state').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryComponent->state }}</p>
    </div>
</div>

<!-- Fixed Field -->
<div class="form-group row mb-3">
    {!! Form::label('fixed', __('models/salaryComponents.fields.fixed').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryComponent->fixed }}</p>
    </div>
</div>

