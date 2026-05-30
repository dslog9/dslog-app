@extends('layouts.app')

@section('title', 'Мой план')

@section('content')

<div class="page">
    <div class="ds-container dynamics-page">
        <div class="page-header">
            <h1>Мой план</h1>

            <p class="muted">
                Личный кабинет для планов анализов, динамики показателей и загруженных данных.
            </p>
        </div>

        <div class="dashboard-grid dashboard-grid-plans">

            <a href="{{ route('checklist.plans') }}" class="dashboard-card">
                <h2>Мой планы</h2>
                <p class="muted">
                    Чекапы и наборы анализов, которые вы добавили в личный план.
                </p>
            </a>

            <a href="{{ route('checklist.dynamics') }}" class="dashboard-card">
                <h2>Динамика</h2>
                <p class="muted">
                    История показателей, графики и изменения результатов во времени.
                </p>
            </a>

            <a href="{{ route('checklist.uploads') }}" class="dashboard-card">
                <h2>Загруженные данные</h2>
                <p class="muted">
                    Анализы, файлы и прочие документы, которые вы добавили в DSlog.
                </p>
            </a>

            <a href="{{ route('checklist.profile') }}" class="dashboard-card">
                <h2>Профиль</h2>
                <p class="muted">
                    Пол, возраст и другие данные, которые влияют на персональную оценку.
                </p>
            </a>

        </div>
    </div>
</div>

@endsection