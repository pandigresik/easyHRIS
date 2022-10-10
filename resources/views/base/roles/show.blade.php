@extends('layouts.app')

@section('content')
     @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('base.roles.index') }}">Role</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
     </ol>
     @endpush
     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('common.errors')
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-header">
                                 <strong>Details</strong>
                                  <a href="{{ route('base.roles.index') }}" class="btn btn-light">Back</a>
                             </div>
                             <div class="card-body">
                                 @include('base.roles.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
@endsection
