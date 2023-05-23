{!! Form::open(['route' => ['hr.attendanceLogfingers.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    @can('attendance_logfingers-update')
    <a href="{{ route('hr.attendanceLogfingers.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can('attendance_logfingers-delete')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
