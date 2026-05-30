@extends('layouts.app')
@section('pageTitle', 'Все маркеры')
@section('title', 'Все показатели анализов по алфавиту — DSlog')
@section('description', 'Алфавитный список медицинских показателей анализов: гемоглобин, ферритин, глюкоза, ТТГ, СРБ и другие маркеры.')

@section('content')
@php
    $groupedMarkers = $markers
        ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
        ->groupBy(function ($marker) {
            $letter = mb_strtoupper(mb_substr($marker->name, 0, 1, 'UTF-8'), 'UTF-8');
            return preg_match('/^[А-ЯЁA-Z]$/u', $letter) ? $letter : '#';
        });

    $letters = $groupedMarkers->keys();
@endphp

<div class="az-page">
    <p class="breadcrumbs">
        <a href="/">DSlog</a> → <span>Все маркеры</span>
    </p>

    <header class="az-hero">
        <h1>Все показатели анализов</h1>
        <p class="az-intro">
            Алфавитный список маркеров, которые встречаются в анализах крови и других лабораторных исследованиях.
        </p>
    </header>

    @if($letters->count())
        <nav class="az-letters" aria-label="Буквы алфавита">
            @foreach($letters as $letter)
                <a href="#letter-{{ $letter }}">{{ $letter }}</a>
            @endforeach
        </nav>
    @endif

    @forelse($groupedMarkers as $letter => $items)
        <section class="az-section" id="letter-{{ $letter }}">
            <h2 class="az-letter">{{ $letter }}</h2>

            <ul class="az-list">
                @foreach($items as $marker)
                    <li>
                        <a class="az-card" href="/markers/{{ $marker->slug }}">
                            <span class="az-card-title">{{ $marker->name }}</span>

                            @if(!empty($marker->description))
                                <span class="az-card-meta">{{ $marker->description }}</span>
                            @elseif($marker->group)
                                <span class="az-card-meta">{{ $marker->group->name }}</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @empty
        <p>Пока нет добавленных показателей.</p>
    @endforelse
</div>
@endsection
