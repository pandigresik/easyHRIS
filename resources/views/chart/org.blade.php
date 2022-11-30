@extends('layouts.app')

@section('content')    
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-sitemap"></i>
                             Chart Organization                             
                         </div>
                         <div class="card-body">                             
                            <div id="chart-container"></div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('/vendor/orgchart/css/jquery.orgchart.min.css') }}" />
@endpush

@push('scripts')
<script src="{{ asset('/vendor/orgchart/js/jquery.orgchart.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        var datascource = {!! json_encode($source[0] ?? new StdClass ) !!};

        var oc = $('#chart-container').orgchart({
            'data' : datascource,
            'nodeContent': 'title',
            // 'exportButton': true,
            'zoom': true,
            'pan': true
        });

        $(window).resize(function() {
        var width = $(window).width();
        if(width > 576) {
            oc.init({'verticalLevel': undefined});
        } else {
            oc.init({'verticalLevel': 2});
        }
        });
    })
    </script>
@endpush