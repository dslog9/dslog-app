<?php

namespace App\Services;

use App\Models\Analysis;
use App\Models\UserChecklist;
use App\Models\UserChecklistItem;
use Illuminate\Support\Carbon;

class ChecklistProgressService
{
    public function applyAnalysis(UserChecklist $checklist, Analysis $analysis): int
    {
        $updated = 0;

        foreach ($analysis->items as $analysisItem) {
            if (! $analysisItem->marker_id) {
                continue;
            }

            $checklistItem = UserChecklistItem::query()
                ->where('user_checklist_id', $checklist->id)
                ->where('marker_id', $analysisItem->marker_id)
                ->first();

            if (! $checklistItem) {
                continue;
            }

            $testedAt = $analysis->analyzed_at ?? $analysis->created_at ?? now();

            $status = match ($analysisItem->status) {
                'normal' => 'done',
                'low', 'high', 'borderline_low', 'borderline_high' => 'needs_control',
                'critical_low', 'critical_high' => 'urgent',
                default => 'not_done',
            };

            $checklistItem->update([
                'status' => $status,
                'last_tested_at' => $testedAt,
                'next_due_at' => $checklistItem->frequency_months
                    ? Carbon::parse($testedAt)->addMonths($checklistItem->frequency_months)
                    : null,
                'last_analysis_item_id' => $analysisItem->id,
            ]);

            $updated++;
        }

        $checklist->update([
            'last_analysis_id' => $analysis->id,
        ]);

        return $updated;
    }

public function refreshOverdue(UserChecklist $checklist): int
{
    return UserChecklistItem::query()
        ->where('user_checklist_id', $checklist->id)
        ->whereNotNull('next_due_at')
        ->where('next_due_at', '<', now())
        ->whereIn('status', ['not_done', 'done'])
        ->update([
            'status' => 'overdue',
        ]);
}
}