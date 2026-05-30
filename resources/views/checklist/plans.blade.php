@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <span>Мой план</span>
    </div>
@endsection

@section('pageTitle', 'Мой план')

@section('content')
<div class="ds-container">
    <main class="product-page my-plan-page">

        <section class="page-hero">
            <div>
                <p class="eyebrow"></p>
                <h1></h1>
            </div>

            <div class="hero-actions">
                <a href="/analyze-ui" class="btn btn-primary">Загрузить анализ</a>
            </div>
        </section>

        @if($checklists->isEmpty())
            <section class="card empty-state">
                <h2>План пока не создан</h2>
                <p>
                    После загрузки анализа или выбора набора показателей здесь появятся сроки,
                    статусы и рекомендации.
                </p>
                <a href="/analyze-ui" class="btn btn-primary">Загрузить анализ</a>
            </section>
        @else

            @php
                $statusLabels = [
                    'exceptional' => 'Отличный результат', 
                    'done' => 'Норма',
                    'needs_control' => 'Есть отклонение',
                    'urgent' => 'Требует внимания',
                    'overdue' => 'Просрочено',
                    'not_done' => 'Не сдан',
                ];



                $allItems = $checklists->flatMap->items;

                $attentionItems = $allItems
                    ->whereIn('status', ['urgent', 'needs_control', 'overdue'])
                    ->take(6);

                $upcomingItems = $allItems
                    ->filter(fn($item) => $item->next_due_at)
                    ->sortBy('next_due_at')
                    ->take(8);

                $keyItems = $allItems
                    ->whereIn('status', ['urgent', 'needs_control', 'done'])
                    ->take(8);
            @endphp

            <nav class="dashboard-tabs" aria-label="Разделы моего плана">
                <button type="button" class="dashboard-tab is-active" data-tab="plans">Мои планы</button>
                <button type="button" class="dashboard-tab" data-tab="attention">Требует внимания</button>
                <button type="button" class="dashboard-tab" data-tab="recommendations">Рекомендации</button>
                <button type="button" class="dashboard-tab" data-tab="upcoming">Предстоит сдать</button>
                <button type="button" class="dashboard-tab" data-tab="markers">Ключевые маркеры</button>
                <button type="button" class="dashboard-tab" data-tab="history">История</button>
            </nav>

            <section class="dashboard-panel" data-panel="attention">
                <div class="section-header">
                    <h2></h2>
                    <p>Отклонения, просроченные показатели и то, что лучше не пропустить.</p>
                </div>

                @if($attentionItems->isEmpty())
                    <div class="card calm-card">
                        <h3>Сейчас нет срочных пунктов</h3>
                        <p>Показатели без явных отклонений или ещё не требуют повторной сдачи.</p>
                    </div>
                @else
                    <div class="dashboard-grid">
                        @foreach($attentionItems as $item)
                            @php
                                $label = $statusLabels[$item->status] ?? 'Не сдан';
                                $result = $item->lastAnalysisItem
                                    ? trim(($item->lastAnalysisItem->value_text ?? $item->lastAnalysisItem->value) . ' ' . $item->lastAnalysisItem->unit)
                                    : '—';
                            @endphp

                            <article
                                class="card dashboard-card js-open-marker-modal"
                                data-title="{{ e($item->marker->name ?? 'Показатель') }}"
                                data-status="{{ e($label) }}"
                                data-status-class="status-{{ str_replace('_', '-', $item->status) }}"
                                data-note="{{ e($item->note ?? 'Рекомендуется проверить показатель в динамике.') }}"
                                data-result="{{ e($result) }}"
                                data-reference="{{ e($item->lastAnalysisItem->reference_range ?? '—') }}"
                                data-last="{{ e($item->last_tested_at ? $item->last_tested_at->format('d.m.Y') : '—') }}"
                                data-next="{{ e($item->next_due_at ? $item->next_due_at->format('d.m.Y') : '—') }}"
                                data-url="{{ $item->marker ? url('/markers/' . $item->marker->slug) : '#' }}"
                            >
                                <span class="status-badge status-{{ str_replace('_', '-', $item->status) }}">
                                    {{ $label }}
                                </span>

                                <h3>{{ $item->marker->name ?? 'Показатель' }}</h3>

                                <p class="card-note">
                                    {{ $item->note ?? 'Рекомендуется проверить показатель в динамике.' }}
                                </p>

                                @if($item->lastAnalysisItem)
                                    <div class="marker-result">
                                        <div>
                                            <span>Ваш результат</span>
                                            <strong>{{ $result }}</strong>
                                        </div>

                                        <div>
                                            <span>Референс</span>
                                            <strong>{{ $item->lastAnalysisItem->reference_range ?? '—' }}</strong>
                                        </div>
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="dashboard-panel" data-panel="recommendations">
                <div class="section-header">
                    <h2></h2>
                    <p>Следующие шаги на основе вашего плана.</p>
                </div>

                <div class="dashboard-grid">
                    <a href="/analyze-ui" class="card card-link">
                        <h3>Загрузить новый анализ</h3>
                        <p>DSlog обновит статусы показателей и сроки повторной сдачи.</p>
                    </a>

                    <a href="/markers" class="card card-link">
                        <h3>Понять показатели</h3>
                        <p>Откройте справочник и посмотрите, что означает каждый маркер.</p>
                    </a>

                    <a href="#" class="card card-link">
                        <h3>Добавить план</h3>
                        <p>Позже здесь можно будет выбрать новый набор анализов.</p>
                    </a>
                </div>
            </section>

            <section class="dashboard-panel" data-panel="upcoming">
                <div class="section-header">
                    <h2></h2>
                    <p>Ближайшие показатели по срокам контроля.</p>
                </div>

                <div class="card list-card">
                    @forelse($upcomingItems as $item)
                        <div class="list-row">
                            <div>
                                <a
                                    href="{{ $item->marker ? url('/markers/' . $item->marker->slug) : '#' }}"
                                    class="marker-link"
                                >
                                    {{ $item->marker->name ?? 'Показатель' }}
                                </a>
                                <span>{{ $item->note ?? 'Плановая проверка' }}</span>
                            </div>

                            <div class="list-date">
                                {{ $item->next_due_at ? $item->next_due_at->format('d.m.Y') : '—' }}
                            </div>
                        </div>
                    @empty
                        <p class="muted">Пока нет ближайших сроков сдачи.</p>
                    @endforelse
                </div>
            </section>

            <section class="dashboard-panel is-active" data-panel="plans">
                <div class="section-header">
                    <h2></h2>
                    <p>Наборы анализов, которые сейчас отслеживаются.</p>
                </div>

                <div class="dashboard-grid">

                    @foreach($checklists as $checklist)
                        @php

                            $image = match($checklist->testPanel->slug ?? '') {
                                'basic-checkup' => 'base.png',
                                'demo-iron-anemia' => 'iron.png',
                                'demo-thyroid' => 'thyroid.jpg',
                                'demo-heart-metabolism' => 'обмен.jpg',
                                default => 'base.png',
                            };

                            $items = $checklist->items;
                            $total = $items->count();
                            $attention = $items->whereIn('status', ['urgent', 'needs_control', 'overdue'])->count();
                            $title = $checklist->testPanel->name ?? 'План анализов';
                        @endphp

                            <article
                                class="card plan-card"
                                style="background-image: url('{{ asset('assets/my-checklist/' . $image) }}');"
                            >
                            <h3>{{ $title }}</h3>
                            <p>
                                {{ $checklist->testPanel->description ?? 'Персональный набор показателей для контроля.' }}
                            </p>

                            <div class="mini-meta">
                                <span>Показателей: {{ $total }}</span>
                                <span>Требует внимания: {{ $attention }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="dashboard-panel metrics-panel" data-panel="markers">
                <div class="section-header">
                    <h2></h2>
                    <p>Несколько показателей, которые сейчас важнее всего.</p>
                </div>

                <div class="dashboard-grid5">
                    @foreach($keyItems as $item)
                        @php
                            $label = $statusLabels[$item->status] ?? 'Не сдан';
                            $result = $item->lastAnalysisItem
                                ? trim(($item->lastAnalysisItem->value_text ?? $item->lastAnalysisItem->value) . ' ' . $item->lastAnalysisItem->unit)
                                : '—';
                        @endphp

                        <article
                            class="card5 card-tag dashboard-card js-open-marker-modal status-{{ str_replace('_', '-', $item->status) }}"
                            data-title="{{ e($item->marker->name ?? 'Показатель') }}"
                            data-status="{{ e($label) }}"
                            data-status-class="status-{{ str_replace('_', '-', $item->status) }}"
                            data-note="{{ e($item->note ?? 'Рекомендуется проверить показатель в динамике.') }}"
                            data-result="{{ e($result) }}"
                            data-reference="{{ e($item->lastAnalysisItem->reference_range ?? '—') }}"
                            data-last="{{ e($item->last_tested_at ? $item->last_tested_at->format('d.m.Y') : '—') }}"
                            data-next="{{ e($item->next_due_at ? $item->next_due_at->format('d.m.Y') : '—') }}"
                            data-url="{{ $item->marker ? url('/markers/' . $item->marker->slug) : '#' }}"
                        >
                            <span class="status-badge status-{{ str_replace('_', '-', $item->status) }}">
                                {{ $label }}
                            </span>

                            <h3 class="marker-card5-title">
                                {{ $item->marker->name ?? 'Показатель' }}
                            </h3>

                            <p class="card-note">
                                <span class="card-note-label">
                                    Последний анализ
                                </span>

                                <br>

                                <span class="card-note-value">
                                    {{ $item->last_tested_at ? $item->last_tested_at->format('d.m.Y') : '—' }}
                                </span>
                            </p>

                            @if($item->lastAnalysisItem)
                                <div class="marker-result">
                                    <div>
                                        <span class="marker-result-label">
                                            Результат
                                        </span>
                                        
                                        <br>        

                                        <span class="marker-result-value">
                                            {{ $result }}
                                        </span>
                                    </div>

                                    <div>
                                        <span class="marker-reference-label">
                                            Норма
                                        </span>

                                        <br>    

                                        <span class="marker-reference-value">
                                            {{ $item->lastAnalysisItem->reference_range ?? '—' }}
                                        </span>
                                        

                                        
                                    </div>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="dashboard-panel" data-panel="history">
                <div class="section-header with-link">
                    <div>
                        <h2></h2>
                        <p>Последние загруженные анализы и обновления плана.</p>
                    </div>

                    <a href="/analysis-history" class="text-link">Смотреть всё</a>
                </div>

                <div class="card list-card">
                    @forelse($recentAnalyses ?? [] as $analysis)
                        <div class="list-row">
                            <div>
                                <strong>
                                    Анализ от {{ $analysis->created_at ? $analysis->created_at->format('d.m.Y') : '—' }}
                                </strong>

                                <span>
                                    {{ $analysis->summary ?? 'Результат анализа сохранён в DSlog.' }}
                                </span>
                            </div>

                            <div class="list-date">
                                {{ $analysis->created_at ? $analysis->created_at->format('H:i') : '' }}
                            </div>
                        </div>
                    @empty
                        <p class="muted">Пока нет загруженных анализов.</p>
                    @endforelse
                </div>
            </section>

            <div class="dashboard-modal" id="markerModal" hidden>
                <div class="dashboard-modal-backdrop" data-close-modal></div>

                <div class="dashboard-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
                    <button type="button" class="dashboard-modal-close" data-close-modal aria-label="Закрыть">×</button>

                    <span class="status-badge" id="modalStatus"></span>

                    <h2 id="modalTitle"></h2>

                    <p id="modalNote"></p>

                    <div class="marker-result modal-result">
                        <div>
                            <span>Ваш результат</span>
                            <strong id="modalResult">—</strong>
                        </div>

                        <div>
                            <span>Референс</span>
                            <strong id="modalReference">—</strong>
                        </div>
                    </div>

                    <div class="modal-meta">
                        <div>
                            <span>Последний анализ</span>
                            <strong id="modalLast">—</strong>
                        </div>

                        <div>
                            <span>Следующий контроль</span>
                            <strong id="modalNext">—</strong>
                        </div>
                    </div>

                    <a href="#" class="btn btn-secondary" id="modalUrl">
                        Подробнее о показателе
                    </a>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const tabs = document.querySelectorAll('.dashboard-tab');
                    const panels = document.querySelectorAll('.dashboard-panel');

                    tabs.forEach(tab => {
                        tab.addEventListener('click', function () {
                            const target = tab.dataset.tab;

                            tabs.forEach(item => item.classList.remove('is-active'));
                            panels.forEach(panel => panel.classList.remove('is-active'));

                            tab.classList.add('is-active');

                            const activePanel = document.querySelector(`[data-panel="${target}"]`);
                            if (activePanel) {
                                activePanel.classList.add('is-active');
                            }
                        });
                    });

                    const modal = document.getElementById('markerModal');
                    const modalTitle = document.getElementById('modalTitle');
                    const modalStatus = document.getElementById('modalStatus');
                    const modalNote = document.getElementById('modalNote');
                    const modalResult = document.getElementById('modalResult');
                    const modalReference = document.getElementById('modalReference');
                    const modalLast = document.getElementById('modalLast');
                    const modalNext = document.getElementById('modalNext');
                    const modalUrl = document.getElementById('modalUrl');

                    function closeMarkerModal() {
                        if (!modal) {
                            return;
                        }

                        modal.hidden = true;
                        document.body.classList.remove('modal-open');
                    }

                    document.querySelectorAll('.js-open-marker-modal').forEach(card => {
                        card.addEventListener('click', function () {
                            if (!modal) {
                                return;
                            }

                            modalTitle.textContent = card.dataset.title || 'Показатель';
                            modalStatus.textContent = card.dataset.status || '';
                            modalStatus.className = `status-badge ${card.dataset.statusClass || ''}`.trim();
                            modalNote.textContent = card.dataset.note || '';
                            modalResult.textContent = card.dataset.result || '—';
                            modalReference.textContent = card.dataset.reference || '—';
                            modalLast.textContent = card.dataset.last || '—';
                            modalNext.textContent = card.dataset.next || '—';
                            modalUrl.href = card.dataset.url || '#';

                            modal.hidden = false;
                            document.body.classList.add('modal-open');
                        });
                    });

                    document.querySelectorAll('[data-close-modal]').forEach(button => {
                        button.addEventListener('click', closeMarkerModal);
                    });

                    document.addEventListener('keydown', function (event) {
                        if (event.key === 'Escape' && modal && !modal.hidden) {
                            closeMarkerModal();
                        }
                    });
                });
            </script>
        @endif
    </main>
</div>
@endsection
