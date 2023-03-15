@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
      <li class="breadcrumb-item">
         <a href="{!! route('hr.workshifts.index') !!}">@lang('models/workshifts.singular')</a>
      </li>
      <li class="breadcrumb-item active">@lang('crud.add_new')</li>
    </ol>
    @endpush
    <div class="container-fluid">
        <x-tabs :data="$dataTabs"/>          
    </div>
@endsection
