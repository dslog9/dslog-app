@extends('layouts.app')

@section('title', $section->name . ' — Panel Studio')

@section('content')

<div class="ds-container">
    <div class="page">

        <p>
            <a href="{{ route('internal.panels.show', $panel) }}">
                ← Back to panel
            </a>
        </p>

        <h1>{{ $section->name }}</h1>

        <p class="muted">
            {{ $panel->name }} · {{ $section->slug }}
        </p>

        @if($section->description)
            <p>
                {{ $section->description }}
            </p>
        @endif

        <div class="card">

            <h2>Section readiness</h2>
            <p>
                @if($sectionStatus === 'complete')
                    <strong>🟢 Complete — {{ $sectionReadinessScore }}%</strong>
                @elseif($sectionStatus === 'partial')
                    <strong>🟡 Partial — {{ $sectionReadinessScore }}%</strong>
                @else
                    <strong>🔴 Incomplete — {{ $sectionReadinessScore }}%</strong>
                @endif
            </p>
            
            <div class="panel-readiness-grid">

                <div>
                    <strong>{{ $section->panelMarkers->count() }}</strong>
                    <div class="muted">Markers</div>
                </div>

                <div>
                    <strong>{{ $requiredMarkersCount }}</strong>
                    <div class="muted">Required</div>
                </div>

                <div>
                    <strong>{{ $missingPriorityCount }}</strong>
                    <div class="muted">Missing priority</div>
                </div>

                <div>
                    <strong>{{ $missingFrequencyCount }}</strong>
                    <div class="muted">Missing frequency</div>
                </div>

                <div>
                    <strong>{{ $missingReasonCount }}</strong>
                    <div class="muted">Missing reason</div>
                </div>

            </div>

        </div>
        

        <div class="card">

            <h2>Markers</h2>

            <div class="table-responsive">
                <table class="internal-table">
                    <thead>
                        <tr>
                            <th>Marker</th>
                            <th>Priority</th>
                            <th>Frequency</th>
                            <th>Required</th>
                            <th>Reason</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($section->panelMarkers as $panelMarker)
                            <tr>
                                <td>
                                    <strong>{{ $panelMarker->marker?->name ?? 'Missing marker' }}</strong>

                                    <div class="muted small">
                                        {{ $panelMarker->marker?->slug ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $panelMarker->priority ?? '—' }}
                                </td>

                                <td>
                                    @if($panelMarker->frequency_months)
                                        {{ $panelMarker->frequency_months }} months
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    {{ $panelMarker->is_required ? 'yes' : 'no' }}
                                </td>

                                <td>
                                    {{ $panelMarker->reason ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    Markers not found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

@endsection