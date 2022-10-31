{!! Form::open(['route' => ['hr.shiftmentGroups.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('hr.shiftmentGroups.details.index', $id) }}" class='btn btn-ghost-info' title="detail shift group">
        <i class="fa fa-align-justify"></i>
     </a>
    
    <a href="{{ route('hr.shiftmentGroups.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
