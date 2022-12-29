@extends('layouts.app')

@section('content')
    @push('breadcrumb')
    <ol class="breadcrumb  my-0 ms-2">
      <li class="breadcrumb-item">
         <a href="{!! route('hr.employeeSupervisors.index') !!}">Supervisor @lang('models/employees.singular')</a>
      </li>
      <li class="breadcrumb-item active">@lang('crud.add_new')</li>
    </ol>
    @endpush
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::open(['route' => 'hr.employeeSupervisors.store']) !!}
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create @lang('models/employees.singular')</strong>
                            </div>
                            <div class="card-body">                                

                                   @include('hr.employee_supervisors.fields')
                                
                            </div>
                            <div class="card-footer">
                                <!-- Submit Field -->
                                <div class="form-group col-sm-12 mt-2">
                                    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary', 'onclick'=> 'return isComplete(this)']) !!}
                                    <a href="{{ route('hr.employeeSupervisors.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
           </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    function showListEmployee(elm){
        const _url = $(elm).data('url')
        let _data = {}
        $('#div-filter').find('select').each(function(){
            if(!_.isEmpty($(this).val())){
                _data[$(this).attr('name')] = $(this).val()
            }            
        })
        if(_.isEmpty(_data)){
            main.alertDialog('Warning','Filter data belum dipilih')
            return
        }
        
        main.getHtmlData(_url, 'post', _data, function(data){
            $('#list-employee').html(data)
        });
    }

    function isComplete(elm){
        if(!$('#list-employee').find('tbody :checked').length){
            main.alertDialog('Warning', 'Karyawan belum dipilih');
            return false;
        }
        return true;
    }
</script>
@endpush
