{!! Form::open(['route' => ['hr.jobLevels.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('hr.jobLevels.chart', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-sitemap"></i>
    </a>
    <a href="{{ route('hr.jobLevels.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
