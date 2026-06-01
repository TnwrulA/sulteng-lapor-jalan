<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-900 leading-tight flex items-center gap-2">
            <i data-lucide="layout-dashboard" class="h-6 w-6 text-[#ff5e00]"></i>
            Dashboard Pelapor
        </h2>
    </x-slot>

    @php
        $userReports = Auth::user()->roadReports;
        $mapReports = $userReports->filter(fn($r) => $r->getCoordinates() !== null)->values();
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Banner -->
            <div class="glass-card overflow-hidden relative shadow-sm border border-gray-100">
                <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-[#ff5e00]/5 to-transparent pointer-events-none"></div>
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between relative z-10">
                        <div>
                            <span class="inline-flex items-center rounded-full bg-[#ff5e00]/10 border border-[#ff5e00]/20 px-3 py-1 text-xs font-bold text-[#ff5e00] mb-3">
                                Akun Warga Terverifikasi
                            </span>
                            <p class="text-2xl font-black text-gray-900 tracking-tight">Selamat Datang Kembali, {{ Auth::user()->name }}!</p>
                            <p class="mt-1.5 text-sm text-gray-500 leading-relaxed max-w-xl">Laporkan kerusakan jalan di lingkungan Anda secara langsung. Setiap laporan yang Anda kirimkan sangat berharga untuk perbaikan infrastruktur Sulawesi Tengah.</p>
                        </div>
                        <a href="{{ route('reports.create') }}" class="premium-btn-primary shrink-0 self-start sm:self-center">
                            <i data-lucide="plus-circle" class="me-2 h-5 w-5"></i>
                            Buat Laporan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
                <!-- Total Laporan -->
                <div class="glass-card p-5 shadow-sm glow-card-total flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Laporan</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-50 text-gray-500 shadow-sm border border-gray-200/50">
                        <i data-lucide="clipboard-list" class="h-6 w-6"></i>
                    </div>
                </div>

                <!-- Menunggu Verifikasi -->
                <div class="glass-card p-5 shadow-sm glow-card-menunggu flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['menunggu'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-[#ff5e00] shadow-sm border border-[#ff5e00]/10">
                        <i data-lucide="clock" class="h-6 w-6"></i>
                    </div>
                </div>

                <!-- Diverifikasi -->
                <div class="glass-card p-5 shadow-sm glow-card-diverifikasi flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Diverifikasi</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['diverifikasi'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#ff5e00]/10 text-[#ff5e00] shadow-sm border border-[#ff5e00]/20">
                        <i data-lucide="shield-check" class="h-6 w-6"></i>
                    </div>
                </div>

                <!-- Diproses -->
                <div class="glass-card p-5 shadow-sm glow-card-diproses flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Diproses</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['diproses'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50/50 text-[#ff5e00] shadow-sm border border-orange-200/20">
                        <i data-lucide="hammer" class="h-6 w-6"></i>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="glass-card p-5 shadow-sm glow-card-selesai flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Selesai</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['selesai'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 shadow-sm border border-green-200/40">
                        <i data-lucide="check-circle" class="h-6 w-6"></i>
                    </div>
                </div>
            </div>

            <!-- Two Column Main Grid -->
            <div class="grid gap-6 lg:grid-cols-5">
                <!-- Map Left Column (all user reports) -->
                <div class="lg:col-span-3 flex flex-col space-y-4">
                    <div class="glass-card p-5 shadow-sm flex flex-col justify-between flex-grow">
                        <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                            <div>
                                <h3 class="font-extrabold text-base text-gray-900 flex items-center gap-2">
                                    <i data-lucide="map" class="h-5 w-5 text-[#ff5e00]"></i>
                                    Sebaran Laporanku
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">Pemetaan seluruh laporan jalan rusak yang telah Anda kirimkan.</p>
                            </div>
                            <span class="text-[10px] font-extrabold bg-[#eef2e7] text-gray-600 px-2.5 py-1 rounded-md">{{ count($mapReports) }} Titik Laporan</span>
                        </div>

                        <!-- User Map Selection Container -->
                        <div class="rounded-xl overflow-hidden border border-gray-200 h-[360px] relative shadow-inner">
                            <div id="user-reports-map" class="h-full w-full z-10"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports Right Column -->
                <div class="lg:col-span-2 flex flex-col space-y-4">
                    <div class="glass-card shadow-sm overflow-hidden flex flex-col h-full">
                        <div class="border-b border-gray-100 px-6 py-4 bg-white/40 flex items-center justify-between">
                            <h3 class="font-extrabold text-gray-900 flex items-center gap-2 text-sm">
                                <i data-lucide="list-todo" class="h-5 w-5 text-[#ff5e00]"></i>
                                Laporan Terbaruku
                            </h3>
                            <a href="{{ route('reports.index') }}" class="link-accent text-xs flex items-center font-bold">
                                Riwayat
                                <i data-lucide="arrow-right" class="ms-0.5 h-3.5 w-3.5 text-[#ff5e00]"></i>
                            </a>
                        </div>

                        <div class="p-5 flex-1 divide-y divide-gray-100 space-y-3.5 overflow-y-auto max-h-[380px]">
                            @forelse ($recentReports as $report)
                                <div class="pt-3.5 first:pt-0 group flex items-start justify-between gap-4">
                                    <div class="space-y-1">
                                        <a href="{{ route('reports.show', $report) }}" class="font-extrabold text-sm text-gray-900 group-hover:text-[#ff5e00] transition duration-200 line-clamp-1">
                                            {{ $report->title }}
                                        </a>
                                        <div class="flex items-center text-xs text-gray-400 font-medium">
                                            <i data-lucide="map-pin" class="me-1 h-3.5 w-3.5 text-[#ff5e00]/70"></i>
                                            {{ $report->region }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-medium">
                                            {{ $report->created_at->format('d M Y') }}
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end gap-1.5 shrink-0">
                                        <span class="inline-block rounded-full border px-2.5 py-0.5 text-[10px] font-extrabold tracking-wide uppercase shadow-sm {{ $report->statusBadgeClass() }}">
                                            {{ $report->status }}
                                        </span>
                                        <a href="{{ route('reports.show', $report) }}" class="inline-flex items-center text-xs font-bold text-[#ff5e00] opacity-0 group-hover:opacity-100 transition duration-300">
                                            Detail &rarr;
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-14 text-center text-gray-400">
                                    <div class="h-12 w-12 items-center justify-center rounded-full bg-gray-50 flex mb-3 shadow-inner">
                                        <i data-lucide="clipboard-warning" class="h-6 w-6 text-gray-300"></i>
                                    </div>
                                    <span class="text-xs font-bold">Belum ada laporan kerusakan.</span>
                                    <a href="{{ route('reports.create') }}" class="mt-3.5 premium-btn-primary px-4 py-2 text-xs">
                                        Kirim Laporan Pertama
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet preview initialization script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Default center: Palu, Central Sulawesi
            const defaultLat = -0.8917;
            const defaultLng = 119.8707;

            const map = L.map('user-reports-map', {
                scrollWheelZoom: false
            }).setView([defaultLat, defaultLng], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Parse User reports
            const userReports = <?php echo json_encode($mapReports->map(function($r) {
                return [
                    'id' => $r->id,
                    'title' => $r->title,
                    'location' => $r->location,
                    'status' => $r->status,
                    'damage_level' => $r->damage_level,
                    'coords' => $r->getCoordinates(),
                    'photo' => asset('storage/' . $r->photo),
                    'created_at' => $r->created_at->format('d M Y')
                ];
            })->toArray()); ?>;

            const bounds = [];

            userReports.forEach(report => {
                if (report.coords && report.coords.lat && report.coords.lng) {
                    const lat = parseFloat(report.coords.lat);
                    const lng = parseFloat(report.coords.lng);
                    bounds.push([lat, lng]);

                    let badgeColor = '';
                    if (report.status === 'Selesai') badgeColor = 'bg-green-100 text-green-900 border-green-200';
                    else if (report.status === 'Ditolak') badgeColor = 'bg-red-100 text-red-900 border-red-200';
                    else if (report.status === 'Diproses') badgeColor = 'bg-orange-100 text-orange-900 border-orange-200';
                    else if (report.status === 'Diverifikasi') badgeColor = 'bg-amber-100 text-amber-900 border-amber-200';
                    else badgeColor = 'bg-stone-100 text-stone-900 border-stone-200';

                    const popupContent = `
                        <div class="w-60 overflow-hidden rounded-xl bg-white shadow-lg border border-gray-100">
                            <img src="${report.photo}" class="h-28 w-full object-cover" alt="${report.title}" />
                            <div class="p-3">
                                <span class="inline-block rounded-full border px-2 py-0.5 text-[9px] font-bold ${badgeColor}">${report.status}</span>
                                <h4 class="mt-1.5 text-xs font-bold text-gray-900 line-clamp-1">${report.title}</h4>
                                <p class="mt-1 text-[10px] text-gray-500 flex items-center">
                                    <i data-lucide="map-pin" class="mr-1 h-3 w-3 text-[#ff5e00]"></i> ${report.location}
                                </p>
                                <div class="mt-2.5 flex items-center justify-between border-t border-gray-100 pt-2 text-[9px] text-gray-400 font-semibold">
                                    <span>${report.created_at}</span>
                                    <a href="/reports/${report.id}" class="text-[#ff5e00] hover:underline">Detail</a>
                                </div>
                            </div>
                        </div>
                    `;

                    const marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(popupContent);
                }
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [45, 45] });
            }

            map.on('popupopen', function () {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        });
    </script>
</x-app-layout>
