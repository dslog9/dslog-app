
        {{--
        |--------------------------------------------------------------------------
        | Plans / Index
        |--------------------------------------------------------------------------
        |
        | Purpose:
        | Main catalog page for DSlog checkups and thematic panels.
        |
        | Page modes:
        | - checkups
        | - thematic
        |
        | Navigation layers:
        | - tabs
        | - pills
        | - chips
        |
        | Main sections:
        | - hero
        | - tabs navigation
        | - layered filters
        | - plans grid
        | - empty states
        |
        | CSS blocks used:
        | - page
        | - page-header
        | - page-title
        | - page-subtitle
        | - breadcrumbs
        | - plans-page
        | - plans-hero
        | - plans-hero-content
        | - plans-hero-actions
        | - plans-tabs
        | - plans-tab
        | - plans-filters
        | - filter-pills
        | - filter-pill
        | - filter-pill-sub
        | - filter-chip
        | - plans-grid
        | - plan-card
        | - plan-card-image
        | - plan-card-content
        | - plan-card-meta
        | - plan-card-title
        | - plan-card-description
        | - plan-card-footer
        | - plan-card-markers
        | - plan-card-frequency
        | - empty-state
        |
        | State classes:
        | - active
        | - is-active
        | - active-parent
        |
        | Query params:
        | - tab
        | - category
        | - age_range
        | - thematic_type
        |
        | Data requirements:
        | - $plans
        | - $tab
        | - $category
        | - $ageRange
        | - $thematicType
        |
        | Architecture notes:
        | - tabs = top-level mode switch
        | - pills = second-level filters
        | - chips = compact third-level filters
        | - section != marker_group
        | - plan cards and my-plan cards should share visual foundation
        |
        --}}

@extends('layouts.app')

@php
    $categoryLabels = [
        'basic' => 'Базовые',
        'women' => 'Женщинам',
        'men' => 'Мужчинам',
        'children' => 'Детские',
        'heart' => 'Сердце',
        'thyroid' => 'Щитовидка',
        'deficiency' => 'Дефициты',
        'diabetes' => 'Обмен веществ',
    ];

    $thematicTypeLabels = [
        'system' => 'Системы',
        'condition' => 'Состояния',
        'deficiency' => 'Дефициты',
        'symptom' => 'Симптомы',
        'risk' => 'Риски',
        'screening' => 'Скрининг',
    ];
@endphp

@section('pageTitle', 'Планы анализов')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →

        @if(!empty($selectedCategory) || !empty($selectedThematicType))
            <a href="{{ route('plans.index') }}">Планы анализов</a> →

            <span>
                @if(!empty($selectedThematicType))
                    {{ $thematicTypeLabels[$selectedThematicType] ?? $selectedThematicType }}
                @else
                    {{ $categoryLabels[$selectedCategory] ?? $selectedCategory }}
                @endif
            </span>
        @else
            <span>Планы анализов</span>
        @endif
    </div>
@endsection

@section('content')
<div class="ds-container">
    <main class="product-page plans-page">

        <section class="page-hero compact">
            <div>
                <h1></h1>

                <p class="lead">
                    Готовые наборы анализов по возрасту, полу и задачам проверки: базовый чек-ап, сердце, щитовидная железа, железо, обмен веществ.
                </p>
            </div>

            <div class="hero-actions">
                <a href="#" class="btn btn-primary">
                    Создать свой план
                </a>
            </div>
        </section>

        <section class="section compact-section">
            <div class="plan-filters">
                <a
                    href="{{ route('plans.index', ['tab' => 'checkups']) }}"
                    class="filter-pill {{ $selectedTab === 'checkups' ? 'active' : '' }}"
                >
                    Чекапы
                </a>

                <a
                    href="{{ route('plans.index', ['tab' => 'thematic']) }}"
                    class="filter-pill {{ $selectedTab === 'thematic' ? 'active' : '' }}"
                >
                    Тематические подборки
                </a>
            </div>
        </section>

        @if($selectedTab === 'checkups')
            <section class="section compact-section">
                <div class="plan-filters">
                    @if(empty($selectedCategory))
                        @foreach($checkupCategories as $category)
                            <a
                                href="{{ route('plans.index', ['tab' => 'checkups', 'category' => $category]) }}"
                                class="filter-pill"
                            >
                                {{ $categoryLabels[$category] ?? $category }}
                            </a>
                        @endforeach
                    @else
                        <a
                            href="{{ route('plans.index', ['tab' => 'checkups']) }}"
                            class="filter-pill active {{ !empty($selectedAgeRange) ? 'active-parent' : '' }}"
                        >
                            {{ $categoryLabels[$selectedCategory] ?? $selectedCategory }}
                        </a>

                        @if($ageRanges->count())
                            @foreach($ageRanges as $range)
                                <a
                                    href="{{ route('plans.index', [
                                        'tab' => 'checkups',
                                        'category' => $selectedCategory,
                                        'age_range' => $range['key'],
                                    ]) }}"
                                    class="
                                        filter-pill
                                        filter-pill-sub
                                        {{ $selectedAgeRange === $range['key'] ? 'active' : '' }}
                                    "
                                >
                                    {{ $range['label'] }}
                                </a>
                            @endforeach
                        @endif
                    @endif
                </div>
            </section>
        @endif
        
        @if($selectedTab === 'thematic' && $thematicTypes->count())
            <section class="section compact-section">
                <div class="plan-filters">
                    <a
                        href="{{ route('plans.index', ['tab' => 'thematic']) }}"
                        class="filter-pill {{ empty($selectedThematicType) ? 'active' : '' }}"
                    >
                        Все
                    </a>

                    @foreach($thematicTypes as $type)
                        <a
                            href="{{ route('plans.index', ['tab' => 'thematic', 'thematic_type' => $type]) }}"
                            class="filter-pill {{ $selectedThematicType === $type ? 'active' : '' }}"
                        >
                            {{ $thematicTypeLabels[$type] ?? $type }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="section">
            <div class="dashboard-grid dashboard-grid-plans">
                @php
                    $visiblePlans = $selectedTab === 'thematic'
                        ? $thematicPlans
                        : $checkupPlans;
                @endphp

                @forelse($visiblePlans as $plan)

                        <a
                            href="{{ route('plans.show', $plan->slug) }}"
                            class="card card-link plan-card"
                            style="background-image:url('{{ $plan->cover_image ? asset(ltrim($plan->cover_image, '/')) : asset('assets/plan/default.jpg') }}')"
                        >
                        <div class="plan-card-content">
                            ...
                        </div>
{{--                    </a>


                    <a
                        href="{{ route('plans.show', $plan->slug) }}"
                        class="card card-link plan-card"
                    >

                        <div class="plan-card-cover">
                            <img
                                src="{{ $plan->cover_image ? asset(ltrim($plan->cover_image, '/')) : asset('assets/plan/default.jpg') }}"
                                alt="{{ $plan->name }}"
                            >
                        </div>
--}} 

                        <div class="plan-card-content">
                            @if($plan->category)
                                <span class="mini-badge">
                                    {{ $categoryLabels[$plan->category] ?? $plan->category }}
                                </span>
                            @endif

                            <h3>{{ $plan->name }}</h3>

                            <p>
                                {{ $plan->short_description ?? $plan->description ?? 'Персональный набор анализов и показателей.' }}
                            </p>

                            <div class="mini-meta">
                                <span>
                                    Маркеров: {{ $plan->markers_count }}
                                </span>

                                @if($plan->gender)
                                    <span>
                                        {{ $plan->gender === 'female' ? 'Для женщин' : 'Для мужчин' }}
                                    </span>
                                @endif

                                @if($plan->age_min && $plan->age_max)
                                    <span>
                                        {{ $plan->age_min }}–{{ $plan->age_max }} лет
                                    </span>
                                @elseif($plan->age_min)
                                    <span>
                                        с {{ $plan->age_min }} лет
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="card">
                        <h3>Планы не найдены</h3>
                        <p>Попробуйте выбрать другой раздел или вернуться ко всем планам.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>
</div>
@endsection