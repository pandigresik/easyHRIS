<!-- Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('supervisor_id', __('models/employees.fields.supervisor_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('supervisor_id', $supervisorItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
    </div>
</div>

<hr>
<div id="div-filter">
<fieldset>
    <legend>Filter</legend>

    <!-- Company Id Field -->
    <div class="form-group row mb-3">
        {!! Form::label('company_id', __('models/employees.fields.company_id').':', ['class' => 'col-md-3
        col-form-label']) !!}
        <div class="col-md-9">
            {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' =>
            'required']) !!}
        </div>
    </div>

    <!-- Department Id Field -->
    <div class="form-group row mb-3">
        {!! Form::label('department_id', __('models/employees.fields.department_id').':', ['class' => 'col-md-3
        col-form-label']) !!}
        <div class="col-md-9">
            {!! Form::select('department_id', $departmentItems, null, ['class' => 'form-control select2', 'required' =>
            'required']) !!}
        </div>
    </div>

    <!-- Business Unit Id Field -->
    <div class="form-group row mb-3">
        {!! Form::label('business_unit_id', __('models/employees.fields.business_unit_id').':', ['class' => 'col-md-3
        col-form-label']) !!}
        <div class="col-md-9">
            {!! Form::select('business_unit_id[]', $businessUnitItems, null, ['class' => 'form-control select2',
            'multiple' => 'multiple']) !!}
        </div>
    </div>

    <!-- Joblevel Id Field -->
    <div class="form-group row mb-3">
        {!! Form::label('joblevel_id', __('models/employees.fields.joblevel_id').':', ['class' => 'col-md-3
        col-form-label']) !!}
        <div class="col-md-9">
            {!! Form::select('joblevel_id[]', $joblevelItems, null, ['class' => 'form-control select2', 'multiple' =>
            'multiple']) !!}
        </div>
    </div>    

    <!-- Jobtitle Id Field -->
    <div class="form-group row mb-3">
        {!! Form::label('jobtitle_id', __('models/employees.fields.jobtitle_id').':', ['class' => 'col-md-3
        col-form-label']) !!}
        <div class="col-md-9">
            {!! Form::select('jobtitle_id[]', $jobtitleItems, null, ['class' => 'form-control select2', 'multiple' =>
            'multiple']) !!}
        </div>
    </div>

    <!-- Joblevel Id Field -->
    <div class="form-group row mb-3">        
        <div class="col-md-9 offset-3">
            {!! Form::button(__('crud.choose'), ['class' => 'btn btn-primary', 'data-url' => route('hr.employeeSupervisors.list') ,'onclick' => 'showListEmployee(this)']) !!}
        </div>
    </div>
</fieldset>
</div>
<div class="form-group row mb-3">
    <div class="col-md-9 offset-3">
        <div id="list-employee">

        </div>
    </div>    
</div>
