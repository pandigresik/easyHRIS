<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/workshiftGroups.fields.shiftment_group_id').':', ['class' =>
    'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
        {!! Form::select('shiftment_group_id', $shiftmentGroupItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
    </div>
</div>

<!-- Work Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_date', __('models/workshiftGroups.fields.work_date').':', ['class' => 'col-md-2
    col-form-label']) !!}
    <div class="col-md-10">
        {!! Form::text('work_date', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode(config('local.daterange')),'id'=>'work_date']) !!}
    </div>
</div>

<!-- Generate button -->
<div class="form-group row mb-3">
    <div class="col-md-10 offset-2">
        {!! Form::button(__('crud.generate'), ['class' => 'btn btn-danger', 'data-target' => '#list_workshift_group', 'data-url' => route('hr.workshiftGroups.generate'), 'data-json' => '{}', 'data-ref' => 'input[name=work_date],select[name="shiftment_group_id"]' ,'onclick' => 'main.loadDetailPage(this,\'get\', function(){ main.initCalendar($(\'form\'));main.showLoading(false) })', 'type' => 'button']) !!}
    </div>
    <div class="row" id="list_workshift_group">

    </div>
</div>
