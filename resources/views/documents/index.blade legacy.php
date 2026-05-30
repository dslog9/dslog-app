@extends('layouts.app')

@section('title', 'Загруженные данные')

@section('content')

<div class="page">

    <div class="page-header">
        <h1>Загруженные данные</h1>

        <p class="muted">
            Все загруженные пользователем документы.
        </p>
    </div>

    <div class="dashboard-tabs">
        <a href="{{ route('documents.index') }}"
        class="dashboard-tab {{ $type === 'all' ? 'active' : '' }}">
            Все
        </a>

        <a href="{{ route('documents.index', ['type' => 'lab_analysis']) }}"
        class="dashboard-tab {{ $type === 'lab_analysis' ? 'active' : '' }}">
            Анализы
        </a>

        <a href="{{ route('documents.index', ['type' => 'other']) }}"
        class="dashboard-tab {{ $type === 'other' ? 'active' : '' }}">
            Прочее
        </a>
    </div>

    <div class="dashboard-grid dashboard-grid-documents">

        @forelse($documents as $document)

            <article class="dashboard-card">

                <div class="dashboard-card-header">

                    <div>
                        <h2>
                            Документ #{{ $document->id }}
                        </h2>

                        <p class="muted">
                            {{ $document->document_type }}
                        </p>
                    </div>

                </div>

                <div class="dashboard-card-body">

                    <div class="dashboard-metadata">

                        <div>
                            <strong>Источник:</strong>
                            {{ $document->source_type }}
                        </div>

                        <div>
                            <strong>Маркеров:</strong>
                            {{ $document->detected_items_count }}
                        </div>

                        <div>
                            <strong>Дата:</strong>
                            {{ $document->created_at?->format('d.m.Y H:i') }}
                        </div>

                    </div>

                    @if($document->classification_reason)

                        <div class="dashboard-note">
                            {{ $document->classification_reason }}
                        </div>

                        <a href="{{ route('documents.show', $document) }}" class="button-secondary">
                            Посмотреть
                        </a>

                    @endif

                </div>

            </article>

        @empty

            <div class="empty-state">
                Пока нет загруженных данных.
            </div>

        @endforelse

    </div>

</div>

@endsection