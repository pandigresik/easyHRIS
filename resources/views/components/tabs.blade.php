<div class='nav-tabs-boxed'>
    <ul class='nav nav-tabs' role='tablist'>
        @foreach ($data as $key => $item)
            <li class='nav-item' onclick='main.loadContentTab(this)' data-url='{{ $item["url"] }}' data-json='@json($item["json"])' data-href='#{{ $key }}'><a class='nav-link {{ $item['class'] }}' data-bs-toggle='tab' href='#{{ $key }}' role='tab' aria-controls='{{ $key }}'
                aria-selected='false'>{{ $item['text'] }}</a>
            </li>    
        @endforeach
    </ul>
    <div class='tab-content pt-3'>
        @foreach ($data as $key => $item)
            <div class="tab-pane {{ \Str::contains($item['class'],'active') ? 'active show' : ''  }}" id='{{ $key }}' role='tabpanel'>{!! $item['defaultContent'] ?? '' !!}</div>
        @endforeach        
    </div>
</div>