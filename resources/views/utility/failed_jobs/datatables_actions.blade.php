{!! Form::open(['route' => ['utility.failedJobs.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="{{ route('utility.failedJobs.edit', $id) }}" class='btn btn-ghost-info'>
        <i class="fa fa-recycle"></i>
     </a>    
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
