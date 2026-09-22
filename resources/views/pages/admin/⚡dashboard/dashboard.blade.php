
@php
    $toneClasses = [
        'orange' => 'border-orange-200 bg-orange-50',
        'green' => 'border-emerald-200 bg-emerald-50',
        'amber' => 'border-amber-200 bg-amber-50',
        'red' => 'border-red-200 bg-red-50',
    ];

    $statusClasses = [
        'verified' => 'bg-emerald-100 text-emerald-700',
        'pending' => 'bg-amber-100 text-amber-700',
        'rejected' => 'bg-red-100 text-red-700',
    ];
@endphp

<div class="min-h-screen bg-white text-slate-900 lg:rounded-lg">
    <div class="mx-auto px-2 py-2 sm:px-2 lg:px-6">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Platform overview</p>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Super Admin Dashboard</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.profile') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                    Profile
                </a>
                <a href="{{ route('admin.update_profile') }}" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-orange-500 to-orange-400 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-orange-200 transition hover:from-orange-600 hover:to-orange-500">
                    Update profile
                </a>
            </div>
        </div>

        <section class="mb-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($kpis as $kpi)
                <article class="rounded-2xl border {{ $toneClasses[$kpi['tone']] ?? 'border-slate-200 bg-white' }} p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between text-xs font-medium text-slate-600">
                        <span>{{ $kpi['label'] }}</span>
                        <strong class="font-semibold text-slate-700">{{ $kpi['delta'] }}</strong>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">{{ $kpi['value'] }}</h2>
                </article>
            @endforeach
        </section>

        <section class="mb-8 grid gap-6 xl:grid-cols-[1.5fr_1fr]">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Growth</p>
                        <h3 class="text-xl font-semibold text-slate-900">Tenant growth</h3>
                    </div>
                </div>
                <div class="relative h-56 w-full">
                    <canvas id="tenantLineChart" class="h-full w-full" role="img" aria-label="Tenant registrations over the last seven months"></canvas>
                </div>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Snapshot</p>
                        <h3 class="text-xl font-semibold text-slate-900">Verification mix</h3>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-center gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <canvas id="tenantDonutChart" width="220" height="220" class="block"></canvas>

                    <div class="w-full max-w-[200px] space-y-3">
                        @foreach($donutSeries as $item)
                            <div class="grid grid-cols-[10px_1fr_auto] items-center gap-2 text-sm text-slate-600">
                                <span class="inline-block h-2.5 w-2.5 rounded-full {{ $item['swatch'] }}"></span>
                                <span>{{ $item['label'] }}</span>
                                <strong class="font-semibold text-slate-800">{{ $item['value'] }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Tenants</p>
                        <h3 class="text-xl font-semibold text-slate-900">Registered shops</h3>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">{{ count($tenantRows) }} listed</span>
                </div>

                <div class="space-y-3">
                    @forelse($tenantRows as $tenant)
                        <div class="grid grid-cols-1 gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 sm:grid-cols-[1.4fr_auto_auto] sm:items-center">
                            <div class="flex flex-col gap-1">
                                <strong class="font-semibold text-slate-900">{{ $tenant['name'] }}</strong>
                                <small class="text-sm text-slate-500">{{ $tenant['owner'] }}</small>
                            </div>
                            <span class="inline-flex items-center justify-center rounded-full px-2.5 py-1 text-xs font-bold {{ $statusClasses[strtolower(str_replace(' ', '-', $tenant['status']))] ?? 'bg-slate-200 text-slate-700' }}">
                                {{ $tenant['status'] }}
                            </span>
                            <span class="text-sm text-slate-500">{{ $tenant['created'] }}</span>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                            No tenants have registered yet.
                        </div>
                    @endforelse
                </div>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-5">
                    <p class="mb-1 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Feedback</p>
                    <h3 class="text-xl font-semibold text-slate-900">Tenant reviews</h3>
                </div>

                @if($reviewSummary['has_reviews'])
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center">
                        <div class="text-4xl font-bold text-slate-900">{{ $reviewSummary['average_rating'] }}</div>
                        <small class="mt-2 block text-sm text-slate-500">{{ $reviewSummary['count'] }} reviews</small>
                    </div>
                @else
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                        <div class="mb-3 inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-slate-600">
                            No reviews yet
                        </div>
                        <p class="text-sm leading-6 text-slate-600">{{ $reviewSummary['message'] }}</p>
                    </div>
                @endif
            </article>
        </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lineCanvas = document.getElementById('tenantLineChart');
        if (lineCanvas) {
            const labels = @json($chartLabels);
            const values = @json($lineSeries).map(Number);

            const drawLineChart = () => {
                const context = lineCanvas.getContext('2d');
                const bounds = lineCanvas.getBoundingClientRect();
                const width = Math.max(Math.floor(bounds.width), 1);
                const height = Math.max(Math.floor(bounds.height), 1);
                const pixelRatio = window.devicePixelRatio || 1;

                lineCanvas.width = width * pixelRatio;
                lineCanvas.height = height * pixelRatio;
                context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
                context.clearRect(0, 0, width, height);

                const padding = { top: 16, right: 18, bottom: 32, left: 32 };
                const plotWidth = width - padding.left - padding.right;
                const plotHeight = height - padding.top - padding.bottom;
                const maxValue = Math.max(...values, 1);
                const chartMax = Math.ceil(maxValue / 5) * 5 || 5;
                const points = values.map((value, index) => ({
                    x: padding.left + (plotWidth / Math.max(values.length - 1, 1)) * index,
                    y: padding.top + plotHeight - (value / chartMax) * plotHeight,
                    value,
                }));

                context.font = '12px sans-serif';
                context.textAlign = 'right';
                context.textBaseline = 'middle';
                for (let index = 0; index <= 4; index++) {
                    const y = padding.top + (plotHeight / 4) * index;
                    const value = Math.round(chartMax - (chartMax / 4) * index);
                    context.beginPath();
                    context.moveTo(padding.left, y);
                    context.lineTo(width - padding.right, y);
                    context.strokeStyle = '#e2e8f0';
                    context.lineWidth = 1;
                    context.stroke();
                    context.fillStyle = '#94a3b8';
                    context.fillText(String(value), padding.left - 8, y);
                }

                if (points.length) {
                    const gradient = context.createLinearGradient(0, padding.top, 0, padding.top + plotHeight);
                    gradient.addColorStop(0, 'rgba(249, 115, 22, 0.30)');
                    gradient.addColorStop(1, 'rgba(249, 115, 22, 0.01)');

                    context.beginPath();
                    context.moveTo(points[0].x, points[0].y);
                    points.slice(1).forEach((point) => context.lineTo(point.x, point.y));
                    context.lineTo(points[points.length - 1].x, padding.top + plotHeight);
                    context.lineTo(points[0].x, padding.top + plotHeight);
                    context.closePath();
                    context.fillStyle = gradient;
                    context.fill();

                    context.beginPath();
                    context.moveTo(points[0].x, points[0].y);
                    points.slice(1).forEach((point) => context.lineTo(point.x, point.y));
                    context.strokeStyle = '#f97316';
                    context.lineWidth = 3;
                    context.lineJoin = 'round';
                    context.lineCap = 'round';
                    context.stroke();

                    points.forEach((point) => {
                        context.beginPath();
                        context.arc(point.x, point.y, 4, 0, Math.PI * 2);
                        context.fillStyle = '#ffffff';
                        context.fill();
                        context.strokeStyle = '#f97316';
                        context.lineWidth = 2;
                        context.stroke();
                    });
                }

                context.textAlign = 'center';
                context.textBaseline = 'alphabetic';
                labels.forEach((label, index) => {
                    const x = padding.left + (plotWidth / Math.max(labels.length - 1, 1)) * index;
                    context.fillStyle = '#64748b';
                    context.fillText(label, x, height - 8);
                });
            };

            drawLineChart();
            new ResizeObserver(drawLineChart).observe(lineCanvas);
        }

        const donutCanvas = document.getElementById('tenantDonutChart');
        if (donutCanvas) {
            const ctx = donutCanvas.getContext('2d');
            const data = @json($donutSeries);
            const total = data.reduce((sum, item) => sum + Number(item.value || 0), 0) || 1;
            const centerX = donutCanvas.width / 2;
            const centerY = donutCanvas.height / 2;
            const radius = 70;
            let currentAngle = -Math.PI / 2;

            data.forEach((item) => {
                const value = Number(item.value || 0);
                const slice = (value / total) * Math.PI * 2;
                const endAngle = currentAngle + slice;

                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, currentAngle, endAngle);
                ctx.closePath();
                ctx.fillStyle = item.color;
                ctx.fill();

                currentAngle = endAngle;
            });

            ctx.beginPath();
            ctx.arc(centerX, centerY, 42, 0, Math.PI * 2);
            ctx.fillStyle = '#ffffff';
            ctx.fill();

            ctx.fillStyle = '#0f172a';
            ctx.textAlign = 'center';
            ctx.font = '700 24px sans-serif';
            ctx.fillText(String(total), centerX, centerY - 4);
            ctx.font = '12px sans-serif';
            ctx.fillStyle = '#64748b';
            ctx.fillText('tenants', centerX, centerY + 16);
        }
    });
</script>
