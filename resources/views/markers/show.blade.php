@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <a href="/markers">Показатели</a>
        @if($marker->group)
            → <a href="/markers/groups/{{ $marker->group->slug }}">{{ $marker->group->name }}</a>
        @endif
        → <span>{{ $marker->name }}</span>
    </div>
@endsection


{{--
@section('pageTitle', $marker->name)
--}}

@section('pageTitle', 'Все маркеры')

@section('content')

<div class="ds-container-wide">

    <div class="page-layout">
        <div class="content">

            <h1 class="page-title">{{ $marker->h1 ?? $marker->name }}</h1>

            @if($marker->seo_intro)
                <p class="intro">{{ $marker->seo_intro }}</p>
            @endif

            @if($marker->short)
                <section id="short" class="card summary summary-cta">
                    <div>
                        <h2>Коротко</h2>
                        <p>{{ $marker->short }}</p>
                    </div>

                    <a class="article-cta-button" href="/analyze-ui">
                        Проверить анализ
                    </a>
                </section>
            @endif

            @if($marker->what_is)
                <section id="what-is">
                    <h2>Что это</h2>
                    <p>{{ $marker->what_is }}</p>
                </section>
            @endif

            @if($marker->interpretation)
                <section id="interpretation">
                    <h2>Как понять результат</h2>

                    @if(is_array($marker->interpretation))
                        <ul class="interpretation-list">
                            @foreach($marker->interpretation as $item)
                                <li>{{ is_string($item) ? $item : json_encode($item, JSON_UNESCAPED_UNICODE) }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ $marker->interpretation }}</p>
                    @endif
                </section>
            @endif

            @if($marker->norms)
                <section id="norms">
                    <h2>Ориентировочные нормы</h2>

                    <p>
                        Референсные значения могут отличаться в зависимости от возраста, пола, метода измерения и лаборатории.
                        Для интерпретации используйте диапазон из вашего бланка анализа.
                    </p>


                    <ul class="norms-list">
                        @foreach($marker->norms as $norm)
                            <li>
                                @if(is_array($norm))
                                    @if(!empty($norm['label']))
                                        <strong>{{ $norm['label'] }}:</strong>
                                    @endif

                                    @if(!empty($norm['value']))
                                        <span>{{ $norm['value'] }}</span>
                                    @endif
                                @else
                                    <span>{{ $norm }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <p class="note">
                        Эти значения нужны для ориентира. Итоговую оценку результата лучше делать по референсам конкретной лаборатории и вместе с другими показателями.
                    </p>
                </section>
            @endif

            @if($marker->low)
                <section id="low">
                    <h2>{{ $marker->low['title'] ?? 'Если показатель снижен' }}</h2>

                    @if(!empty($marker->low['text']) || !empty($marker->low['summary']))
                        <p>{{ $marker->low['text'] ?? $marker->low['summary'] }}</p>
                    @endif

                    @if(!empty($marker->low['reasons']) && is_array($marker->low['reasons']))
                        <h3>Возможные причины</h3>
                        <ul>
                            @foreach($marker->low['reasons'] as $reason)
                                <li>{{ $reason }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if(!empty($marker->low['symptoms']) && is_array($marker->low['symptoms']))
                        <h3>На что обратить внимание</h3>
                        <ul>
                            @foreach($marker->low['symptoms'] as $symptom)
                                <li>{{ $symptom }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if(!empty($marker->low['important']))
                        <p class="note">{{ $marker->low['important'] }}</p>
                    @endif
                </section>
            @endif

            @if($marker->high)
                <section id="high">
                    <h2>{{ $marker->high['title'] ?? 'Если показатель повышен' }}</h2>

                    @if(!empty($marker->high['text']) || !empty($marker->high['summary']))
                        <p>{{ $marker->high['text'] ?? $marker->high['summary'] }}</p>
                    @endif

                    @if(!empty($marker->high['reasons']) && is_array($marker->high['reasons']))
                        <h3>Возможные причины</h3>
                        <ul>
                            @foreach($marker->high['reasons'] as $reason)
                                <li>{{ $reason }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if(!empty($marker->high['symptoms']) && is_array($marker->high['symptoms']))
                        <h3>На что обратить внимание</h3>
                        <ul>
                            @foreach($marker->high['symptoms'] as $symptom)
                                <li>{{ $symptom }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if(!empty($marker->high['important']))
                        <p class="note">{{ $marker->high['important'] }}</p>
                    @endif
                </section>
            @endif

            @if(!empty($marker->page_blocks))
                @foreach($marker->page_blocks as $blockIndex => $block)
                    <section id="page-block-{{ $blockIndex }}" class="marker-section marker-rich-block">
                        @if(!empty($block['title']))
                            <h2>{{ $block['title'] }}</h2>
                        @endif

                        @if(($block['type'] ?? null) === 'key_takeaways')
                            <div class="takeaway-list">
                                @foreach($block['items'] ?? [] as $item)
                                    <div class="takeaway-item">
                                        <span class="takeaway-dot"></span>
                                        <p>{{ $item }}</p>
                                    </div>
                                @endforeach
                            </div>

                        @elseif(($block['type'] ?? null) === 'result_scenarios')
                            <div class="scenario-grid">
                                @foreach($block['items'] ?? [] as $item)
                                    <div class="scenario-card">
                                        <h3>{{ $item['label'] ?? '' }}</h3>

                                        @if(!empty($item['meaning']))
                                            <p>{{ $item['meaning'] }}</p>
                                        @endif

                                        @if(!empty($item['next_step']))
                                            <div class="next-step">
                                                <strong>Что сделать:</strong>
                                                <span>{{ $item['next_step'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        @elseif(($block['type'] ?? null) === 'check_together')
                            <div class="check-together-list">
                                @foreach($block['items'] ?? [] as $item)
                                    <div class="check-together-item">
                                        <strong>{{ $item['marker'] ?? '' }}</strong>
                                        @if(!empty($item['why']))
                                            <span>{{ $item['why'] }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        @elseif(($block['type'] ?? null) === 'context_links')
                            <div class="context-links-list">
                                @foreach($block['items'] ?? [] as $item)
                                    <div class="context-link-item">
                                        @php
                                            $html = e($item['text'] ?? '');

                                            foreach (($item['links'] ?? []) as $link) {
                                                if (!empty($link['label']) && !empty($link['slug'])) {
                                                    $label = e($link['label']);
                                                    $url = e(url('/markers/' . $link['slug']));

                                                    $html = str_replace(
                                                        $label,
                                                        '<a href="' . $url . '">' . $label . '</a>',
                                                        $html
                                                    );
                                                }
                                            }
                                        @endphp

                                        <p>{!! $html !!}</p>
                                    </div>
                                @endforeach
                            </div> 




                        @elseif(($block['type'] ?? null) === 'when_to_pay_attention')
                            <div class="attention-box">
                                <ul>
                                    @foreach($block['items'] ?? [] as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        @else
                            @if(!empty($block['items']) && is_array($block['items']))
                                <ul>
                                    @foreach($block['items'] as $item)
                                        <li>{{ is_string($item) ? $item : json_encode($item, JSON_UNESCAPED_UNICODE) }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </section>
                @endforeach
            @endif

            @if($marker->what_to_do)
                <section id="what-to-do" class="card action">
                    <h2>Что делать</h2>
                    <ul>
                        @foreach($marker->what_to_do as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if(isset($labProviders) && $labProviders->isNotEmpty())
                <section class="marker-section" id="where-to-test">
                    <h2>Где сдать анализ</h2>

                    <p>
                        Можно открыть поиск по этому показателю в популярных лабораториях.
                        Название и наличие анализа могут отличаться по городу.
                    </p>

                    <div class="lab-provider-grid">
                        @foreach($labProviders as $provider)
                            <a
                                href="{{ $provider->searchUrl($marker->name) }}"
                                class="lab-provider-card"
                                target="_blank"
                                rel="nofollow noopener"
                            >
                                <span>{{ $provider->name }}</span>
                                <strong>Найти анализ →</strong>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif



            @if($marker->relatedMarkers && $marker->relatedMarkers->count())
                <section id="related">
                    <h2>Связанные показатели</h2>
                    <div class="related-grid">
                        @foreach($marker->relatedMarkers as $related)
                            <a class="related-card" href="/markers/{{ $related->slug }}">
                                {{ $related->name }}
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>

        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-title">На странице</div>
                <ul>
                    @if($marker->short)
                        <li><a href="#short">Коротко</a></li>
                    @endif

                    @if($marker->what_is)
                        <li><a href="#what-is">Что это</a></li>
                    @endif

                    @if($marker->interpretation)
                        <li><a href="#interpretation">Как понять результат</a></li>
                    @endif

                    @if($marker->norms)
                        <li><a href="#norms">Нормы</a></li>
                    @endif

                    @if($marker->low)
                        <li>
                            <a href="#low">
                                {{ $marker->low['title'] ?? 'Если показатель снижен' }}
                            </a>
                        </li>
                    @endif

                    @if($marker->high)
                        <li>
                            <a href="#high">
                                {{ $marker->high['title'] ?? 'Если показатель повышен' }}
                            </a>
                        </li>
                    @endif

                    @if(!empty($marker->page_blocks))
                        @foreach($marker->page_blocks as $blockIndex => $block)
                            @if(!empty($block['title']))
                                <li><a href="#page-block-{{ $blockIndex }}">{{ $block['title'] }}</a></li>
                            @endif
                        @endforeach
                    @endif

                    @if($marker->what_to_do)
                        <li><a href="#what-to-do">Что делать</a></li>
                    @endif

                    @if($marker->relatedMarkers && $marker->relatedMarkers->count())
                        <li><a href="#related">Связанные показатели</a></li>
                    @endif

                    @if($marker->faqs && $marker->faqs->count())
                        <li><a href="#faq">Вопросы</a></li>
                    @endif
                </ul>

                <div class="sidebar-cta">
                    <a class="article-cta-button sidebar-cta-button" href="/analyze-ui">
                        Проверить анализ
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>

@if($marker->faqs && $marker->faqs->count())
    <section id="faq" class="faq-section">
        <h2>Вопросы</h2>

        @foreach($marker->faqs as $faq)
            <div class="faq-item">
                <button class="faq-question" type="button">
                    {{ $faq->question }}
                </button>

                <div class="faq-answer">
                    <p>{{ $faq->answer }}</p>
                </div>
            </div>
        @endforeach
    </section>
@endif

<script>
document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
        const answer = btn.nextElementSibling;
        const isOpen = answer.style.display === 'block';

        document.querySelectorAll('.faq-answer').forEach(a => a.style.display = 'none');

        if (!isOpen) {
            answer.style.display = 'block';
        }
    });
});
</script>

@php
    $faqSchema = null;

    if ($marker->faqs && $marker->faqs->count()) {

        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [],
        ];

        foreach ($marker->faqs as $faq) {
            $faqSchema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($faq->answer),
                ],
            ];
        }
    }
@endphp

@if($faqSchema)
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif


@endsection
