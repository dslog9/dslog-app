@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <span>Показатели</span>
    </div>
@endsection

@section('pageTitle', $view === 'az' ? 'Все маркеры' : 'Все маркеры')
@section('title', $view === 'az' ? 'Все показатели анализов по алфавиту — DSlog' : 'Показатели анализов — DSlog')
@section('description', $view === 'az'
    ? 'Алфавитный список медицинских показателей анализов: гемоглобин, ферритин, глюкоза, ТТГ, СРБ и другие маркеры.'
    : 'Справочник медицинских показателей анализов: общий анализ крови, биохимия, гормоны, воспаление, железо и другие группы маркеров.'
)

@section('content')
@php
    $currentView = $view ?? 'groups';

    $groupedMarkers = $markers
        ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
        ->groupBy(function ($marker) {
            $letter = mb_strtoupper(mb_substr($marker->name, 0, 1, 'UTF-8'), 'UTF-8');

            return preg_match('/^[А-ЯЁA-Z]$/u', $letter) ? $letter : '#';
        });

    $letters = $groupedMarkers->keys();
@endphp

<div class="ds-container">
    <div class="markers-page">

        <header class="markers-hero">
            <h1></h1>

            <p class="markers-intro">
                Найдите показатель по медицинской группе или откройте полный алфавитный список маркеров.
            </p>

            <nav class="gen-view-switch" aria-label="Режим отображения показателей">

                <a
                    href="{{ route('markers.index', ['view' => 'groups']) }}"
                    class="{{ $currentView === 'groups' ? 'active' : '' }}"
                >
                    По группам
                </a>

                <a
                    href="{{ route('markers.index', ['view' => 'list']) }}"
                    class="{{ $currentView === 'list' ? 'active' : '' }}"
                >
                    Списком
                </a>

                <a
                    href="{{ route('markers.index', ['view' => 'az']) }}"
                    class="{{ $currentView === 'az' ? 'active' : '' }}"
                >
                    A–Z
                </a>

            </nav>
        </header>

        @if($currentView === 'az')

            @if($letters->count())
                <nav class="markers-letters" aria-label="Буквы алфавита">
                    @foreach($letters as $letter)
                        <a href="#letter-{{ $letter }}">{{ $letter }}</a>
                    @endforeach
                </nav>
            @endif

            @forelse($groupedMarkers as $letter => $items)
                <section class="markers-section" id="letter-{{ $letter }}">
                    <h2 class="markers-letter">{{ $letter }}</h2>

                    <ul class="markers-list">
                        @foreach($items as $marker)
                            <li>
                                <a class="markers-card" href="{{ route('markers.show', $marker->slug) }}">
                                    <span class="markers-card-title">{{ $marker->name }}</span>

                                    @if(!empty($marker->description))
                                        <span class="markers-card-meta">{{ $marker->description }}</span>
                                    @elseif($marker->group)
                                        <span class="markers-card-meta">{{ $marker->group->name }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @empty
                <p>Пока нет добавленных показателей.</p>
            @endforelse
                    
            @elseif($currentView === 'list')

                <div class="markers-grouped-list-view">
                    @foreach($groups as $group)
                        <section class="markers-list-group">

                            <div class="markers-list-group-header">
                                <h2>
                                    <a href="{{ route('markers.group', $group->slug) }}">
                                        {{ $group->name }}
                                    </a>
                                </h2>
                            </div>

                            @if($group->description)
                                <p class="markers-list-group-description">
                                    {{ $group->description }}
                                </p>
                            @endif

                            <div class="markers-list-items">
                                @foreach($group->markers as $marker)
                                    <a
                                        href="{{ route('markers.show', $marker->slug) }}"
                                        class="marker-list-item"
                                    >
                                        <div class="marker-list-title">
                                            {{ $marker->name }}.
                                        </div>

                                        @if(!empty($marker->description))
                                            <div class="marker-list-meta">
                                                {{
                                                    mb_strtoupper(mb_substr($marker->description, 0, 1))
                                                    . mb_substr($marker->description, 1)
                                                }}
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>

                        </section>
                    @endforeach
                </div>


            @else

                <div class="marker-groups-grid">

                    @php
                        function markersCountLabel($count) {
                            $mod10 = $count % 10;
                            $mod100 = $count % 100;

                            if ($mod10 === 1 && $mod100 !== 11) {
                                return 'показатель';
                            }

                            if ($mod10 >= 2 && $mod10 <= 4 && !($mod100 >= 12 && $mod100 <= 14)) {
                                return 'показателя';
                            }

                            return 'показателей';
                        }
                    @endphp

                    @foreach($groups as $group)
                        <a href="{{ route('markers.group', $group->slug) }}" class="marker-group-card">

                            <div class="marker-group-card-top">
                                <span class="marker-group-kicker"></span>
                            </div>

                            <h2>{{ $group->name }}</h2>


                                @php
                                    $count = $group->markers_count ?? $group->markers->count();
                                @endphp

                                <div class="marker-group-count-bottom">
                                    {{ $count }} {{ markersCountLabel($count) }}
                                </div>

                            @if($group->description)
                                <p>{{ $group->description }}</p>
                            @endif


                            @if($group->markers->count())
                                <div class="marker-group-preview">

                                    @foreach($group->markers->take(3) as $marker)
                                        <span>{{ $marker->name }}</span>
                                    @endforeach

                                    @if($group->markers->count() > 3)
                                        <span>...</span>
                                    @endif

                                </div>
                            @endif


                        </a>
                    @endforeach
                </div>

            @endif

    </div>
</div>
@endsection