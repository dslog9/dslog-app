<section class="seo-section">
    <div class="seo-section-header">
        <h2>{{ $block->title }}</h2>

        @if($block->description)
            <p class="seo-text">
                {{ $block->description }}
            </p>
        @endif
    </div>

    <ul class="seo-list">
        @foreach($block->items as $item)
            <li>
                {{ $item->title }}

                @if($item->description)
                    <span>{{ $item->description }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</section>