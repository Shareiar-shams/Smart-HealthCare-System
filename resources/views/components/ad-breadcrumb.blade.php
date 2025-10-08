<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        @foreach($items as $item)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if($loop->last || !$item['url'])
                    {{ $item['label'] }}
                @else
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</div><!-- /.col -->
