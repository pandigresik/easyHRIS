<div class='btn-group'>    
    <a href="{{ route('hr.payrollDetails.index') }}?payroll_id={{ $id }}" class='btn btn-ghost-info'>
       <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('hr.payrolls.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-file"></i>
    </a>
</div>

