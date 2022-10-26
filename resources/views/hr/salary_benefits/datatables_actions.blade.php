{!! Form::open(['route' => ['hr.employees.salaryBenefits.destroy', [$employee_id,$id]], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('hr.employees.salaryBenefits.show', [$employee_id, $id]) }}" class='btn btn-ghost-success'>
       <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('hr.employees.salaryBenefits.edit', [$employee_id, $id]) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
