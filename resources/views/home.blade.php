@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
  <div class="animated fadeIn">
    @include('flash::message')
    <div class="row">
      @forelse ($needApproval as $item)
      <div class="col">
        <div class="card bg-light mb-3">
          <div class="card-header">{{ $item['title'] }}</div>
          <div class="card-body">
            <ul class="list-group">
              @foreach ($item['datas'] as $data)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="card-text">Diajukan oleh : {{ $data['created_by']}}</div>
                <div>
                  <span class="badge bg-primary rounded-pill">{{ $data['count'] }}</span>
                  <a href="{{ $data['url'] }}" class="card-link">Detail</a>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @empty
      @endforelse
    </div>
  </div>
</div>
</div>

@endsection
