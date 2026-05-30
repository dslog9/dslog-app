@if($plan->faqs->count())
    <section class="seo-section">
        <div class="seo-section-header">
            <h2>Частые вопросы</h2>

            <p class="seo-text">
                Ответы на частые вопросы о составе чекапа, подготовке и дальнейших шагах.
            </p>
        </div>

        <div class="faq-list">
            @foreach($plan->faqs as $faq)
                <details class="faq-item">
                    <summary>{{ $faq->question }}</summary>
                    <p>{{ $faq->answer }}</p>
                </details>
            @endforeach
        </div>
    </section>
@endif