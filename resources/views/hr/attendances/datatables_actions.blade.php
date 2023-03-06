{!! Form::open(['route' => ['hr.attendances.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="#" data-json="{}" data-url="{{ route('hr.attendanceLogfingers.detailLog', [$raw_attendance_date, $employee_id]) }}" onclick="main.popupModal(this, 'get');return false;" class='btn btn-ghost-info'>
       <i class="fa fa-list"></i>
    </a>
    @can('attendances-delete')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}    
    @endcan    
</div>
{!! Form::close() !!}
