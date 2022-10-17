<div class="col-9 offset-3">
    {!! Form::hidden('work_date_shiftment', json_encode($dataInsert)) !!}
    <div id="calendar1" class="calendar" data-optioncalendar='{!! json_encode(['initialDate' => $initialDate, 'eventSources' => ['events' => $events], 'eventTimeFormat' => $eventTimeFormat]) !!}'></div>    
</div>
