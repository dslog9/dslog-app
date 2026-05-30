@extends('layouts.app')

@section('title', $panel->name)

@section('content')

<div class="ds-container">
    <div class="page">

        <h1>{{ $panel->name }}</h1>

        <p class="muted">
            {{ $panel->slug }}
        </p>

        
            <div class="card panel-readiness">
                <h2>Readiness</h2>
            <p>
                @if($panelReadinessStatus === 'complete')
                    <strong>🟢 Complete — {{ $panelReadinessScore }}%</strong>
                @elseif($panelReadinessStatus === 'partial')
                    <strong>🟡 Partial — {{ $panelReadinessScore }}%</strong>
                @else
                    <strong>🔴 Incomplete — {{ $panelReadinessScore }}%</strong>
                @endif
            </p>
            <div class="panel-readiness-grid">

                <div>
                    <strong>{{ $panel->panelMarkers->count() }}</strong>
                    <div class="muted">Markers</div>
                </div>

                <div>
                    <strong>{{ $panel->sections->count() }}</strong>
                    <div class="muted">Sections</div>
                </div>

                <div>
                    <strong>{{ $completeSectionsCount }}</strong>
                    <div class="muted">Complete sections</div>
                </div>

                <div>
                    <strong>{{ $partialSectionsCount }}</strong>
                    <div class="muted">Partial sections</div>
                </div>

                <div>
                    <strong>{{ $incompleteSectionsCount }}</strong>
                    <div class="muted">Incomplete sections</div>
                </div>

                <div>
                    <strong>{{ $panel->faqs->count() }}</strong>
                    <div class="muted">FAQ</div>
                </div>

                <div>
                    <strong>{{ $panel->contentBlocks->count() }}</strong>
                    <div class="muted">Content blocks</div>
                </div>

                <div>
                    <strong>{{ $panel->relatedPanels->count() }}</strong>
                    <div class="muted">Related panels</div>
                </div>

            </div>


        </div>

        <div class="card">

            <h2>Sections</h2>

            <div class="dashboard-grid">

                @forelse($panel->sections as $section)

                <a
                    href="{{ route('internal.panels.sections.show', [$panel, $section]) }}"
                    class="card"
                >
                    <h3>{{ $section->name }}</h3>

                    <p class="muted">
                        {{ $section->slug }}
                    </p>

                    <p>
                        Markers: {{ $section->panelMarkers->count() }}
                    </p>

                    @if($section->frequency_months)
                        <p>
                            Frequency: {{ $section->frequency_months }} months
                        </p>
                    @endif

                    <div class="panel-marker-preview">

                        @foreach($section->panelMarkers->take(3) as $panelMarker)
                            <div>
                                {{ $panelMarker->marker->name }}
                            </div>
                        @endforeach

                        @if($section->panelMarkers->count() > 3)
                            <div>...</div>
                        @endif

                    </div>

                </a>

                @empty

                    <p class="muted">
                        Sections not found.
                    </p>

                @endforelse

            </div>

        </div>
    </div>
</div>

@endsection