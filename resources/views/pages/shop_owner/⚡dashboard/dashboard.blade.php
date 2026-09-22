<div class="min-h-screen ">
    <div class="mx-auto overflow-hidden rounded-lg border border-slate-200 bg-white ">
            <main class=" p-4 sm:p-6">
                <div class="mb-6 flex flex-col gap-4 border-b border-slate-200 bg-white/50 px-2 pb-4 sm:flex-row sm:items-center sm:justify-between">
                
                    <div class="flex items-center gap-3">
                        <button class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700">⎋</button>
                        <button class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700">◌</button>
                        <button class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700">⇩</button>
                    </div>
                </div>

                @if (empty($kpis))
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">
                        No business data is available yet. Complete the business setup to populate dashboard metrics.
                    </div>
                @else
                    <section class="mb-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        @foreach($kpis as $kpi)
                            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                                <div class="mb-2 flex items-center justify-between text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                    <span>{{ $kpi['label'] }}</span>
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-[9px] text-emerald-700">{{ $kpi['delta'] }}</span>
                                </div>
                                <div class="text-3xl font-bold text-slate-900">{{ $kpi['value'] }}</div>
                            </div>
                        @endforeach
                    </section>

                    <section class="mb-6 grid gap-6 xl:grid-cols-[1.5fr_0.9fr]">
                        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="mb-4 flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-slate-900">Inventory movement</h2>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    Activity
                                </div>
                            </div>
                            <canvas id="ownerLineChart" class="h-52 w-full"></canvas>
                        </article>

                        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="mb-4 flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-slate-900">Stock status</h2>
                            </div>
                            <div class="flex flex-col items-center justify-center gap-3">
                                <canvas id="ownerDonutChart" width="190" height="190"></canvas>
                                <div class="w-full space-y-2">
                                    @foreach($donutSeries as $segment)
                                        <div class="flex items-center justify-between text-sm text-slate-600">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-block h-2.5 w-2.5 rounded-full" style="background: {{ $segment['color'] }}"></span>
                                                {{ $segment['label'] }}
                                            </div>
                                            <span class="font-semibold text-slate-800">{{ $segment['value'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                    </section>

                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900">Recent inventory log</h2>
                            <a href="{{ route('owner.inventory') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">View all</a>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                                <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3">Product</th>
                                        <th class="px-4 py-3">Type</th>
                                        <th class="px-4 py-3">Qty</th>
                                        <th class="px-4 py-3">Stock</th>
                                        <th class="px-4 py-3">Updated</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse($tableRows as $row)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-slate-800">{{ $row['product'] }}</td>
                                            <td class="px-4 py-3 text-slate-600">{{ $row['type'] }}</td>
                                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $row['quantity'] }}</td>
                                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $row['stock'] }}</td>
                                            <td class="px-4 py-3 text-slate-500">{{ $row['updated'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">No recent inventory activity yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endif
            </main>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lineCanvas = document.getElementById('ownerLineChart');
        if (lineCanvas) {
            const ctx = lineCanvas.getContext('2d');
            const labels = @json($chartLabels);
            const values = @json($lineSeries);

            if (labels.length && values.length) {
                const w = lineCanvas.width = lineCanvas.clientWidth;
                const h = lineCanvas.height = 220;
                const padding = 22;
                const max = Math.max(...values, 1);
                const min = 0;

                ctx.clearRect(0, 0, w, h);
                ctx.strokeStyle = '#dfe7e7';
                ctx.lineWidth = 1;
                for (let i = 0; i <= 4; i++) {
                    const y = padding + ((h - padding * 2) / 4) * i;
                    ctx.beginPath();
                    ctx.moveTo(padding, y);
                    ctx.lineTo(w - padding, y);
                    ctx.stroke();
                }

                const points = values.map((value, index) => {
                    const x = padding + ((w - padding * 2) / Math.max(values.length - 1, 1)) * index;
                    const y = h - padding - ((value - min) / Math.max(max - min, 1)) * (h - padding * 2);
                    return { x, y, value };
                });

                const gradient = ctx.createLinearGradient(0, 0, 0, h);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0.02)');

                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);
                points.slice(1).forEach((point) => ctx.lineTo(point.x, point.y));
                ctx.lineWidth = 3;
                ctx.strokeStyle = '#10b981';
                ctx.stroke();

                ctx.lineTo(points[points.length - 1].x, h - padding);
                ctx.lineTo(points[0].x, h - padding);
                ctx.closePath();
                ctx.fillStyle = gradient;
                ctx.fill();

                points.forEach((point) => {
                    ctx.beginPath();
                    ctx.arc(point.x, point.y, 4, 0, Math.PI * 2);
                    ctx.fillStyle = '#10b981';
                    ctx.fill();
                });

                labels.forEach((label, index) => {
                    const x = padding + ((w - padding * 2) / Math.max(labels.length - 1, 1)) * index;
                    ctx.fillStyle = '#64748b';
                    ctx.font = '11px sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(label, x, h - 8);
                });
            }
        }

        const donutCanvas = document.getElementById('ownerDonutChart');
        if (donutCanvas) {
            const ctx = donutCanvas.getContext('2d');
            const data = @json($donutSeries);
            const total = data.reduce((sum, item) => sum + Number(item.value || 0), 0) || 1;
            const centerX = donutCanvas.width / 2;
            const centerY = donutCanvas.height / 2;
            const radius = 62;
            let currentAngle = -Math.PI / 2;

            data.forEach((item) => {
                const slice = (Number(item.value || 0) / total) * Math.PI * 2;
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + slice);
                ctx.closePath();
                ctx.fillStyle = item.color;
                ctx.fill();
                currentAngle += slice;
            });

            ctx.beginPath();
            ctx.arc(centerX, centerY, 36, 0, Math.PI * 2);
            ctx.fillStyle = '#ffffff';
            ctx.fill();

            ctx.fillStyle = '#0f172a';
            ctx.textAlign = 'center';
            ctx.font = '700 18px sans-serif';
            ctx.fillText(String(total), centerX, centerY + 6);
        }
    });
</script>