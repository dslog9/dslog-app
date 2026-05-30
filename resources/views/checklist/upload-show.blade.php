@extends('layouts.app')

@section('title', 'Документ #' . $document->id)

@section('content')

<div class="page">
    <div class="ds-container dynamics-page">
        <div class="page-header">
            <a href="{{ route('checklist.uploads') }}" class="muted">
                ← Загруженные данные
            </a>

            <h1>Документ #{{ $document->id }}</h1>

            <p class="muted">
                {{ $document->document_type }} · {{ $document->created_at?->format('d.m.Y H:i') }}
            </p>
        </div>

        <div class="dashboard-card">

            <div class="dashboard-card-body">

                <div class="dashboard-metadata">

                    <div>
                        <strong>Тип:</strong>
                        {{ $document->document_type }}
                    </div>

                    <div>
                        <strong>Источник:</strong>
                        {{ $document->source_type }}
                    </div>

                    <div>
                        <strong>Маркеров:</strong>
                        {{ $document->detected_items_count }}
                    </div>

                    @if($document->original_filename)
                        <div>
                            <strong>Файл:</strong>
                            {{ $document->original_filename }}
                        </div>
                    @endif

                    @if($document->mime_type)
                        <div>
                            <strong>MIME:</strong>
                            {{ $document->mime_type }}
                        </div>
                    @endif

                </div>

                @if($document->classification_reason)
                    <div class="dashboard-note">
                        {{ $document->classification_reason }}
                    </div>
                @endif

            </div>

        </div>


        @if($document->analysis && $document->analysis->items->count())

            <div class="dashboard-card" style="margin-top: 24px;">

                <div class="dashboard-card-header">
                    <h2>Показатели анализа</h2>
                </div>

                <div class="dashboard-card-body">

                    <div class="dashboard-grid dashboard-grid-documents">

                        @foreach($document->analysis->items as $item)

                            @php
                                $evaluation = $item->latestEvaluation;
                                $status = $evaluation?->status ?? 'unknown';

                                $statusLabels = [
                                    'exceptional' => 'Exceptional',
                                    'optimal' => 'Optimal',
                                    'normal' => 'Good',
                                    'borderline' => 'Attention',
                                    'needs_control' => 'Needs control',
                                    'urgent' => 'Urgent',
                                    'unknown' => 'Unknown',
                                ];
                            @endphp

                            <article class="dashboard-card">

                                <div class="dashboard-card-header">

                                    <div>
                                        <h3>
                                            {{ $item->marker?->name ?? $item->marker_name ?? $item->marker_label }}
                                        </h3>

                                        <p class="muted">
                                            {{ $item->marker?->slug ?? $item->marker_code }}
                                        </p>
                                    </div>

                                    <span class="status-badge status-{{ $status }}">
                                        {{ $statusLabels[$status] ?? $status }}
                                    </span>

                                </div>

                                <div class="dashboard-card-body">

                                    <div class="dashboard-metadata">

                                        <div>
                                            <strong>Результат:</strong>
                                            {{ $item->value_text ?? $item->value }}
                                            {{ $item->unit }}
                                        </div>

                                        @if($item->reference_range)
                                            <div>
                                                <strong>Референс:</strong>
                                                {{ $item->reference_range }}
                                            </div>
                                        @endif

                                    </div>

                                    @if($evaluation?->explanation['message'] ?? null)
                                        <div class="dashboard-note">
                                            {{ $evaluation->explanation['message'] }}
                                        </div>
                                    @endif

                                </div>

                            </article>

                        @endforeach

                    </div>

                </div>

            </div>

        @endif

        <div class="dashboard-card" style="margin-top: 24px;">

            <div class="dashboard-card-header">
                <h2>Распознанный текст</h2>
            </div>

            <div class="dashboard-card-body">
                <pre style="white-space: pre-wrap; line-height: 1.6;">{{ $document->extracted_text }}</pre>
            </div>

        </div>
    </div>
</div>

@endsection