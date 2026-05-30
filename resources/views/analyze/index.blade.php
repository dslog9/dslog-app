@extends('layouts.app')

@section('pageTitle', 'Загрузка анализа')
@section('title', 'DSlog — Расшифровка анализов')
@section('description', 'Вставьте текст анализа или загрузите файл для расшифровки.')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="/">Главная</a> →
        <span>Загрузка анализа</span>
    </div>
@endsection

@section('content')
<div class="ds-container">
    <main class="analyze-page">

        <section class="analyze-layout">

            <div class="analyze-copy">
                <div class="section-kicker">
                    Расшифровка анализов
                </div>

                <h1>
                    Загрузите анализ — DSlog разберёт показатели
                </h1>

                <p class="lead">
                    Вставьте текст анализа или загрузите файл. Система сопоставит показатели с маркерами,
                    сравнит значения с диапазонами нормы и обновит ваш план анализов.
                </p>

                <div class="analyze-steps">
                    <div>
                        <span>1</span>
                        <p>Распознаём показатели анализа</p>
                    </div>

                    <div>
                        <span>2</span>
                        <p>Сравниваем значения с персональными диапазонами</p>
                    </div>

                    <div>
                        <span>3</span>
                        <p>Обновляем чеклист и статусы контроля</p>
                    </div>
                </div>
            </div>

            <div class="analyze-card">
                <h2>Анализ результата</h2>

                <p class="analyze-card-note">
                    Пока это MVP-версия с тестовой логикой ответа.
                </p>

                <label for="text">Текст анализа</label>

                <textarea
                    id="text"
                    placeholder="Например: Гемоглобин 110 г/л, норма 120–160"
                ></textarea>

                <label for="file">Файл анализа</label>

                <div class="file-box">
                    <input type="file" id="file" name="file">
                </div>

                <button id="analyzeBtn" class="btn btn-primary analyze-submit" onclick="send()">
                    Анализировать
                </button>

                <h2 class="result-title">Результат</h2>

                <div id="result" class="result-box">—</div>
            </div>

        </section>

    </main>
</div>

<script>
    
let lastInputType = null;

const textInput = document.getElementById('text');
const fileInput = document.getElementById('file');

textInput.addEventListener('input', function () {
    if (textInput.value.trim() !== '') {
        lastInputType = 'text';
    }
});

/* сбрасываем value, чтобы тот же файл можно было выбрать повторно */
fileInput.addEventListener('click', function () {
    fileInput.value = '';
});

fileInput.addEventListener('change', function () {
    if (fileInput.files.length > 0) {
        lastInputType = 'file';
    }
});

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

async function send() {
    const text = textInput.value.trim();
    const result = document.getElementById('result');
    const button = document.getElementById('analyzeBtn');

    const formData = new FormData();

    if (lastInputType === 'file' && fileInput.files.length > 0) {
        formData.append('input_type', 'file');
        formData.append('file', fileInput.files[0]);
    } else if (lastInputType === 'text' && text) {
        formData.append('input_type', 'text');
        formData.append('text', text);
    } else if (fileInput.files.length > 0) {
        formData.append('input_type', 'file');
        formData.append('file', fileInput.files[0]);
    } else if (text) {
        formData.append('input_type', 'text');
        formData.append('text', text);
    } else {
        result.innerHTML = '<span class="error">Введите текст или выберите файл.</span>';
        return;
    }

    button.disabled = true;
    button.textContent = 'Обработка...';

    result.innerHTML = '<div class="loading">Обрабатываем данные...</div>';

    try {
        const response = await fetch('/api/analyze', {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData
        });

        const data = await response.json();

        if (!response.ok || data.status === 'error') {
            result.innerHTML =
                '<span class="error">' +
                escapeHtml(data.error?.message || 'Произошла ошибка.') +
                '</span>';
            return;
        }

        const extractedText = data.data?.extracted_text || '-';
        const analysis = data.data?.analysis || {};
        const inputType = data.data?.input?.type || '-';
        const inputMode = data.data?.input?.mode || '-';
        const processingTimeMs = data.meta?.processing_time_ms ?? '-';

        const risks = Array.isArray(analysis.risks)
            ? analysis.risks.map(escapeHtml).join('<br>')
            : escapeHtml(analysis.risks || '-');

        const recommendations = Array.isArray(analysis.recommendations)
            ? analysis.recommendations.map(escapeHtml).join('<br>')
            : escapeHtml(analysis.recommendations || '-');

        result.innerHTML =
            '<div class="result-item"><strong>Последний ввод</strong><span>' + escapeHtml(inputMode) + '</span></div>' +
            '<div class="result-item"><strong>Тип входа</strong><span>' + escapeHtml(inputType) + '</span></div>' +
            '<div class="result-item"><strong>Распознанный текст</strong><span class="pre-wrap">' + escapeHtml(extractedText) + '</span></div>' +
            '<div class="result-item"><strong>Кратко</strong><span>' + escapeHtml(analysis.summary || '-') + '</span></div>' +
            '<div class="result-item"><strong>Детали</strong><span>' + escapeHtml(analysis.details || '-') + '</span></div>' +
            '<div class="result-item"><strong>Риски</strong><span>' + risks + '</span></div>' +
            '<div class="result-item"><strong>Рекомендации</strong><span>' + recommendations + '</span></div>' +
            '<div class="result-item"><strong>Время обработки</strong><span>' + escapeHtml(processingTimeMs) + ' мс</span></div>';
    } catch (error) {
        result.innerHTML = '<span class="error">Ошибка запроса: ' + escapeHtml(error.message) + '</span>';
    } finally {
        button.disabled = false;
        button.textContent = 'Анализировать';
    }
}
</script>
@endsection