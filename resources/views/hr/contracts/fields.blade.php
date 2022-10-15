<!-- Type Field -->
<div class="form-group row mb-3">
    {!! Form::label('type', __('models/contracts.fields.type').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('type', null, ['class' => 'form-control','maxlength' => 1,'maxlength' => 1, 'required' => 'required']) !!}
</div>
</div>

<!-- Letter Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('letter_number', __('models/contracts.fields.letter_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('letter_number', null, ['class' => 'form-control','maxlength' => 27,'maxlength' => 27, 'required' => 'required']) !!}
</div>
</div>

<!-- Subject Field -->
<div class="form-group row mb-3">
    {!! Form::label('subject', __('models/contracts.fields.subject').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('subject', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/contracts.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4, 'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Start Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_date', __('models/contracts.fields.start_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('start_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'start_date']) !!}
</div>
</div>

<!-- End Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_date', __('models/contracts.fields.end_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('end_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'end_date']) !!}
</div>
</div>

<!-- Signed Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('signed_date', __('models/contracts.fields.signed_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('signed_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'signed_date']) !!}
</div>
</div>

<!-- Tags Field -->
<div class="form-group row mb-3">
    {!! Form::label('tags', __('models/contracts.fields.tags').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('tags', null, ['class' => 'form-control', 'rows' => 4]) !!}
</div>
</div>

<!-- Used Field -->
<div class="form-group row mb-3">
    {!! Form::label('used', __('models/contracts.fields.used').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('used', 0) !!}
        {!! Form::checkbox('used', '1', null) !!}
    </label>
</div>
</div>

