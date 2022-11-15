<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/workshiftGroups.fields.shiftment_group_id').':', ['class' =>
    'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
        {!! Form::select('shiftment_group_id[]', $shiftmentGroupItems, null, ['id' => 'shiftment_group_id', 'class' => 'form-control select2', 'required' => 'required', 'multiple' => 'multiple', 'onchange' => 'updateFilterEmployee(this)']) !!}
        <label class="checkbox-inline">                                            
            {!! Form::checkbox('', '1', null,['onchange' => 'main.select2AllOption(this,\'#shiftment_group_id\')']) !!}
            pilih semua
        </label>
    </div>
</div>

<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/workshifts.fields.employee_id').':', ['class' => 'col-md-2
    col-form-label']) !!}
    <div class="col-md-10">
        {!! Form::select('employee_id[]', [], null, array_merge(['class' => 'form-control select2', 'id' => 'employee_id', 'data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple' ], config('local.select2.ajax')) ) !!}        
    </div>
</div>


<!-- Work Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_date', __('models/workshifts.fields.work_date').':', ['class' => 'col-md-2 col-form-label'])
    !!}
    <div class="col-md-10">
        {!! Form::text('work_date_period', null, ['class' => 'form-control datetime', 'required' => 'required'
        ,'data-optiondate' => json_encode(config('local.daterange')),'id'=>'work_date']) !!}
    </div>
</div>

@push('scripts')
<script>
    function updateFilterEmployee(elm){
        $('#employee_id').data('filter', {})
        if(!_.isEmpty($(elm).val())){            
            $('#employee_id').data('filter', {shiftment_group_id : $(elm).val()})
        }
    }

</script>
@endpush