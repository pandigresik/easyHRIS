<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/shiftmentGroupDetails.fields.shiftment_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentGroupDetail->shiftment_group_id }}</p>
    </div>
</div>

<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/shiftmentGroupDetails.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentGroupDetail->shiftment_id }}</p>
    </div>
</div>

<!-- Sequence Field -->
<div class="form-group row mb-3">
    {!! Form::label('sequence', __('models/shiftmentGroupDetails.fields.sequence').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentGroupDetail->sequence }}</p>
    </div>
</div>

