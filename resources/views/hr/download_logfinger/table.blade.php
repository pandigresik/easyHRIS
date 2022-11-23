<table class="table table-bordered">
    <thead>
        <tr>
            <th>Display Name</th>
            <th>IP</th>
            <th>Port</th>
            <th>Result</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fingerprintDeviceItems as $device)
        <tbody>
            <tr>
                <td>{{ $device->display_name }}</td>
                <td>{{ $device->ip }}</td>
                <td>{{ $device->port }}</td>
                <td class="td-result"></td>
                <td><button class="btn btn-warning"><i class="fa fa-download" onclick="getAjaxData(this,'hr/downloadLogFingers/download/{{$device->id}}', 'post', {}, function(){})" title="pull data finger"></i></button></td>
            </tr>
        </tbody>
        @empty
        <tr>
            <td colspan="5">Data not found</td>
        </tr>
        @endforelse
    </tbody>
</table>

@push('scripts')
<script type="text/javascript">
var getAjaxData = function(elm, url){
        const _tr = $(elm).closest('tr')
        const _td_result = _tr.find('td.td-result')
        let lastResponseLength = false
        $.ajax({
            type: 'post',
            url: url,
            data: {},
            dataType: 'json',
            processData: false,
            beforeSend: function(){
                _td_result.html('please wait processing download data')
            },
            xhrFields: {
                // Getting on progress streaming response
                onprogress: function(e)
                {                                        
                    var result;
                    var response = e.currentTarget.response;    
                              
                    if(lastResponseLength === false)
                    {
                        result = response;
                        lastResponseLength = response.length;
                    }
                    else
                    {
                        result = response.substring(lastResponseLength);
                        lastResponseLength = response.length;
                    }
                    
                    var parsedResponse = JSON.parse(result);
                    _td_result.html(parsedResponse['message'])
                }
            },
            error: function (x, status, error) {
                console.log(error)                            
            }
        });
    }

    </script>
    @endpush