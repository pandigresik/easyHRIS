<div class="col-10 offset-2">
@foreach ($dataInserts as $shiftment => $dataInsert)
<div class="pt-5">
    <div class="alert alert-success">
        <h4>{{ $shiftmentGroupMap[$shiftment] }}</h4>
    </div>    
    {!! Form::hidden('work_date_shiftment['.$shiftment.']', json_encode($dataInsert)) !!}
    <div id="calendar{{ $shiftment }}" class="calendar" data-optioncalendar='{!! json_encode(['initialDate' => $initialDate, 'eventSources' => ['events' => $events[$shiftment]], 'eventTimeFormat' => $eventTimeFormat]) !!}'></div>
</div>
@endforeach
</div>

