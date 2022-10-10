@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
          <li class="breadcrumb-item">
             <a href="{!! route('base.permissions.index') !!}">Permission</a>
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
                              <strong>Edit Permission</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($permission, ['route' => ['base.permissions.update', $permission->id], 'method' => 'patch']) !!}

                              @include('base.permissions.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection