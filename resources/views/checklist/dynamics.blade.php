@extends('layouts.app')

@section('title', 'Динамика')

@section('content')

<div class="page">
    <div class="ds-container dynamics-page">
        <div class="page-header">

            <a href="{{ route('checklist.index') }}" class="muted">
                ← Мой план
            </a>

            <h1>Динамика показателей</h1>

            <p class="muted">
                История изменений лабораторных показателей.
            </p>

        </div>

        <div class="dashboard-grid dashboard-grid-documents">

            @forelse($markers as $marker)

                <a href="{{ route('checklist.dynamics.show', $marker) }}" class="dashboard-card dashboard-card-link">

                    <div class="dashboard-card-header">

                        <div>
                            <h2>{{ $marker->name }}</h2>

                            <p class="muted">
                                {{ $marker->slug }}
                            </p>
                        </div>

                    </div>

                    <div class="dashboard-card-body">

                        <div class="dashboard-metadata">

                            <div>
                                <strong>Записей:</strong>
                                {{ $marker->user_analysis_items_count }}
                            </div>

                        </div>

                    </div>

                </a>

            @empty

                <div class="empty-state">
                    Пока недостаточно данных для динамики.
                </div>

            @endforelse

        </div>
    </div>
</div>

@endsection