@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
          <li class="breadcrumb-item">
             <a href="{!! route('base.roles.index') !!}">Role</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    @endpush
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Role</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($role, ['route' => ['base.roles.update', $role->id], 'method' => 'patch']) !!}

                              @include('base.roles.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection