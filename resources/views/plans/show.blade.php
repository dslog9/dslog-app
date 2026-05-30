
        {{--
        |--------------------------------------------------------------------------
        | Plans / Show
        |--------------------------------------------------------------------------
        |
        | Purpose:
        | Product + SEO hybrid page for a single test panel / checkup.
        |
        | Main sections:
        | - hero
        | - variants switcher
        | - sections list
        | - markers list
        | - seo content blocks
        |
        | CSS blocks used:
        | - page
        | - page-header
        | - page-title
        | - breadcrumbs
        | - plan-hero
        | - plan-hero-content
        | - plan-hero-meta
        | - plan-hero-actions
        | - plan-variant-switcher
        | - gen-variant-button
        | - plan-view-switcher
        | - plan-view-button
        | - plan-sections
        | - plan-section-card
        | - plan-section-header
        | - plan-section-meta
        | - plan-marker-list
        | - plan-marker-row
        | - plan-marker-info
        | - plan-marker-meta
        | - plan-frequency-pill
        | - plan-count-pill
        | - seo-content
        | - seo-section
        | - faq-list
        | - related-plans
        | - page_view
        | - plan-detail-tabs  
        | JS hooks:
        | - data-variant
        | - data-view
        | - data-role
        | - is-active
        | - is-inactive
        |
        | Data requirements:
        | - $plan
        | - $sections
        | - $markers
        | - $variant
        | - $view
        |
        --}}


@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <a href="{{ route('plans.index') }}">Планы анализов</a> →
        <span>{{ $plan->name ?? 'План' }}</span>
    </div>
@endsection

{{--
@section('pageTitle', $plan->name)
--}}

@section('pageTitle', 'Планы анализов')

@section('content')
<div class="ds-container">
    <main class="product-page plan-page">



        <section class="page-hero compact">
            <div>
                <h1>{{ $plan->name }}</h1>

                <p class="lead">
                    {{ $plan->description ?? 'Набор анализов для контроля ключевых показателей здоровья.' }}
                </p>
            </div>

{{-- выключили рисунок

           <div class="plan-hero-cover">
                @if($plan->cover_image)
                    <img src="{{ $plan->cover_image }}" alt="{{ $plan->name }}">
                @endif
            </div>

--}}
            <div class="hero-actions">
                <form action="{{ route('plans.add', $plan->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary-w">
                        Добавить в мой план
                    </button>
                </form>
            </div>
        </section>





            @php
                $pageView = request('page_view', 'product');
                $variant = request('variant', 'basic');

                $variantRoles = match($variant) {
                    'extended' => ['core', 'recommended'],
                    'complete' => ['core', 'recommended', 'extended', 'optional'],
                    default => ['core'],
                };

                $hasVariants = $plan->panelMarkers
                    ->whereNotNull('role')
                    ->where('role', '!=', 'core')
                    ->count() > 0;

                
                $totalMarkers = $plan->panelMarkers->filter(fn($item) => $item->marker)->count();

                $markerWord = match (true) {
                    $totalMarkers % 10 === 1 && $totalMarkers % 100 !== 11 => 'показатель',
                    in_array($totalMarkers % 10, [2, 3, 4]) && !in_array($totalMarkers % 100, [12, 13, 14]) => 'показателя',
                    default => 'показателей',
                 };

            @endphp

            <div class="plan-detail-tabs">
                <a
                    href="{{ route('plans.show', ['slug' => $plan->slug, 'page_view' => 'product']) }}"
                    class="plan-detail-tab {{ $pageView === 'product' ? 'is-active' : '' }}"
                >
                    Сам план
                </a>

                <a
                    href="{{ route('plans.show', ['slug' => $plan->slug, 'page_view' => 'about']) }}"
                    class="plan-detail-tab {{ $pageView === 'about' ? 'is-active' : '' }}"
                >
                    О чекапе
                </a>
            </div>

            @if($pageView === 'about')

                @include('plans.seo-content', ['plan' => $plan])

            @else

        <div class="plan-toolbar">
            @if($hasVariants)
                <div class="gen-view-switch">
                    <button type="button"
                            class="gen-variant-button active"
                            data-variant="basic">
                        Базовый
                    </button>

                    <button type="button"
                            class="gen-variant-button"
                            data-variant="extended">
                        Расширенный
                    </button>

                    <button type="button"
                            class="gen-variant-button"
                            data-variant="complete">
                        Полный
                    </button>
                </div>
            @endif

        </div>

        <div class="plan-total-markers">
            <span class="plan-total-marker-count">
                {{ $totalMarkers }}
            </span>            
            <span class="plan-total-marker-word">
                {{ $markerWord }}
            </span>
        </div>

        <section class="section">

        
            <div class="section-header">

                <div class="section-header-top">

                    <div class="section-title-row">
                        <h2>Что входит в план</h2>


                        <a
                            href="#"
                            class="plan-guide-link"
                            title="Подробнее о чек-апе"
                            onclick="return false;"
                        >
                            i
                        </a>

                    </div>

                    <div class="gen-view-switch plan-view-switch">
                        <button type="button" class="plan-view-button active" data-view="sections" title="По секциям">
                            ⊞
                        </button>

                        <button type="button" class="plan-view-button" data-view="list" title="Списком">
                            ≣
                        </button>
                    </div>

                </div>

                <p>Блоки анализов можно раскрыть, чтобы посмотреть показатели внутри.</p>

            </div>

            <div class="plan-section-list">
                @foreach($plan->sections as $section)
                    @php
                        $markersCount = $section->panelMarkers->filter(fn($item) => $item->marker)->count();
                        $frequency = $section->frequency_months;
                    @endphp

                    <details class="plan-section-card" data-section-card>
                        <summary class="plan-section-summary">
                            <div>
                                <h3>{{ $section->name }}</h3>

                                @if($section->description)
                                    <p>{{ $section->description }}</p>
                                @endif
                            </div>

                            <div class="plan-section-meta">
                                <span
                                    class="section-marker-count"
                                    data-total="{{ $markersCount }}"
                                >
                                    {{ $markersCount }} показателей
                                </span>

                                @if($frequency)
                                    <span>раз в {{ $frequency }} мес.</span>
                                @endif
                            </div>
                        </summary>

                        
                        <div class="plan-marker-list">
                            @foreach($section->panelMarkers as $panelMarker)
                                @php
                                    $marker = $panelMarker->marker;
                                    $roleLabels = [
                                        'core' => 'База',
                                        'recommended' => 'Рекомендуется',
                                        'extended' => 'Расширенно',
                                        'optional' => 'Опционально',
                                    ];
                                @endphp

                                @if($marker)

                                    <div
                                        class="plan-marker-row role-{{ $panelMarker->role ?? 'core' }} {{ in_array($panelMarker->role ?? 'core', $variantRoles) ? 'is-active' : 'is-inactive' }}"
                                        data-role="{{ $panelMarker->role ?? 'core' }}"
                                    >

                                        <div>
                                            <a href="{{ url('/markers/' . $marker->slug) }}" class="marker-link">
                                                {{ $marker->name }}
                                            </a>

                                            <p>
                                                {{ $panelMarker->reason ?? $marker->description ?? 'Контроль важного лабораторного показателя.' }}
                                            </p>
                                        </div>

                                        <span class="marker-role-badge">
                                            {{ $roleLabels[$panelMarker->role ?? 'core'] ?? 'База' }}
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </details>
                    
                @endforeach

                @if($plan->panelMarkers->whereNull('test_panel_section_id')->count())
                    <details class="plan-section-card">
                        <summary class="plan-section-summary">
                            <div>
                                <h3>Дополнительные показатели</h3>
                                <p>Отдельные маркеры, которые входят в этот план вне крупных блоков.</p>
                            </div>

                            <div class="plan-section-meta">
                                <span>{{ $plan->panelMarkers->whereNull('test_panel_section_id')->count() }} показателей</span>
                            </div>
                        </summary>

                        <div class="plan-marker-list">
                            @foreach($plan->panelMarkers->whereNull('test_panel_section_id') as $panelMarker)
                                @php
                                    $marker = $panelMarker->marker;
                                    $roleLabels = [
                                        'core' => 'База',
                                        'recommended' => 'Рекомендуется',
                                        'extended' => 'Расширенно',
                                        'optional' => 'Опционально',
                                    ];
                                @endphp

                                @if($marker)
                                    <div class="plan-marker-row role-{{ $panelMarker->role ?? 'core' }}">
                                        <div>
                                            <a href="{{ url('/markers/' . $marker->slug) }}" class="marker-link">
                                                {{ $marker->name }}
                                            </a>

                                            <p>
                                                {{ $panelMarker->reason ?? $marker->description ?? 'Контроль важного лабораторного показателя.' }}
                                            </p>
                                        </div>

                                        <span class="marker-role-badge">
                                            {{ $roleLabels[$panelMarker->role ?? 'core'] ?? 'База' }}
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </details>
                @endif
            </div>

            <div class="plan-flat-marker-list" style="display:none;">

                @foreach($plan->panelMarkers as $panelMarker)

                    @php
                        $marker = $panelMarker->marker;

                        $roleLabels = [
                            'core' => 'База',
                            'recommended' => 'Рекомендуется',
                            'extended' => 'Расширенно',
                            'optional' => 'Опционально',
                        ];
                    @endphp

                    @if($marker)
                        <div
                            class="plan-marker-row role-{{ $panelMarker->role ?? 'core' }} {{ in_array($panelMarker->role ?? 'core', $variantRoles) ? 'is-active' : 'is-inactive' }}"
                            data-role="{{ $panelMarker->role ?? 'core' }}"
                        >
                            <div>
                                <a href="{{ url('/markers/' . $marker->slug) }}" class="marker-link">
                                    {{ $marker->name }}
                                </a>

                                <p>
                                    {{ $panelMarker->reason ?? $marker->description ?? 'Контроль важного лабораторного показателя.' }}
                                </p>
                            </div>

                            <span class="marker-role-badge">
                                {{ $roleLabels[$panelMarker->role ?? 'core'] ?? 'База' }}
                            </span>
                        </div>
                    @endif

                @endforeach

            </div>

        </section>
        @endif
    </main>
    


</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const rolesByVariant = {
        basic: ['core'],
        extended: ['core', 'recommended'],
        complete: ['core', 'recommended', 'extended', 'optional'],
    };

    const buttons = document.querySelectorAll('.gen-variant-button');
    const viewButtons = document.querySelectorAll('.plan-view-button');
    const sectionCards = document.querySelectorAll('.plan-section-card');
    const sectionList = document.querySelector('.plan-section-list');
    const flatList = document.querySelector('.plan-flat-marker-list');
    const rows = document.querySelectorAll('.plan-marker-row');

    function applyVariant(variant) {
        const activeRoles = rolesByVariant[variant] || rolesByVariant.basic;

        buttons.forEach(button => {
            button.classList.toggle('active', button.dataset.variant === variant);
        });

        rows.forEach(row => {
            const role = row.dataset.role || 'core';
            const active = activeRoles.includes(role);

            row.classList.toggle('is-active', active);
            row.classList.toggle('is-inactive', !active);
        });

        document.querySelectorAll('[data-section-card]').forEach(card => {
            const activeRows = card.querySelectorAll('.plan-marker-row.is-active').length;
            const countBadge = card.querySelector('.section-marker-count');

            if (countBadge) {
                countBadge.textContent = activeRows + ' показателей';
            }
        });

            const totalActiveRows = document.querySelectorAll('.plan-section-list .plan-marker-row.is-active').length;
            const totalCount = document.querySelector('.plan-total-marker-count');
            const totalWord = document.querySelector('.plan-total-marker-word');

            function markerWord(count) {
                if (count % 10 === 1 && count % 100 !== 11) {
                    return 'показатель';
                }

                if ([2, 3, 4].includes(count % 10) && ![12, 13, 14].includes(count % 100)) {
                    return 'показателя';
                }

                return 'показателей';
            }

            if (totalCount && totalWord) {
                totalCount.textContent = totalActiveRows;
                totalWord.textContent = markerWord(totalActiveRows);
            }


        const url = new URL(window.location.href);
        url.searchParams.set('variant', variant);
        window.history.replaceState({}, '', url);
    }

    function applyView(view) {
        viewButtons.forEach(button => {
            button.classList.toggle('active', button.dataset.view === view);
        });

        if (!sectionList || !flatList) {
            return;
        }

        if (view === 'list') {
            sectionList.style.display = 'none';
            flatList.style.display = 'flex';
        } else {
            sectionList.style.display = 'flex';
            flatList.style.display = 'none';
        }

        const url = new URL(window.location.href);
        url.searchParams.set('view', view);
        window.history.replaceState({}, '', url);
    }

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                applyVariant(button.dataset.variant);
            });
        });

        viewButtons.forEach(button => {
            button.addEventListener('click', () => {
                applyView(button.dataset.view);
            });
        });

    const params = new URLSearchParams(window.location.search);

    if (buttons.length) {
        applyVariant(params.get('variant') || 'basic');
    }

    applyView(params.get('view') || 'sections');

});



</script>

@endsection