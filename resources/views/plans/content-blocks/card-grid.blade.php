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

            <article class="seo-card">

                <h3 class="seo-card-title">
                    {{ $item->title }}
                </h3>

                @if($item->description)
                    <p class="seo-card-text">
                        {{ $item->description }}
                    </p>
                @endif

            </article>

        @endforeach

    </div>
</section>