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

    <div class="related-plans">

        @foreach($plan->relatedPanels as $related)

            @php
                $relatedPlan = $related->relatedPanel;
            @endphp

            @continue(!$relatedPlan)

            <a
                href="{{ route('plans.show', $relatedPlan->slug) }}"
                class="related-plan-card"
            >

                <span>
                    {{ $related->title }}
                </span>

                @if($related->description)
                    <p>
                        {{ $related->description }}
                    </p>
                @endif

            </a>

        @endforeach

    </div>

</section>