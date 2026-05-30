<section class="seo-section">
    <div class="seo-section-header">


        <h2>
            {{ $block->title }}
        </h2>

        @if($block->description)
            <p class="seo-text">
                {{ $block->description }}
            </p>
        @endif
    </div>

    <div class="seo-grid">

        @foreach($block->items as $item)

            @php
                $markers = $item->meta['markers'] ?? [];
                $isAdditional = $item->meta['is_additional'] ?? false;
            @endphp

            <article class="seo-card">

                <h3 class="seo-card-title">
                    {{ $item->title }}
                </h3>

                <div class="seo-card-body">

                    @if($item->description)
                        <p class="seo-card-text">
                            {{ $item->description }}
                        </p>
                    @endif

                </div>

                @if(count($markers))

                    <ul class="seo-mini-list {{ $isAdditional ? 'is-additions' : '' }}">

                        @foreach($markers as $marker)

                            <li>{{ $marker }}</li>

                        @endforeach

                    </ul>

                @endif

            </article>

        @endforeach

    </div>
</section>