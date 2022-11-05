{!! Form::open(['route' => ['hr.payrollPeriodGroups.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="{{ route('hr.payrollPeriodGroups.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
