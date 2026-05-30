@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <span>Показатели</span>
    </div>
@endsection

@section('content')
<div class="ds-container">
    <main class="product-page search-page">
        <a href="/" class="back-link">← На главную</a>

        <section class="page-hero">
            <div>
                <p class="eyebrow">DSlog</p>

                <h1>
                    @if($query)
                        Результаты поиска
                    @else
                        Поиск показателей
                    @endif
                </h1>

                <p class="lead">
                    Найдите нужный анализ, показатель или маркер здоровья.
                </p>
            </div>
        </section>

        <section class="search-section">
            <form action="/search" method="GET" class="search-page-form">
                <input
                    type="search"
                    name="q"
                    value="{{ $query }}"
                    placeholder="Например: ферритин, ТТГ, гемоглобин"
                    class="search-page-input"
                    autofocus
                >

                <button type="submit" class="btn btn-primary">
                    Найти
                </button>
            </form>


            <div class="search-suggestions">
                <span>Популярное:</span>

                <a href="/search?q=гемоглобин">Гемоглобин</a>
                <a href="/search?q=ферритин">Ферритин</a>
                <a href="/search?q=ТТГ">ТТГ</a>
                <a href="/search?q=глюкоза">Глюкоза</a>
                <a href="/search?q=витамин D">Витамин D</a>
                <a href="/search?q=холестерин">Холестерин</a>
            </div>

        </section>




        @if($query)
            <section class="section">
                <div class="section-header">
                    <h2>
                        Найдено: {{ $markers->count() }}
                    </h2>
                </div>

                @if($markers->isEmpty())
                    <div class="card empty-state">
                        <h3>Ничего не найдено</h3>

                        <p>
                            Попробуйте другой запрос или проверьте написание.
                        </p>
                    </div>
                @else
                    <div class="dashboard-grid">
                        @foreach($markers as $marker)
                            <a
                                href="{{ url('/markers/' . $marker->slug) }}"
                                class="card card-link"
                            >
                                <h3>{{ $marker->name }}</h3>

                                @if($marker->group)
                                    <p>
                                        {{ $marker->group->name }}
                                    </p>
                                @endif

                                <span class="text-link">
                                    Открыть показатель →
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    </main>
</div>

@endsection