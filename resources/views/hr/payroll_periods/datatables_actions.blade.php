{!! Form::open(['route' => [$routePath.'.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="{{ route('hr.payrolls.index') }}?payroll_period={{$id}}" class='btn btn-ghost-info'>
       <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route($routePath.'.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
