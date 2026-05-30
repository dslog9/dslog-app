<header class="site-header" id="siteHeader">
    <div class="header-top">
        <div class="header-inner">
            <a href="/" class="brand" aria-label="DSlog — на главную">
                <img src="/assets/logo/dslog-logo.png" alt="DSlog" class="brand-logo">
            </a>

            <form action="/search" method="GET" class="header-search">
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Найти показатель"
                    aria-label="Поиск по показателям"
                >
            </form>

            <nav class="top-nav" aria-label="Главная навигация">
                <a href="/analyze-ui">Загрузить результаты</a>
                <a href="/markers/az">Все маркеры</a>
                <a href="/plans">Планы анализов</a>
                <a href="/my-checklist">Мой план</a>
            </nav>
        </div>
    </div>

    <div class="header-bottom">
        <div class="header-bottom-inner">
            <div class="header-page-title">
                @yield('pageTitle', 'DSlog')
            </div>

            @hasSection('pageSubtitle')
                <div class="header-page-subtitle">
                    @yield('pageSubtitle')
                </div>
            @endif
        </div>
    </div>



            @hasSection('breadcrumbs')
                <div class="header-breadcrumbs">
                    <div class="header-breadcrumbs-inner">
                        @yield('breadcrumbs')
                    </div>
                </div>
            @endif

</header>