<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/salaryBenefitHistories.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefitHistory->employee_id }}</p>
    </div>
</div>

<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryBenefitHistories.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefitHistory->component_id }}</p>
    </div>
</div>

<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/salaryBenefitHistories.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefitHistory->contract_id }}</p>
    </div>
</div>

<!-- New Benefit Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_benefit_value', __('models/salaryBenefitHistories.fields.new_benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefitHistory->new_benefit_value }}</p>
    </div>
</div>

<!-- Old Benefit Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_benefit_value', __('models/salaryBenefitHistories.fields.old_benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefitHistory->old_benefit_value }}</p>
    </div>
</div>

<!-- Benefit Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_key', __('models/salaryBenefitHistories.fields.benefit_key').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefitHistory->benefit_key }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/salaryBenefitHistories.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefitHistory->description }}</p>
    </div>
</div>

