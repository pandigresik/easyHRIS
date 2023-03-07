<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/shiftmentGroups.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('code', null, ['class' => 'form-control','maxlength' => 7,'maxlength' => 7, 'required' => 'required']) !!}
</div>
</div>

<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/shiftmentGroups.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/shiftmentGroups.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('pattern', __('models/shiftmentGroups.fields.pattern').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('pattern', null, ['class' => 'form-control','maxlength' => 255]) !!}
    <span class="text-danger">Contoh : 4ON2OFF (4 hari masuk 2 hari libur), biarkan kosong jika selalu libur hari tertentu misalkan hari minggu</span>
</div>
</div>
