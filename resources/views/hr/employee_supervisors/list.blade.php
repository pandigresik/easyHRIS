<table class="table table-bordered">
    <thead>
        <tr>
            <th><input type="checkbox" onclick="main.checkAll(this,'table')" ></th>
            <th>Nama</th>
            <th>Departement</th>
            <th>Level</th>
            <th>Jabatan</th>
            <th>Bisnis Unit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $employee)
            <tr>
                <td>{!! Form::checkbox('employee[]', $employee->id ) !!}</td>
                <td>{{ $employee->codeName }}</td>
                <td>{{ $employee->department->name ?? '' }}</td>
                <td>{{ $employee->jobLevel->name ?? '' }}</td>
                <td>{{ $employee->jobTitle->name ?? '' }}</td>
                <td>{{ $employee->businessUnit->name ?? '' }}</td>
            </tr>

        @endforeach
    </tbody>
</table>