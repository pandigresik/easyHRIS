{!! Form::open(['route' => ['hr.attendances.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="{{ route('hr.attendances.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-list"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
