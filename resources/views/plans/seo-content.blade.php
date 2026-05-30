{{--
|--------------------------------------------------------------------------
| Plans / SEO Content
|--------------------------------------------------------------------------
|
| Purpose:
| SEO + educational content layer for plan/show page.
|
| This partial extends product-oriented checkup pages
| into full landing pages for search + conversion.
|
| Main sections:
| - why this checkup matters
| - what it helps evaluate
| - who it is for
| - preparation
| - frequency
| - faq
| - related plans
|
| CSS blocks used:
| - seo-content
| - seo-section
| - seo-section-header
| - seo-grid
| - seo-card
| - seo-card-title
| - seo-card-text
| - seo-list
| - faq-list
| - faq-item
| - related-plans
| - related-plan-card
|
| Data requirements:
| - $plan
|
| Future content source:
| - test_panels.json
| - imported DB content
|
--}}
<section class="seo-content">

    @php
        $genericCardBlocks = [
            'risk_areas',
            'systems',
            'early_signals',
            'dynamic_tracking',
            'after_checkup',
        ];

        $genericListBlocks = [
            'who_is_for',
            'when_to_check',
            'preparation',
        ];
    @endphp

    @foreach($plan->contentBlocks as $block)

        @php
            if (in_array($block->type, $genericCardBlocks, true)) {
                $view = 'plans.content-blocks.card-grid';
            } elseif (in_array($block->type, $genericListBlocks, true)) {
                $view = 'plans.content-blocks.list';
            } else {
                $view = 'plans.content-blocks.' . $block->type;
            }
        @endphp

        @includeIf($view, [
            'block' => $block,
            'plan' => $plan,
        ])

    @endforeach
    
    @if($plan->faqs->count())
        @php
            $faqSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $plan->faqs->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq->answer,
                    ],
                ])->values()->all(),
            ];
        @endphp

        <script type="application/ld+json">
            @json($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        </script>
    @endif

</section>