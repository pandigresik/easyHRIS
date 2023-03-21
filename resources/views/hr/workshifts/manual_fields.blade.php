<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/workshiftGroups.fields.shiftment_group_id').':', ['class' =>
    'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
        {!! Form::select('shiftment_group_id[]', $shiftmentGroupItems, null, ['class' => 'form-control select2', 'id' => 'manual_shiftment_group_id', 'required' => 'required', 'onchange' => 'updateFilterEmployeeManual(this)', 'multiple' => 'multiple']) !!}
        <label class="checkbox-inline">                                            
            {!! Form::checkbox('', '1', null,['onchange' => 'main.select2AllOption(this,\'#manual_shiftment_group_id\')']) !!}
            pilih semua
        </label>
    </div>
</div>

<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/workshifts.fields.employee_id').':', ['class' => 'col-md-2
    col-form-label']) !!}
    <div class="col-md-10">
        {!! Form::select('employee_id[]', [], null, array_merge(['class' => 'form-control select2','id' => 'manual_employee_id', 'data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple' ], config('local.select2.ajax')) ) !!}
    </div>
</div>

<!-- Work Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_date', __('models/workshifts.fields.work_date').':', ['class' => 'col-md-2 col-form-label'])
    !!}
    <div class="col-md-10">
        {!! Form::text('work_date_period', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode(config('local.daterange')),'id'=>'manual_work_date']) !!}
    </div>
</div>

<!-- Generate button -->
<div class="form-group row mb-3">
    <div class="col-md-10 offset-2">
        {!! Form::button(__('crud.generate'), ['class' => 'btn btn-danger', 'data-target' => '#manual_list_workshift', 'data-url' => route('hr.workshifts.manual'), 'data-json' => '{}', 'data-ref' => '#manual_employee_id,#manual_work_date,#manual_shiftment_group_id' ,'onclick' => 'main.loadDetailPage(this,\'get\', function(){ main.initSelect($(\'#manual_list_workshift\'));main.showLoading(false) })', 'type' => 'button']) !!}
    </div>
    <div class="row" id="manual_list_workshift">

    </div>
</div>

@push('scripts')
<script>
    function updateFilterEmployeeManual(elm){
        if(!_.isEmpty($(elm).val())){
            $('#manual_employee_id').data('filter', {shiftment_group_id : $(elm).val()});
        }        
    }

</script>
@endpush