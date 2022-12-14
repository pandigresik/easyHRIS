{!! Form::open(['route' => ['hr.payrolls.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="{{ route('hr.payrollDetails.index') }}?payroll_id={{ $id }}" class='btn btn-ghost-info'>
       <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('hr.payrolls.payslip', $id) }}" class='btn btn-ghost-info' target="_blank" title="payslip">
       <i class="fa fa-file-pdf-o"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
