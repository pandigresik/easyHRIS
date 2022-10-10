<!-- Parent Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('parent_id', __('models/companies.fields.parent_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $company->parent_id }}</p>
    </div>
</div>

<!-- Address Field -->
<div class="form-group row mb-3">
    {!! Form::label('address', __('models/companies.fields.address').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $company->address }}</p>
    </div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/companies.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $company->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/companies.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $company->name }}</p>
    </div>
</div>

<!-- Birth Day Field -->
<div class="form-group row mb-3">
    {!! Form::label('birth_day', __('models/companies.fields.birth_day').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $company->birth_day }}</p>
    </div>
</div>

<!-- Email Field -->
<div class="form-group row mb-3">
    {!! Form::label('email', __('models/companies.fields.email').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $company->email }}</p>
    </div>
</div>

<!-- Tax Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_number', __('models/companies.fields.tax_number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $company->tax_number }}</p>
    </div>
</div>

