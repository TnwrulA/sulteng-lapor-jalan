<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sulteng Lapor Jalan - Portal Pelaporan Jalan Rusak</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <!-- Tailwind CSS & JS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Leaflet Map JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <!-- Lucide Icons JS -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="font-sans text-[#1a1e1b] antialiased bg-[#fafafa] app-surface">
        <div class="min-h-screen">
            <!-- Navbar -->
            <nav class="sticky top-0 z-50 border-b border-white/40 bg-white/70 backdrop-blur-md shadow-sm transition-all duration-300">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#ff5e00] to-[#ff8533] text-white shadow-md shadow-[#ff5e00]/15 transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
                            <x-application-logo class="h-6 w-6" />
                        </span>
                        <span class="font-extrabold text-[#1a1e1b] tracking-wide transition-all duration-300 group-hover:text-[#ff5e00]">Sulteng Lapor Jalan</span>
                    </a>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-3 text-sm font-bold">
                            @auth
                                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="premium-btn-muted">
                                    <i data-lucide="layout-dashboard" class="me-2 h-4 w-4 text-[#ff5e00]"></i>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-xl px-4 py-2.5 text-gray-600 hover:bg-gray-100 hover:text-[#1a1e1b] transition duration-300 font-bold">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="premium-btn-primary">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <!-- Hero Section -->
            <section class="relative min-h-[80vh] overflow-hidden bg-[#121614] text-white flex items-center">
                <!-- Glowing effect shapes in background -->
                <div class="absolute top-1/4 left-1/4 -translate-x-1/2 -translate-y-1/2 w-80 h-80 rounded-full bg-[#ff5e00] opacity-[0.08] blur-3xl"></div>
                <div class="absolute bottom-1/4 right-1/4 translate-x-1/2 translate-y-1/2 w-96 h-96 rounded-full bg-[#ff5e00] opacity-[0.05] blur-3xl"></div>

                <img src="{{ asset('images/road-report-hero.png') }}" alt="Warga mendokumentasikan jalan rusak" class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-20 transition duration-1000 hover:scale-105">
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#121614]/95 via-[#121614]/85 to-transparent"></div>
                
                <div class="relative z-20 mx-auto max-w-7xl w-full px-6 py-24 lg:px-8">
                    <div class="grid gap-12 lg:grid-cols-12 items-center">
                        <div class="lg:col-span-7">
                            <span class="mb-5 inline-flex items-center rounded-full border border-[#ff5e00]/30 bg-[#ff5e00]/10 px-4 py-1.5 text-xs font-extrabold text-[#ff8533] shadow-sm tracking-wide">
                                <i data-lucide="shield-check" class="me-1.5 h-4 w-4"></i>
                                SMART CITY & MOBILITY SULAWESI TENGAH
                            </span>
                            <h1 class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl mt-4">
                                Laporkan Jalan Rusak,<br>
                                <span class="bg-gradient-to-r from-[#ff5e00] to-[#ff8533] bg-clip-text text-transparent">Bangun Daerah Kita.</span>
                            </h1>
                            <p class="mt-6 max-w-lg text-base sm:text-lg leading-relaxed text-gray-300">
                                Sampaikan laporan kerusakan infrastruktur jalan di wilayah Sulawesi Tengah secara cepat, transparan, dan terstruktur. Pantau langsung penanganan laporan hingga tuntas.
                            </p>

                            <div class="mt-10 flex flex-wrap gap-4">
                                @auth
                                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('reports.create') }}" class="premium-btn-primary px-8 py-4 text-base">
                                        <i data-lucide="plus-circle" class="me-2.5 h-5 w-5"></i>
                                        Buat Laporan Baru
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="premium-btn-primary px-8 py-4 text-base">
                                        <i data-lucide="send" class="me-2.5 h-5 w-5"></i>
                                        Laporkan Kerusakan
                                    </a>
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-8 py-4 text-base font-bold text-white hover:bg-white/10 hover:border-white/30 backdrop-blur-md transition-all duration-300 active:scale-95">
                                        <i data-lucide="log-in" class="me-2.5 h-5 w-5"></i>
                                        Masuk Akun Pelapor
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Mini Stats Grid in Hero -->
                        <div class="lg:col-span-5 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-white/20 hover:scale-[1.03] shadow-md">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#ff5e00]/15 text-[#ff8533] mb-4">
                                    <i data-lucide="clipboard-list" class="h-6 w-6"></i>
                                </div>
                                <p class="text-3xl font-extrabold text-white tracking-tight">{{ \App\Models\RoadReport::count() }}</p>
                                <p class="mt-1.5 text-xs font-bold uppercase tracking-wider text-gray-400">Total Laporan</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-white/20 hover:scale-[1.03] shadow-md">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-500/15 text-orange-400 mb-4">
                                    <i data-lucide="activity" class="h-6 w-6"></i>
                                </div>
                                <p class="text-3xl font-extrabold text-white tracking-tight">{{ \App\Models\RoadReport::where('status', 'Diproses')->count() }}</p>
                                <p class="mt-1.5 text-xs font-bold uppercase tracking-wider text-gray-400">Sedang Diproses</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-white/20 hover:scale-[1.03] shadow-md">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-500/15 text-green-400 mb-4">
                                    <i data-lucide="check-circle-2" class="h-6 w-6"></i>
                                </div>
                                <p class="text-3xl font-extrabold text-white tracking-tight">{{ \App\Models\RoadReport::where('status', 'Selesai')->count() }}</p>
                                <p class="mt-1.5 text-xs font-bold uppercase tracking-wider text-gray-400">Selesai Diperbaiki</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-white/20 hover:scale-[1.03] shadow-md">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/15 text-blue-400 mb-4">
                                    <i data-lucide="map" class="h-6 w-6"></i>
                                </div>
                                <p class="text-3xl font-extrabold text-white tracking-tight">{{ count(\App\Models\RoadReport::REGIONS) }}</p>
                                <p class="mt-1.5 text-xs font-bold uppercase tracking-wider text-gray-400">Wilayah Cakupan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Map & Highlights Grid -->
            <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Peta Sebaran Laporan Jalan Rusak</h2>
                    <p class="mt-4 text-sm sm:text-base text-gray-600 leading-relaxed">Peta interaktif di bawah menampilkan lokasi titik kerusakan jalan yang telah dilaporkan oleh warga Sulawesi Tengah.</p>
                </div>

                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Map Container -->
                    <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-2.5 shadow-sm h-[500px] relative overflow-hidden group">
                        <div id="map" class="h-full w-full rounded-xl z-10"></div>
                    </div>

                    <!-- Recent Reports Slider Sidebar -->
                    <div class="flex flex-col justify-between h-[500px]">
                        <div class="h-full flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-extrabold text-gray-900 flex items-center">
                                    <i data-lucide="sparkles" class="me-2 h-5 w-5 text-[#ff5e00] fill-[#ff5e00]/10 animate-pulse"></i>
                                    Laporan Terbaru
                                </h3>
                                <span class="rounded-full bg-[#ff5e00]/10 border border-[#ff5e00]/20 px-3 py-1 text-xs font-bold text-[#ff5e00] shadow-sm">Terverifikasi</span>
                            </div>

                            <!-- Carousel Container -->
                            <div x-data="{ activeSlide: 0, slidesCount: {{ count($recentReports) }} }" class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white/80 p-6 backdrop-blur-md shadow-sm h-[435px] flex flex-col justify-between">
                                <!-- Slides -->
                                <div class="relative flex-1 overflow-hidden">
                                    @forelse($recentReports as $index => $report)
                                        <div x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="absolute inset-0 flex flex-col h-full">
                                            <div class="relative rounded-xl overflow-hidden border border-gray-100 shadow-sm h-48 w-full group">
                                                <img src="{{ asset('storage/' . $report->photo) }}" alt="{{ $report->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                                <span class="absolute top-3 left-3 rounded-full border px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider bg-white/90 backdrop-blur-md {{ $report->statusBadgeClass() }} shadow-sm">{{ $report->status }}</span>
                                            </div>
                                            
                                            <div class="mt-4 flex-1 flex flex-col justify-between">
                                                <div>
                                                    <div class="flex items-center justify-between text-xs text-gray-400 font-medium">
                                                        <span class="flex items-center font-bold text-gray-700 bg-gray-100/80 px-2 py-0.5 rounded">Level: {{ $report->damage_level }}</span>
                                                        <span>{{ $report->created_at->format('d M Y') }}</span>
                                                    </div>
                                                    <h4 class="mt-3 text-base font-extrabold text-gray-900 line-clamp-1 hover:text-[#ff5e00] transition duration-200">{{ $report->title }}</h4>
                                                    <p class="mt-1 text-xs sm:text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $report->description ?: 'Tidak ada keterangan tambahan.' }}</p>
                                                </div>

                                                <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3 text-xs">
                                                    <span class="text-[#4a5246] flex items-center font-semibold bg-[#eef2e7]/85 px-2.5 py-1 rounded-md">
                                                        <i data-lucide="map-pin" class="me-1 h-3.5 w-3.5 text-[#ff5e00]"></i> {{ $report->region }}
                                                    </span>
                                                    @auth
                                                        <a href="{{ Auth::user()->isAdmin() ? route('admin.reports.show', $report) : route('reports.show', $report) }}" class="link-accent inline-flex items-center font-extrabold text-xs">
                                                            Detail &rarr;
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                            <div class="h-16 w-16 items-center justify-center rounded-full bg-gray-50 flex mb-3 shadow-inner">
                                                <i data-lucide="folder-open" class="h-8 w-8 text-gray-300"></i>
                                            </div>
                                            <span class="text-sm font-semibold">Belum ada laporan kerusakan.</span>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Controls -->
                                @if(count($recentReports) > 1)
                                    <div class="flex justify-end gap-2 mt-3 border-t border-gray-100 pt-4">
                                        <button @click="activeSlide = (activeSlide - 1 + slidesCount) % slidesCount" class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-700 transition hover:bg-gray-100 hover:text-[#ff5e00] hover:border-[#ff5e00]/40 cursor-pointer shadow-sm active:scale-90">
                                            <i data-lucide="chevron-left" class="h-4.5 w-4.5"></i>
                                        </button>
                                        <button @click="activeSlide = (activeSlide + 1) % slidesCount" class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-700 transition hover:bg-gray-100 hover:text-[#ff5e00] hover:border-[#ff5e00]/40 cursor-pointer shadow-sm active:scale-90">
                                            <i data-lucide="chevron-right" class="h-4.5 w-4.5"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- How it works (Workflow) -->
            <section class="border-y border-gray-200/50 bg-white/40 px-6 py-20 lg:px-8 backdrop-blur-sm">
                <div class="mx-auto max-w-7xl">
                    <div class="text-center max-w-2xl mx-auto mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Alur Pelaporan Laporan Jalan</h2>
                        <p class="mt-4 text-sm sm:text-base text-gray-600">Bagaimana laporan Anda diproses dari awal hingga tuntas diperbaiki.</p>
                    </div>

                    <div class="grid gap-8 md:grid-cols-3">
                        <div class="glass-card p-8 shadow-sm hover:scale-[1.02] hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-[#ff5e00]/10 to-transparent rounded-bl-full transition-all duration-500 group-hover:scale-110"></div>
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff5e00]/15 text-[#ff5e00] font-black text-lg shadow-inner">01</span>
                            <h3 class="mt-6 text-lg font-extrabold text-gray-900">1. Kirim Laporan & Bukti</h3>
                            <p class="mt-3 text-sm leading-relaxed text-[#5c6358]">
                                Masyarakat mendaftar dan masuk akun, lalu mengisi formulir laporan dengan judul, detail lokasi, tingkat kerusakan, foto bukti lapangan, serta menyematkan titik koordinat maps.
                            </p>
                        </div>
                        <div class="glass-card p-8 shadow-sm hover:scale-[1.02] hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-[#ff5e00]/10 to-transparent rounded-bl-full transition-all duration-500 group-hover:scale-110"></div>
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff5e00]/15 text-[#ff5e00] font-black text-lg shadow-inner">02</span>
                            <h3 class="mt-6 text-lg font-extrabold text-gray-900">2. Verifikasi oleh Admin</h3>
                            <p class="mt-3 text-sm leading-relaxed text-[#5c6358]">
                                Dinas/Admin memverifikasi kebenaran laporan, memeriksa koordinat peta, memperbarui tingkat keparahan jika perlu, memberikan catatan tindak lanjut, dan mengubah status berkala.
                            </p>
                        </div>
                        <div class="glass-card p-8 shadow-sm hover:scale-[1.02] hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-[#ff5e00]/10 to-transparent rounded-bl-full transition-all duration-500 group-hover:scale-110"></div>
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff5e00]/15 text-[#ff5e00] font-black text-lg shadow-inner">03</span>
                            <h3 class="mt-6 text-lg font-extrabold text-gray-900">3. Pantau Hingga Selesai</h3>
                            <p class="mt-3 text-sm leading-relaxed text-[#5c6358]">
                                Status laporan akan diperbarui secara transparan (Diterima &rarr; Diverifikasi &rarr; Diproses &rarr; Selesai). Pelapor dapat memantau linimasa perbaikan kapan saja.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-[#161a18] text-white/50 py-12 px-6 lg:px-8 border-t border-black/10">
                <div class="mx-auto max-w-7xl flex flex-col md:flex-row items-center justify-between gap-6 text-sm">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-[#ff5e00] to-[#ff8533] text-white">
                            <x-application-logo class="h-5 w-5" />
                        </span>
                        <span class="font-extrabold text-white tracking-wide">Sulteng Lapor Jalan</span>
                    </div>
                    <p>&copy; {{ date('Y') }} Teknologi Kota Pintar - Smart Mobility. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <script>
            // Initialize Map
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                // Default location: Palu City, Central Sulawesi (-0.8917, 119.8707)
                const map = L.map('map', {
                    scrollWheelZoom: false
                }).setView([-0.8917, 119.8707], 8);

                // Add tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // Parse report markers
                const mapReports = <?php echo json_encode($mapReports->map(function($r) {
                    return [
                        'id' => $r->id,
                        'title' => $r->title,
                        'region' => $r->region,
                        'location' => $r->location,
                        'damage_type' => $r->damage_type,
                        'damage_level' => $r->damage_level,
                        'status' => $r->status,
                        'photo' => asset('storage/' . $r->photo),
                        'coords' => $r->getCoordinates(),
                        'created_at' => $r->created_at->format('d M Y')
                    ];
                })->toArray()); ?>;

                const bounds = [];

                mapReports.forEach(report => {
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
                            <div class="w-64 overflow-hidden rounded-2xl bg-white shadow-lg border border-gray-100">
                                <img src="${report.photo}" class="h-32 w-full object-cover" alt="${report.title}" />
                                <div class="p-4">
                                    <span class="inline-block rounded-full border px-2.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider ${badgeColor}">${report.status}</span>
                                    <h4 class="mt-2 text-sm font-extrabold text-gray-900 line-clamp-1">${report.title}</h4>
                                    <p class="mt-1 text-[11px] text-gray-500 flex items-center">
                                        <i data-lucide="map-pin" class="mr-1 h-3.5 w-3.5 text-[#ff5e00]"></i> ${report.location}
                                    </p>
                                    <div class="mt-3 flex items-center justify-between border-t border-gray-100 pt-2.5 text-[10px] text-gray-400 font-semibold">
                                        <span>${report.created_at}</span>
                                        <span class="font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">Level: ${report.damage_level}</span>
                                    </div>
                                </div>
                            </div>
                        `;

                        // Add marker
                        const marker = L.marker([lat, lng]).addTo(map);
                        marker.bindPopup(popupContent);
                    }
                });

                // Auto fit map boundary if markers exist
                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [40, 40] });
                }

                // Render icons inside map popups on open
                map.on('popupopen', function () {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            });
        </script>
    </body>
</html>
