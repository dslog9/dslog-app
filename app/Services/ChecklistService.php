<?php

namespace App\Services;

use App\Models\TestPanel;
use App\Models\UserChecklist;
use App\Models\UserChecklistItem;
use App\Models\UserProfile;
use Illuminate\Support\Carbon;

class ChecklistService
{
    public function createFromPanel(TestPanel $panel, ?int $userId = null): UserChecklist
    {
        $profile = $userId
            ? UserProfile::where('user_id', $userId)->first()
            : null;

        $age = $profile?->birth_year
            ? now()->year - $profile->birth_year
            : null;

        $gender = $profile?->gender;

        $checklist = UserChecklist::create([
            'user_id' => $userId,
            'test_panel_id' => $panel->id,
            'status' => 'active',
            'assigned_at' => now(),
        ]);

        $panel->markers()
            ->orderBy('priority')
            ->each(function ($panelMarker) use ($checklist, $age, $gender) {
                if (!$this->panelMarkerMatchesProfile($panelMarker, $age, $gender)) {
                    return;
                }

                UserChecklistItem::create([
                    'user_checklist_id' => $checklist->id,
                    'marker_id' => $panelMarker->marker_id,
                    'frequency_months' => $panelMarker->frequency_months,
                    'status' => 'not_done',
                    'next_due_at' => $panelMarker->frequency_months
                        ? Carbon::now()->addMonths($panelMarker->frequency_months)
                        : null,
                    'note' => $panelMarker->reason ?: $panelMarker->note,
                ]);
            });

        return $checklist->load('items.marker');
    }

    private function panelMarkerMatchesProfile($panelMarker, ?int $age, ?string $gender): bool
    {
        if ($panelMarker->age_min !== null && $age !== null && $age < $panelMarker->age_min) {
            return false;
        }

        if ($panelMarker->age_max !== null && $age !== null && $age > $panelMarker->age_max) {
            return false;
        }

        if ($panelMarker->gender !== null && $gender !== null && $panelMarker->gender !== $gender) {
            return false;
        }

        return true;
    }
}