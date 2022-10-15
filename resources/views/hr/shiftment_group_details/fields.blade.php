<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/shiftmentGroupDetails.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('shiftment_id', $shiftmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Sequence Field -->
<div class="form-group row mb-3">
    {!! Form::label('sequence', __('models/shiftmentGroupDetails.fields.sequence').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('sequence', null, ['class' => 'form-control inputmask', 'required' => 'required', 'data-optionmask' => json_encode(config('local.number.integer'))]) !!}
</div>
</div>

