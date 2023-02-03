@extends('layouts.app')

@section('content')
@push('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">
        <a href="{!! route('hr.attendanceReports.index') !!}">@lang('models/attendances.singular')</a>
    </li>
</ol>
@endpush
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open(['route' => 'hr.attendanceReports.index']) !!}
                <div class="card">
                    <div class="card-header">                        
                        <strong>Report @lang('models/attendances.singular')</strong>
                    </div>
                    <div class="card-body">
                        <!-- Period Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('period', __('models/attendances.fields.period').':', ['class' =>
                            'col-md-3 col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('period', null, ['class' => 'form-control datetime', 'data-optiondate' =>
                                json_encode(config('local.daterange'))]) !!}
                            </div>
                        </div>
                        <!-- Grouping Field -->
                        <div class="form-group row mb-3">
                            {!! Form::label('grouping', __('models/attendances.fields.grouping').':', ['class' =>
                            'col-md-3 col-form-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('grouping',['employee' => 'employee', 'date' => 'date'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!-- Submit Field -->
                        <div class="form-group row mb-3">
                            <div class="col-md-9 offset-3">
                                {!! Form::button(__('crud.search'), ['class' => 'btn btn-primary','value'=> 1, 'data-url' => route('hr.attendanceReports.index'), 'data-target' => '#list-attendance-report', 'data-ref' => 'select[name=grouping],input[name=period]' ,'onclick' => 'main.loadDetailPage(this, \'get\')']) !!}
                                {!! Form::button(__('crud.download'), ['class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'downloadXls(this)']) !!}
                            </div>
                            
                        </div> 

                        <div class="">
                            <div class="table-responsive" id="list-attendance-report"></div>
                        </div>
                    </div>                    
                </div>
            </div>
            {!! Form::close() !!}            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    function downloadXls(elm) {
        const _form = $(elm).closest('form')
        const _url = _form.attr('action')
        const _json = {'download_xls' : 1, 'v': moment.now(), 'grouping' : _form.find('select[name=grouping]').val(),'period': _form.find('input[name=period]').val()}
        
        $.redirect(
            _url, 
            _json,
            'GET',
            '_blank'
        )    

    }
</script>
@endpush