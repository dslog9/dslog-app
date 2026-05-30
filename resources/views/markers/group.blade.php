@extends('layouts.app')

@section('pageTitle', 'Группа показателей')
@section('title', ($group->seo_title ?? $group->name . ' — показатели анализов крови'))
@section('description', $group->seo_description ?? 'Показатели группы: ' . $group->name)

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <a href="{{ route('markers.index') }}">Показатели</a> →
        <span>{{ $group->name }}</span>
    </div>
@endsection

@section('content')

<div class="ds-container">
    <div class="markers-page marker-group-page">

    <header class="az-hero">
        <p class="marker-group-eyebrow">Группа показателей</p>

        <h1>{{ $group->name }}</h1>

        @if(!empty($group->description))
            <p class="az-intro">{{ $group->description }}</p>
        @else
            <p class="az-intro">
                Показатели этой группы помогают понять анализы и возможные отклонения.
            </p>
        @endif
    </header>

    @if($group->markers->count())

        <div class="marker-group-list">
            @foreach($group->markers as $marker)
                <a href="{{ route('markers.show', $marker->slug) }}" class="marker-group-list-item">
                    <div>
                        <h2>{{ $marker->name }}</h2>

                        @if(!empty($marker->description))
                            <p>{{ $marker->description }}</p>
                        @elseif(!empty($marker->seo_intro))
                            <p>{{ $marker->seo_intro }}</p>
                        @endif
                    </div>


                </a>
            @endforeach
        </div>

    @else

        <div class="empty-state">
            <h2>Показатели не найдены</h2>
            <p>В этой группе пока нет активных показателей.</p>
        </div>

    @endif
    </div>
</div>

@endsection