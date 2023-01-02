@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
        <li class="breadcrumb-item">@lang('models/requestWorkshifts.plural') Approval</li>
    </ol>
    @endpush
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                    {!! Form::open(['route' => ['hr.requestWorkshiftApproves.update', 1]]) !!}
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             @lang('models/requestWorkshifts.plural')
                             
                         </div>
                         <div class="card-body">                             
                             @include('hr.request_workshift_approves.table')                             
                              <div class="pull-right mr-3">
                                     
                              </div>
                         </div>

                         <div class="card-footer">
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12 mt-2">
                                {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
                                <a href="{{ route('hr.requestWorkshifts.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
                            </div>
                        </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

