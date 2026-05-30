@extends('layouts.app')

@section('content')
    <main style="max-width: 1040px; margin: 0 auto; padding: 48px 20px;">
        <a href="/" style="display:inline-block;margin-bottom:24px;color:#667085;text-decoration:none;">
            ← На главную
        </a>

        <h1 style="font-size:36px;line-height:1.15;margin:0 0 12px;">
            Мой план анализов
        </h1>

        <p style="font-size:17px;color:#667085;max-width:720px;margin:0 0 36px;">
            Здесь собраны ваши чеклисты анализов, сроки повторной сдачи и показатели, которые требуют внимания.
        </p>

        @if($checklists->isEmpty())
            <div style="border:1px solid #e5e7eb;border-radius:18px;padding:28px;background:#fff;">
                <h2 style="margin:0 0 8px;font-size:22px;">Пока нет чеклистов</h2>
                <p style="margin:0;color:#667085;">
                    После выбора плана анализов или загрузки результата здесь появятся ваши показатели.
                </p>
            </div>
        @else
            <div style="display:grid;gap:24px;">
                @foreach($checklists as $checklist)
                    @php
                        $items = $checklist->items;

                        $total = $items->count();
                        $done = $items->where('status', 'done')->count();
                        $needs = $items->where('status', 'needs_control')->count();
                        $urgent = $items->where('status', 'urgent')->count();
                        $overdue = $items->where('status', 'overdue')->count();
                        $notDone = $items->where('status', 'not_done')->count();

                        $title = $checklist->testPanel->name ?? 'План анализов';
                    @endphp

                    <section style="border:1px solid #e5e7eb;border-radius:22px;background:#fff;overflow:hidden;">
                        <div style="padding:24px 28px;border-bottom:1px solid #eef2f7;background:#f8fafc;">
                            <div style="display:flex;justify-content:space-between;gap:20px;align-items:flex-start;flex-wrap:wrap;">
                                <div>
                                    <h2 style="font-size:24px;margin:0 0 8px;">
                                        {{ $title }}
                                    </h2>

                                    <p style="margin:0;color:#667085;">
                                        {{ $checklist->testPanel->description ?? 'Персональный набор показателей для контроля здоровья.' }}
                                    </p>
                                </div>

                                <div style="font-size:14px;color:#667085;">
                                    ID: {{ $checklist->id }}
                                </div>
                            </div>

                            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:18px;">
                                <span style="padding:6px 10px;border-radius:999px;background:#eef2ff;color:#344054;font-size:14px;">
                                    Всего: {{ $total }}
                                </span>

                                <span style="padding:6px 10px;border-radius:999px;background:#ecfdf3;color:#067647;font-size:14px;">
                                    Норма: {{ $done }}
                                </span>

                                <span style="padding:6px 10px;border-radius:999px;background:#fff7ed;color:#c2410c;font-size:14px;">
                                    Отклонения: {{ $needs }}
                                </span>

                                <span style="padding:6px 10px;border-radius:999px;background:#fef2f2;color:#b42318;font-size:14px;">
                                    Срочно: {{ $urgent }}
                                </span>

                                <span style="padding:6px 10px;border-radius:999px;background:#fef3c7;color:#92400e;font-size:14px;">
                                    Просрочено: {{ $overdue }}
                                </span>

                                <span style="padding:6px 10px;border-radius:999px;background:#f2f4f7;color:#475467;font-size:14px;">
                                    Не сдано: {{ $notDone }}
                                </span>
                            </div>
                        </div>

                        <div style="display:grid;">
                            @foreach($items->sortBy(fn($item) => $item->marker->name ?? '') as $item)
                                @php
                                    $label = match($item->status) {
                                        'done' => 'Норма',
                                        'needs_control' => 'Есть отклонение',
                                        'urgent' => 'Требует внимания',
                                        'overdue' => 'Просрочено',
                                        default => 'Не сдан'
                                    };

                                    $style = match($item->status) {
                                        'done' => 'background:#ecfdf3;color:#067647;',
                                        'needs_control' => 'background:#fff7ed;color:#c2410c;',
                                        'urgent' => 'background:#fef2f2;color:#b42318;',
                                        'overdue' => 'background:#fef3c7;color:#92400e;',
                                        default => 'background:#f2f4f7;color:#475467;'
                                    };
                                @endphp

                                <div style="display:grid;grid-template-columns:1fr auto;gap:18px;padding:18px 28px;border-bottom:1px solid #eef2f7;">
                                    <div>
                                        <div style="font-size:17px;font-weight:600;color:#172033;">
                                            {{ $item->marker->name ?? '-' }}
                                        </div>

                                        @if($item->note)
                                            <div style="font-size:14px;color:#667085;margin-top:4px;">
                                                {{ $item->note }}
                                            </div>
                                        @endif

                                        <div style="font-size:13px;color:#98a2b3;margin-top:8px;">
                                            Последний анализ:
                                            {{ $item->last_tested_at ? $item->last_tested_at->format('d.m.Y') : '—' }}
                                            ·
                                            Следующая сдача:
                                            {{ $item->next_due_at ? $item->next_due_at->format('d.m.Y') : '—' }}
                                        </div>
                                    </div>

                                    <div>
                                        <span style="display:inline-block;padding:7px 11px;border-radius:999px;font-size:14px;font-weight:600;{{ $style }}">
                                            {{ $label }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </main>
@endsection