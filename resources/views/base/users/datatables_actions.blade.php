{!! Form::open(['route' => ['base.users.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a title="reset password" href="{{ route('base.users.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-key"></i>
    </a>
    <a href="{{ route('base.users.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
