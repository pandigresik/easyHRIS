<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/customers.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $customers->name }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/customers.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $customers->description }}</p>
    </div>
</div>

<!-- Address Field -->
<div class="form-group row mb-3">
    {!! Form::label('address', __('models/customers.fields.address').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $customers->address }}</p>
    </div>
</div>

<!-- User Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('user_id', __('models/customers.fields.user_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $customers->user_id }}</p>
    </div>
</div>

