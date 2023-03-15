     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::open(['route' => 'hr.workshifts.store']) !!}
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create @lang('models/workshifts.singular') Manual</strong>
                            </div>
                            <div class="card-body">                                
                                   @include('hr.workshifts.manual_fields')                                
                            </div>
                            <div class="card-footer">
                                <!-- Submit Field -->
                                <div class="form-group col-sm-12 mt-2">                                    
                                    {!! Form::button (__('crud.save'), ['class' => 'btn btn-primary', 'value' => 'manual_save', 'type' => 'submit']) !!}
                                    <a href="{{ route('hr.workshifts.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
           </div>
    </div>

