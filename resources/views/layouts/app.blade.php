<!DOCTYPE html>
<html lang="ru">
<head>
    @include('partials.analytics')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DSlog')</title>
    <meta name="description" content="@yield('description', 'DSlog — расшифровка анализов простым языком')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/layout.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/pages.css">
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/markers.css">
    <link rel="stylesheet" href="/assets/css/checklist.css">
    <link rel="stylesheet" href="/assets/css/plans.css">
    <link rel="stylesheet" href="/assets/css/items.css">
    <link rel="stylesheet" href="/assets/css/effects.css">
    <link rel="stylesheet" href="/assets/css/seo-content.css">
    <link rel="stylesheet" href="/assets/css/checklist-dynamics.css">
    <link rel="stylesheet" href="/assets/css/internal/controls.css">
    <link rel="stylesheet" href="/assets/css/internal/constructors.css">
    
    @stack('styles')
</head>
<body>
    @include('partials.header')

    <main>
        <article class="article-card">
            @hasSection('image')
                <img class="hero-image" src="@yield('image')" alt="@yield('image_alt', 'Иллюстрация статьи')">
            @endif

            @yield('content')
        </article>
    </main>

    @include('partials.footer')

    @include('partials.sidebar-scroll-script')
    @include('partials.analytics-events')
    @stack('scripts')

<script>
(function () {
/*    var breadcrumbsCompactAt = 40;
    var breadcrumbsExpandAt = 12;

    var compactAt = 150;
    var expandAt = 80;
*/

var compactAt = 70;
var expandAt = 30;

var breadcrumbsCompactAt = 150;
var breadcrumbsExpandAt = 90;


    var ticking = false;

    function updateHeader() {
        var isBreadcrumbsHidden = document.body.classList.contains('header-breadcrumbs-hidden');
        var isCompact = document.body.classList.contains('header-compact');
        var y = window.scrollY || window.pageYOffset;

        if (!isBreadcrumbsHidden && y > breadcrumbsCompactAt) {
            document.body.classList.add('header-breadcrumbs-hidden');
        }

        if (isBreadcrumbsHidden && y < breadcrumbsExpandAt) {
            document.body.classList.remove('header-breadcrumbs-hidden');
        }

        if (!isCompact && y > compactAt) {
            document.body.classList.add('header-compact');
        }

        if (isCompact && y < expandAt) {
            document.body.classList.remove('header-compact');
        }

        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(updateHeader);
            ticking = true;
        }
    }, { passive: true });

    updateHeader();
})();
</script>

</body>
</html>
