@extends('layouts.app')

@section('title', 'Panel Studio — DSlog Internal')

@section('content')

<div class="ds-container">
    <div class="page">

        <h1>Panel Studio</h1>

        <p class="muted">
            Конструктор чекапов и контроль готовности панелей.
        </p>

        <div class="card">

            <div class="table-responsive">
                <table class="internal-table">

                    <thead>
                        <tr>
                            <th>Панель</th>
                            <th>Тип</th>
                            <th>Пол</th>
                            <th>Возраст</th>
                            <th>Маркеры</th>
                            <th>Секции</th>
                            <th>FAQ</th>
                            <th>Контент</th>
                            <th>Related</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($panels as $panel)

                            <tr>

                            <td>
                                <a href="{{ route('internal.panels.show', $panel) }}">
                                    <strong>{{ $panel->name }}</strong>
                                </a>

                                <div class="muted small">
                                    {{ $panel->slug }}
                                </div>
                            </td>

                                <td>
                                    {{ $panel->panel_type ?? '—' }}
                                </td>

                                <td>
                                    {{ $panel->gender ?? 'all' }}
                                </td>

                                <td>
                                    @if($panel->age_min || $panel->age_max)
                                        {{ $panel->age_min ?? '0' }}
                                        –
                                        {{ $panel->age_max ?? '+' }}
                                    @else
                                        all
                                    @endif
                                </td>

                                <td>
                                    {{ $panel->panel_markers_count }}
                                </td>

                                <td>
                                    {{ $panel->sections_count }}
                                </td>

                                <td>
                                    {{ $panel->faqs_count }}
                                </td>

                                <td>
                                    {{ $panel->content_blocks_count }}
                                </td>

                                <td>
                                    {{ $panel->related_panels_count }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9">
                                    Панели не найдены.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>

@endsection