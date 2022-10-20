<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/workshiftGroups.fields.shiftment_group_id').':', ['class' =>
    'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('shiftment_group_id', $shiftmentGroupItems, null, ['class' => 'form-control select2', 'required' => 'required', 'onchange' => 'updateFilterEmployee(this)']) !!}
    </div>
</div>

<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/workshifts.fields.employee_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('employee_id', [], null, array_merge(['class' => 'form-control select2','data-filter' => json_encode(['tes' => 'ok']), 'data-url' => route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository' ], config('local.select2.ajax')) ) !!}
    </div>
</div>

<!-- Work Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_date', __('models/workshifts.fields.work_date').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        {!! Form::text('work_date', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode(config('local.daterange')),'id'=>'work_date']) !!}
    </div>
</div>

<!-- Generate button -->
<div class="form-group row mb-3">
    <div class="col-md-9 offset-3">
        {!! Form::button(__('crud.generate'), ['class' => 'btn btn-danger', 'data-target' => '#list_workshift', 'data-url' => route('hr.workshifts.generate'), 'data-json' => '{}', 'data-ref' => 'input[name=work_date],select[name="shiftment_group_id"]' ,'onclick' => 'main.loadDetailPage(this,\'get\', function(){ main.initCalendar($(\'form\'));main.showLoading(false) })', 'type' => 'button']) !!}
    </div>
    <div class="row" id="list_workshift">

    </div>
</div>

@push('scripts')
<script>
    function updateFilterEmployee(elm){
        if(!_.isEmpty($(elm).val())){
            $('#employee_id').data('filter', {shiftment_group_id : $(elm).val()});
        }        
    }

</script>
@endpush