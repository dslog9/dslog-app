@extends('layouts.app')

@section('content')

<div class="ds-container">
    <div class="page">

        <h1>DSlog Internal</h1>

        <p class="muted">
            Внутренняя система контроля покрытия, качества и медицинских правил.
        </p>

        <section class="internal-section">
            <h2 class="internal-section-title">Controls</h2>

            <div class="dashboard-grid">

                <a class="card" href="{{ route('internal.controls.markers.index') }}">
                    <h3>Marker coverage</h3>
                    <p>
                        Полнота маркеров по слоям: applicability, scoring rules,
                        ranges, synonyms, content, panels и issues.
                    </p>
                </a>

                <a class="card" href="{{ route('internal.controls.markers.index', ['layer' => 'scoring']) }}">
                    <h3>Scoring gaps</h3>
                    <p>
                        Быстрый вход в missing scoring rules для applicable profiles.
                    </p>
                </a>

                <div class="card">
                    <h3>Scoring</h3>
                    <p>
                        Профили, зоны, правила оценки и gaps.
                    </p>
                </div>

                <div class="card">
                    <h3>Content</h3>
                    <p>
                        FAQ, page blocks, related markers и SEO completeness.
                    </p>
                </div>

                <div class="card">
                    <h3>Quality</h3>
                    <p>
                        Очереди задач, readiness score и контроль покрытия.
                    </p>
                </div>

            </div>
        </section>

        <section class="internal-section">
            <h2 class="internal-section-title">Constructors</h2>

            <div class="dashboard-grid">

                <a href="{{ route('internal.panels.index') }}" class="card">
                    <h3>Panel Studio</h3>
                    <p>
                        Конструктор чекапов: секции, маркеры, частоты,
                        контент, FAQ, связанные панели и readiness.
                    </p>
                </a>

            </div>
        </section>

    </div>
</div>

@endsection