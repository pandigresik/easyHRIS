<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIK</th>
            @foreach ($periodRange as $date)
                <th style="min-width:100px">{{ $date->format('d M')}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $emp)
        <tr>
            <td>{{ $emp->full_name }}</td>
            <td>{{ $emp->code }}</td>
            @foreach ($periodRange as $date)
                <td>{!! Form::select('workshift['.$emp->id.']['.$date->format('Y-m-d').']', $shiftmentItems, $workshiftEmployee[$emp->id][$date->format('Y-m-d')]->shiftment_id ?? null, ['class' => 'form-control select2']) !!}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
</div>