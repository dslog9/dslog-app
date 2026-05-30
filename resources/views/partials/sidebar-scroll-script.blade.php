<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sections = Array.from(document.querySelectorAll('section[id]'));
        const links = Array.from(document.querySelectorAll('.sidebar a'));

        if (!sections.length || !links.length) return;

        function activateLink() {
            let current = sections[0]?.id || '';
            const scrollPosition = window.scrollY + 190;

            sections.forEach(section => {
                if (section.offsetTop <= scrollPosition) {
                    current = section.id;
                }
            });

            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 20) {
                current = sections[sections.length - 1]?.id || current;
            }

            links.forEach(link => {
                link.classList.toggle(
                    'active',
                    link.getAttribute('href') === '#' + current
                );
            });
        }

        window.addEventListener('scroll', activateLink, { passive: true });
        window.addEventListener('resize', activateLink);
        activateLink();
    });
</script>
