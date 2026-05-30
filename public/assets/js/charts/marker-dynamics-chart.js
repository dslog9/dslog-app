(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.querySelector('#markerDynamicsChart');

        if (!el || typeof ApexCharts === 'undefined') return;

        const chartPoints = JSON.parse(el.dataset.points || '[]');
        const chartLines = JSON.parse(el.dataset.lines || '[]');
        const zones = JSON.parse(el.dataset.zones || '[]');

        const scaleMin = Number(el.dataset.scaleMin);
        const scaleMax = Number(el.dataset.scaleMax);
        const markerName = el.dataset.markerName || 'Показатель';

        if (!chartPoints.length) return;

        const isSinglePoint = chartPoints.length === 1;
        const firstTimestamp = Number(chartPoints[0].timestamp);

        let seriesData = chartPoints.map(point => ({
            x: Number(point.timestamp),
            y: Number(point.value),
            status: point.status,
            unit: point.unit
        }));

        if (isSinglePoint && Number.isFinite(firstTimestamp)) {
            seriesData.push({
                x: firstTimestamp + (1000 * 60 * 60 * 24 * 3),
                y: null,
                status: 'future',
                unit: chartPoints[0].unit
            });
        }

        const zoneColors = {
                critical_low: 'rgba(207, 25, 25, 0.1)',
                needs_control_low: 'rgba(117, 28, 28, 0.1)',
                borderline_low: 'rgba(133, 76, 76, 0.08)',

                optimal: 'rgba(143, 232, 65, 0.18)',
                exceptional: 'rgba(112, 156, 207, 0.14)',

                borderline_high: 'rgba(198, 198, 198, 0.1)',
                needs_control_high: 'rgba(176, 176, 176, 0.1)',
                critical_high: 'rgba(199, 199, 199, 0.18)'
        };

/*     
        const zoneColors = {
                critical_low: 'rgba(223, 131, 91, 0.1)',
                needs_control_low: 'rgba(174, 163, 157, 0.1)',
                borderline_low: 'rgba(224, 203, 154, 0.08)',

                optimal: 'rgba(143, 232, 65, 0.18)',
                exceptional: 'rgba(112, 156, 207, 0.14)',

                borderline_high: 'rgba(224, 191, 154, 0.1)',
                needs_control_high: 'rgba(197, 148, 117, 0.1)',
                critical_high: 'rgba(209, 182, 173, 0.18)'
        };

        const zoneColors = {
                critical_low: 'rgba(209, 92, 84, 0.18)',
                needs_control_low: 'rgba(221, 137, 83, 0.15)',
                borderline_low: 'rgba(229, 196, 116, 0.16)',

                optimal: 'rgba(119, 183, 154, 0.18)',
                exceptional: 'rgba(112, 156, 207, 0.14)',

                borderline_high: 'rgba(229, 196, 116, 0.16)',
                needs_control_high: 'rgba(221, 137, 83, 0.15)',
                critical_high: 'rgba(209, 92, 84, 0.18)'
        };
 */

        function percentForValue(value) {
            if (!Number.isFinite(scaleMin) || !Number.isFinite(scaleMax) || scaleMin === scaleMax) {
                return null;
            }

            return 100 - (((value - scaleMin) / (scaleMax - scaleMin)) * 100);
        }

        function buildZoneGradient() {
            if (!zones.length || !Number.isFinite(scaleMin) || !Number.isFinite(scaleMax)) {
                return null;
            }

            const points = [];

            zones.forEach(zone => {
                const from = zone.from === null ? scaleMin : Number(zone.from);
                const to = zone.to === null ? scaleMax : Number(zone.to);

                if (!Number.isFinite(from) || !Number.isFinite(to)) return;

                const lower = Math.max(Math.min(from, to), scaleMin);
                const upper = Math.min(Math.max(from, to), scaleMax);
                const middle = (lower + upper) / 2;
                const percent = percentForValue(middle);

                if (percent === null) return;

                points.push({
                    percent: Math.max(0, Math.min(100, percent)),
                    color: zoneColors[zone.type] || 'rgba(102, 112, 133, 0.06)'
                });
            });

            if (!points.length) return null;

            points.sort((a, b) => a.percent - b.percent);

            return `linear-gradient(to bottom, ${
                points.map(point => `${point.color} ${point.percent.toFixed(2)}%`).join(', ')
            })`;
        }
        const gradient = buildZoneGradient();

        if (gradient) {
            el.style.background = gradient;
            el.style.borderRadius = '18px';
        }

        const lineAnnotations = chartLines.map(line => ({
            y: line.value,
            borderColor: '#565151',
            strokeDashArray: 4,
            label: {
                text: `${line.label}: ${line.value}`,
                style: {
                    fontSize: '11px',
                    color: '#667085',
                    background: '#ffffff'
                }
            }
        }));

        const options = {
            chart: {
                type: 'area',
                height: 320,
                background: 'transparent',
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 600
                }
            },

            colors: ['#331717'],

            series: [{
                name: markerName,
                data: seriesData
            }],

            stroke: {
                show: !isSinglePoint,
                curve: 'monotoneCubic',
                width: 3,
            colors: ['#101828']
            },

            fill: {
                type: 'gradient',
                colors: ['#1f6f96'],
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    shadeIntensity: 0.65,
                    opacityFrom: 0.52,
                    opacityTo: 0.08,
                    stops: [0, 85, 100]
                }
            },

            markers: {
                size: isSinglePoint ? 8 : 7,
                colors: ['#2962df'],
                strokeColors: '#ffffff',
                strokeWidth: 2,
                hover: { size: isSinglePoint ? 11 : 13 }
            },

            xaxis: {
                type: 'datetime',
                labels: {
                    style: {
                        colors: '#667085',
                        fontSize: '12px'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },

            yaxis: {
                min: Number.isFinite(scaleMin) ? scaleMin : undefined,
                max: Number.isFinite(scaleMax) ? scaleMax : undefined,
                labels: {
                    style: {
                        colors: '#667085',
                        fontSize: '12px'
                    }
                }
            },

            grid: {
                borderColor: '#eef2f7',
                strokeDashArray: 4
            },

            tooltip: {
                custom: function ({ dataPointIndex }) {
                    const point = chartPoints[dataPointIndex];
                    if (!point) return '';

                    return `
                        <div class="chart-tooltip">
                            <strong>${point.date}</strong>
                            <div>${point.value} ${point.unit ?? ''}</div>
                            <div>Status: ${point.status}</div>
                        </div>
                    `;
                }
            },

            annotations: {
                yaxis: lineAnnotations
            },

            dataLabels: {
                enabled: false
            }
        };

        const chart = new ApexCharts(el, options);
        chart.render();
    });
})();