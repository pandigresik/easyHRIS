<div class="form-group row mb-3">
    <div class="col-md-12">    
        <a href='{!! url('base/export?urlOrigin='.$urlOrigin); !!}' target="_blank">Template File Upload</a>
    </div>
</div>
<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/import.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9">     
    {!! Form::file('file_upload', ['required']) !!}
    {!! Form::hidden('urlOrigin', $urlOrigin) !!}
</div>
</div>

