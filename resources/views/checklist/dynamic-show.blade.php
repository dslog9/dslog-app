@extends('layouts.app')

@section('title', 'Динамика — ' . $marker->name)

@section('content')


<div class="page">
    <div class="ds-container dynamics-page">

        <div class="page-header">
            <a href="{{ route('checklist.dynamics') }}" class="muted">
                ← Динамика
            </a>

            <h1>{{ $marker->name }}</h1>

            <p class="muted">
                История результатов показателя.
            </p>
        </div>

        @php
            $latestItem = $history->last();
            $previousItem = $history->count() > 1 ? $history->slice(-2, 1)->first() : null;

            $latestEvaluation = $latestItem?->latestEvaluation;
            $latestStatus = $latestEvaluation?->status ?? 'unknown';

            $delta = null;

            if ($latestItem && $previousItem && $latestItem->value !== null && $previousItem->value !== null) {
                $delta = (float) $latestItem->value - (float) $previousItem->value;
            }

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

        <div class="dashboard-grid dashboard-grid-documents">

            <article class="dashboard-card">
                <h2>Последний результат</h2>

                <p class="muted">
                    {{ $latestItem?->value_text ?? $latestItem?->value ?? '—' }}
                    {{ $latestItem?->unit }}
                </p>
            </article>

            <article class="dashboard-card">
                <h2>Статус</h2>

                <span class="status-badge status-{{ $latestStatus }}">
                    {{ $statusLabels[$latestStatus] ?? $latestStatus }}
                </span>
            </article>

            <article class="dashboard-card">
                <h2>Изменение</h2>

                <p class="muted">
                    @if($delta === null)
                        Недостаточно данных
                    @elseif($delta > 0)
                        +{{ $delta }}
                    @else
                        {{ $delta }}
                    @endif
                </p>
            </article>

        </div>

        @if(count($chart['points']) > 0)

            <div class="dashboard-card chart-card">

                <div class="dashboard-card-header">
                    <div>
                        <h2>График динамики</h2>
                        <p class="muted">
                            Значения, нормы и текущий статус показателя.
                        </p>
                    </div>
                </div>

                <div class="dashboard-card-body">
                    <div
                        id="markerDynamicsChart"
                        class="marker-apex-chart"
                        data-marker-name="{{ $marker->name }}"
                        data-points='@json($chart["points"])'
                        data-lines='@json($chart["lines"])'
                        data-zones='@json($chart["zones"])'
                        data-scale-min="{{ $chart['scale_min'] }}"
                        data-scale-max="{{ $chart['scale_max'] }}"
                    ></div>
                    @if(count($chart['points']) === 1)
                        <p class="muted chart-hint">
                            Загрузите следующий анализ, чтобы увидеть динамику изменений.
                        </p>
                    @endif
                </div>

            </div>

        @endif


        <div class="dashboard-card">

            <div class="dashboard-card-header">
                <h2>История</h2>
            </div>

        <div class="dashboard-card-body">

            @if($history->count())

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Значение</th>
                                <th>Статус</th>
                                <th>Источник</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($history->reverse() as $item)

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

                                <tr>
                                    <td>
                                        {{ $item->analysis?->analyzed_at
                                            ? \Carbon\Carbon::parse($item->analysis->analyzed_at)->format('d.m.Y')
                                            : $item->created_at?->format('d.m.Y') }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $item->value_text ?? $item->value }}
                                            {{ $item->unit }}
                                        </strong>
                                    </td>

                                    <td>
                                        <span class="status-badge status-{{ $status }}">
                                            {{ $statusLabels[$status] ?? $status }}
                                        </span>
                                    </td>

                                    <td>
                                        Анализ #{{ $item->analysis_id }}
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="empty-state">
                    Пока нет истории по этому показателю.
                </div>

            @endif

        </div>

        </div>

    </div>

<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/charts/marker-dynamics-chart.js') }}"></script>

    
    </div>
</div>
@endsection