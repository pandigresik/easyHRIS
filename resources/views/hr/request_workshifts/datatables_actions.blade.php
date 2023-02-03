{!! Form::open(['route' => ['hr.requestWorkshifts.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    @if($status != 'A')
    <a href="{{ route('hr.requestWorkshifts.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>    
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endif
    
</div>
{!! Form::close() !!}
