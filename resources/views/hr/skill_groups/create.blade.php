@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
      <li class="breadcrumb-item">
         <a href="{!! route('hr.skillGroups.index') !!}">@lang('models/skillGroups.singular')</a>
      </li>
      <li class="breadcrumb-item active">@lang('crud.add_new')</li>
    </ol>
    @endpush
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::open(['route' => 'hr.skillGroups.store']) !!}
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create @lang('models/skillGroups.singular')</strong>
                            </div>
                            <div class="card-body">                                

                                   @include('hr.skill_groups.fields')
                                
                            </div>
                            <div class="card-footer">
                                <!-- Submit Field -->
                                <div class="form-group col-sm-12 mt-2">
                                    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
                                    <a href="{{ route('hr.skillGroups.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
           </div>
    </div>
@endsection
