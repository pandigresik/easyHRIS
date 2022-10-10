@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
      <li class="breadcrumb-item">
         <a href="{!! route('base.users.index') !!}">User</a>
      </li>
      <li class="breadcrumb-item active">@lang('crud.add_new')</li>
    </ol>
    @endpush
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create User</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'base.users.store']) !!}

                                   @include('base.users.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
