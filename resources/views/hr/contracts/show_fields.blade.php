<!-- Type Field -->
<div class="form-group row mb-3">
    {!! Form::label('type', __('models/contracts.fields.type').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->type }}</p>
    </div>
</div>

<!-- Letter Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('letter_number', __('models/contracts.fields.letter_number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->letter_number }}</p>
    </div>
</div>

<!-- Subject Field -->
<div class="form-group row mb-3">
    {!! Form::label('subject', __('models/contracts.fields.subject').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->subject }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/contracts.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->description }}</p>
    </div>
</div>

<!-- Start Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_date', __('models/contracts.fields.start_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->start_date }}</p>
    </div>
</div>

<!-- End Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_date', __('models/contracts.fields.end_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->end_date }}</p>
    </div>
</div>

<!-- Signed Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('signed_date', __('models/contracts.fields.signed_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->signed_date }}</p>
    </div>
</div>

<!-- Tags Field -->
<div class="form-group row mb-3">
    {!! Form::label('tags', __('models/contracts.fields.tags').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->tags }}</p>
    </div>
</div>

<!-- Used Field -->
<div class="form-group row mb-3">
    {!! Form::label('used', __('models/contracts.fields.used').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $contract->used }}</p>
    </div>
</div>

