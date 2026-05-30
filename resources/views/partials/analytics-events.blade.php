<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cta = document.getElementById('cta-check-analysis');

        if (cta) {
            cta.addEventListener('click', function () {
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'cta_click', {
                        event_category: 'engagement',
                        event_label: 'check_analysis'
                    });
                }
            });
        }
    });
</script>

<script>
    let scrollTracked = false;

    window.addEventListener('scroll', function () {
        if (scrollTracked) return;

        const scrollPercent = (window.scrollY + window.innerHeight) / document.body.scrollHeight;

        if (scrollPercent > 0.7) {
            scrollTracked = true;

            if (typeof gtag !== 'undefined') {
                gtag('event', 'scroll_70', {
                    event_category: 'engagement',
                    event_label: 'read_article'
                });
            }
        }
    }, { passive: true });
</script>
