@extends('layouts.app')

@section('title', 'Загруженные данные')

@section('content')

<div class="page">

    <div class="page-header">
        <a href="{{ route('checklist.index') }}" class="muted">
            ← Мой план
        </a>

        <h1>Загруженные данные</h1>

        <p class="muted">
            Анализы и прочие документы, которые были добавлены в DSlog.
        </p>
    </div>

    <div class="dashboard-tabs">

        <a href="{{ route('checklist.uploads') }}"
           class="dashboard-tab {{ request('type', 'all') === 'all' ? 'active' : '' }}">
            Все
        </a>

        <a href="{{ route('checklist.uploads', ['type' => 'lab_analysis']) }}"
           class="dashboard-tab {{ request('type') === 'lab_analysis' ? 'active' : '' }}">
            Анализы
        </a>

        <a href="{{ route('checklist.uploads', ['type' => 'other']) }}"
           class="dashboard-tab {{ request('type') === 'other' ? 'active' : '' }}">
            Прочее
        </a>

    </div>

    <div class="dashboard-grid dashboard-grid-documents">

        @forelse($uploadedDocuments as $document)

            <article class="dashboard-card">

                <div class="dashboard-card-header">

                    <div>
                        <h2>
                            @if($document->document_type === 'lab_analysis')
                                Анализ #{{ $document->id }}
                            @else
                                Документ #{{ $document->id }}
                            @endif
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

                    @endif

                    <a href="{{ route('checklist.uploads.show', $document) }}" class="button-secondary">
                        Посмотреть
                    </a>

                </div>

            </article>

        @empty

            <div class="empty-state">
                Пока нет загруженных данных.
            </div>

        @endforelse

    </div>

    @if(method_exists($uploadedDocuments, 'links'))
        {{ $uploadedDocuments->links() }}
    @endif

</div>

@endsection