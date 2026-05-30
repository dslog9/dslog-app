@extends('layouts.app')

@section('pageTitle', 'Показатели')
@section('title', 'DSlog — понятная расшифровка анализов')
@section('description', 'DSlog помогает понять показатели анализов, отклонения, нормы и план повторного контроля.')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <span>Показатели</span>
    </div>
@endsection

@section('content')
<div class="ds-container">
    <main class="home-page">

        <section class="home-hero">
            <div class="home-hero-content">
                <div class="section-kicker">
                    DSlog · расшифровка анализов
                </div>

                <h1>
                    Понятный план анализов и контроль показателей
                </h1>

                <p class="lead">
                    Загружайте результаты анализов, смотрите отклонения, отслеживайте сроки повторной сдачи
                    и собирайте персональный план контроля здоровья.
                </p>

                <div class="hero-actions">
                    <a href="/analyze-ui" class="btn btn-primary">
                        Загрузить анализ
                    </a>

                    <a href="/my-checklist" class="btn btn-secondary">
                        Мой план анализов
                    </a>
                </div>
            </div>
        </section>

        <section class="home-feature-grid">
            <div class="home-feature-card">
                <h2>Расшифровка</h2>
                <p>
                    Анализ разбивается на отдельные показатели и связывается с базой маркеров.
                </p>
            </div>

            <div class="home-feature-card">
                <h2>Персональные нормы</h2>
                <p>
                    Диапазоны учитывают пол и возраст, а не просто показывают общую справку.
                </p>
            </div>

            <div class="home-feature-card">
                <h2>Чеклист</h2>
                <p>
                    Система отмечает, что уже сдано, что требует внимания и что пора пересдать.
                </p>
            </div>
        </section>

        <section class="home-how">
            <h2>Как это работает</h2>

            <div class="home-steps">
                <div>
                    <span>1</span>
                    <p>Вы загружаете анализ или вводите показатели вручную.</p>
                </div>

                <div>
                    <span>2</span>
                    <p>DSlog сопоставляет показатели с медицинскими маркерами.</p>
                </div>

                <div>
                    <span>3</span>
                    <p>Система сравнивает значения с диапазонами нормы.</p>
                </div>

                <div>
                    <span>4</span>
                    <p>Ваш план анализов обновляется автоматически.</p>
                </div>
            </div>
        </section>

        <section class="home-link-grid">
            <a href="/markers" class="home-link-card">
                <h2>Справочник показателей</h2>
                <p>
                    Гемоглобин, ферритин, ТТГ, глюкоза, холестерин и другие маркеры.
                </p>
            </a>

            <a href="/markers?view=az" class="home-link-card">
                <h2>A–Z каталог</h2>
                <p>
                    Быстрый список всех показателей по алфавиту.
                </p>
            </a>
        </section>

    </main>
</div>
@endsection