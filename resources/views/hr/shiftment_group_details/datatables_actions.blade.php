{!! Form::open(['route' => ['hr.shiftmentGroups.details.destroy', [$shiftment_group_id, $id]], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('hr.shiftmentGroups.details.show', [$shiftment_group_id, $id]) }}" class='btn btn-ghost-success'>
       <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('hr.shiftmentGroups.details.edit', [$shiftment_group_id, $id]) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
