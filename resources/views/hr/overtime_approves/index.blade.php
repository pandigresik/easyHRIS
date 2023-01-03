@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
        <li class="breadcrumb-item">@lang('models/overtimes.plural')</li>
    </ol>
    @endpush
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                    {!! Form::open(['route' => ['hr.overtimeApproves.update', 1], 'method' => 'patch']) !!}
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             @lang('models/overtimes.plural')
                             
                         </div>
                         <div class="card-body">                             
                             @include('hr.overtime_approves.table')                             
                              <div class="pull-right mr-3">
                                     
                              </div>
                         </div>

                         <div class="card-footer">
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12 mt-2">
                                {!! Form::button(__('crud.approve'),['type' => 'submit','value' => 'A','name' => 'action', 'class' => 'btn btn-primary', 'onclick' => 'return isComplete(this)']) !!}
                                {!! Form::button(__('crud.reject'),['type' => 'submit','value' => 'RJ','name' => 'action', 'class' => 'btn btn-danger', 'onclick' => 'return isCompleteReject(this)']) !!}
                                <a href="{{ route('home') }}" class="btn btn-default">@lang('crud.cancel')</a>
                            </div>
                        </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    function isComplete(elm){
        const _table = $(elm).closest('.card').find('table')
        const _checked = _table.find('tbody :checked')

        if(!_checked.length){
            main.alertDialog('Warning', 'Tidak ada data pengajuan yang dipilih')
            return false
        }

        return true
    }

    function isCompleteReject(elm){
        if(isComplete(elm)){
            const _form = $(elm).closest('form')
            bootbox.prompt({
                title: 'Alasan Reject ',
                inputType: 'textarea',
                callback: function (result) {                    
                    if(!_.isEmpty(result)){
                        if($.trim(result).length > 10){
                            $('<input type="hidden" value="'+result+'" name="comment" />').appendTo(_form)
                            _form.submit()
                        }else{
                            bootbox.alert('Alasan reject minimal 10 karakter', function(){
                                $(elm).click()
                            })
                        }                        
                    }
                    return
                }
            });
            return false
        }else{
            return false
        }        
    }
</script>
@endpush