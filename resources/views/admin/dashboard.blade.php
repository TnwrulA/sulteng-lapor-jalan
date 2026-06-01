<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-900 leading-tight flex items-center gap-2">
            <i data-lucide="shield-check" class="h-6 w-6 text-[#ff5e00]"></i>
            Dashboard Admin
        </h2>
    </x-slot>

    <!-- Alpine Root Component for Drawer and Inspector -->
    <div x-data="{ 
        showDrawer: false, 
        activeReport: null, 
        photoUrl: '', 
        userName: '', 
        userEmail: '', 
        dateFormatted: '',
        selectStatus: '',
        adminNote: '',
        openInspector(report, photo, user, email, date) {
            this.activeReport = report;
            this.photoUrl = photo;
            this.userName = user;
            this.userEmail = email;
            this.dateFormatted = date;
            this.selectStatus = report.status;
            this.adminNote = report.admin_note || '';
            this.showDrawer = true;
        }
    }" class="py-8">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm font-semibold text-green-800 flex items-center shadow-sm">
                    <i data-lucide="check-circle" class="me-2 h-5 w-5 text-green-600 shrink-0"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Welcome Banner -->
            <div class="glass-card overflow-hidden relative shadow-sm border border-gray-100">
                <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-[#ff5e00]/5 to-transparent pointer-events-none"></div>
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between relative z-10">
                        <div>
                            <span class="inline-flex items-center rounded-full bg-red-500/10 border border-red-500/20 px-3 py-1 text-xs font-bold text-red-600 mb-3 shadow-sm">
                                Portal Manajemen Internal
                            </span>
                            <p class="text-2xl font-black text-gray-900 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</p>
                            <p class="mt-1.5 text-sm text-gray-500 leading-relaxed max-w-xl">Aplikasi Monitoring Infrastruktur Jalan Dinas Pekerjaan Umum Sulawesi Tengah. Tinjau laporan masyarakat, koordinasikan perbaikan, dan pantau statistik sebaran.</p>
                        </div>
                        <a href="{{ route('admin.reports.index') }}" class="premium-btn-primary shrink-0 self-start sm:self-center">
                            <i data-lucide="folder-cog" class="me-2 h-5 w-5"></i>
                            Kelola Semua Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid gap-4 grid-cols-2 lg:grid-cols-4">
                <!-- Total Laporan -->
                <div class="glass-card p-5 shadow-sm glow-card-total flex items-center justify-between border-l-4">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Laporan</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-500 border border-gray-200/50 shadow-sm">
                        <i data-lucide="clipboard-list" class="h-5.5 w-5.5"></i>
                    </div>
                </div>

                <!-- Menunggu Verifikasi -->
                <div class="glass-card p-5 shadow-sm glow-card-menunggu flex items-center justify-between border-l-4">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['menunggu'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-200/40 shadow-sm">
                        <i data-lucide="clock" class="h-5.5 w-5.5"></i>
                    </div>
                </div>

                <!-- Diverifikasi -->
                <div class="glass-card p-5 shadow-sm glow-card-diverifikasi flex items-center justify-between border-l-4">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Diverifikasi</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['diverifikasi'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-200/40 shadow-sm">
                        <i data-lucide="shield-check" class="h-5.5 w-5.5"></i>
                    </div>
                </div>

                <!-- Diproses -->
                <div class="glass-card p-5 shadow-sm glow-card-diproses flex items-center justify-between border-l-4">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Diproses</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['diproses'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600 border border-orange-200/40 shadow-sm">
                        <i data-lucide="hammer" class="h-5.5 w-5.5"></i>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="glass-card p-5 shadow-sm glow-card-selesai flex items-center justify-between border-l-4">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Selesai</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['selesai'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-600 border border-green-200/40 shadow-sm">
                        <i data-lucide="check-circle" class="h-5.5 w-5.5"></i>
                    </div>
                </div>

                <!-- Ditolak -->
                <div class="glass-card p-5 shadow-sm glow-card-ditolak flex items-center justify-between border-l-4">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ditolak</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['ditolak'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600 border border-red-200/40 shadow-sm">
                        <i data-lucide="x-circle" class="h-5.5 w-5.5"></i>
                    </div>
                </div>

                <!-- Kerusakan Berat -->
                <div class="glass-card p-5 shadow-sm border-l-4 border-rose-600 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kerusakan Berat</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#991b1b]">{{ $stats['berat'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600 border border-rose-200/40 shadow-sm">
                        <i data-lucide="alert-triangle" class="h-5.5 w-5.5"></i>
                    </div>
                </div>

                <!-- Diterima -->
                <div class="glass-card p-5 shadow-sm border-l-4 border-teal-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Laporan Diterima</p>
                        <p class="mt-2 text-3xl font-extrabold text-gray-950">{{ $stats['diterima'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-teal-600 border border-teal-200/40 shadow-sm">
                        <i data-lucide="mail-open" class="h-5.5 w-5.5"></i>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid gap-6 md:grid-cols-3">
                <!-- Bar Chart: Reports by Region -->
                <div class="glass-card p-6 shadow-sm md:col-span-2 flex flex-col justify-between border border-gray-100">
                    <h3 class="font-extrabold text-sm text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="bar-chart-3" class="h-5 w-5 text-[#ff5e00]"></i>
                        Sebaran Laporan per Wilayah (Kabupaten/Kota)
                    </h3>
                    <div class="h-72 w-full relative">
                        <canvas id="regionChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart: Reports by Status -->
                <div class="glass-card p-6 shadow-sm flex flex-col justify-between border border-gray-100">
                    <h3 class="font-extrabold text-sm text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="pie-chart" class="h-5 w-5 text-[#ff5e00]"></i>
                        Proporsi Status Laporan
                    </h3>
                    <div class="h-72 w-full relative">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Reports Card Table -->
            <div class="glass-card shadow-sm overflow-hidden border border-gray-100">
                <div class="border-b border-gray-100 px-6 py-4 bg-white/40 flex items-center justify-between">
                    <h3 class="font-extrabold text-gray-900 flex items-center gap-2 text-sm">
                        <i data-lucide="bell-ring" class="h-5 w-5 text-[#ff5e00]"></i>
                        Laporan Terbaru Masuk
                    </h3>
                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
                        <i data-lucide="info" class="h-4 w-4"></i>
                        <span>Klik "Buka Inspector" untuk memproses cepat</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200/50">
                        <thead class="table-head">
                            <tr>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Pelapor</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Judul Laporan</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Wilayah</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Tanggal</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($recentReports as $report)
                                <tr class="hover:bg-[#fbfcf7]/80 transition duration-150 group">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-semibold">
                                        <div class="flex flex-col">
                                            <span class="text-gray-900 font-extrabold text-xs sm:text-sm">{{ $report->user->name }}</span>
                                            <span class="text-[10px] text-gray-400 font-normal leading-normal mt-0.5">{{ $report->user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-extrabold text-gray-900">
                                        <div class="line-clamp-1" title="{{ $report->title }}">{{ $report->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        <div class="flex items-center gap-1">
                                            <i data-lucide="map-pin" class="h-4 w-4 text-[#ff5e00]/70"></i>
                                            {{ $report->region }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-block rounded-full border px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider shadow-sm {{ $report->statusBadgeClass() }}">
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 font-semibold">
                                        {{ $report->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <button 
                                            @click="openInspector(
                                                {{ json_encode($report->only(['id', 'title', 'location', 'region', 'damage_type', 'damage_level', 'status', 'description', 'admin_note'])) }}, 
                                                '{{ asset('storage/' . $report->photo) }}', 
                                                '{{ $report->user->name }}', 
                                                '{{ $report->user->email }}', 
                                                '{{ $report->created_at->format('d M Y H:i') }}'
                                            )" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#ff5e00]/10 hover:bg-[#ff5e00]/20 text-[#ff5e00] font-extrabold text-xs transition duration-200 cursor-pointer border border-[#ff5e00]/20"
                                        >
                                            <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                                            Inspector
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i data-lucide="folder-open" class="h-10 w-10 text-gray-300 mb-2"></i>
                                            <span class="font-bold">Belum ada laporan masuk dari masyarakat.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Alpine-powered Quick Sidebar Inspector Drawer (Meluncur dari Kanan) -->
        <div x-show="showDrawer" 
             class="fixed inset-0 z-[100] overflow-hidden" 
             style="display: none;"
             x-description="Slide-over panel, show/hide based on slide-over state."
        >
            <!-- Drawer Backdrop Overlay -->
            <div x-show="showDrawer" 
                 x-transition:enter="ease-in-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in-out duration-300" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 @click="showDrawer = false" 
                 class="fixed inset-0 drawer-overlay"
            ></div>

            <!-- Drawer Container Wrapper -->
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        
                        <!-- Panel Content slider -->
                        <div x-show="showDrawer" 
                             x-transition:enter="transform transition ease-in-out duration-300" 
                             x-transition:enter-start="translate-x-full" 
                             x-transition:enter-end="translate-x-0" 
                             x-transition:leave="transform transition ease-in-out duration-300" 
                             x-transition:leave-start="translate-x-0" 
                             x-transition:leave-end="translate-x-full" 
                             class="pointer-events-auto w-screen max-w-lg drawer-content"
                        >
                            <div class="flex h-full flex-col bg-white shadow-2xl border-l border-gray-100">
                                
                                <!-- Drawer Header -->
                                <div class="px-6 py-5 bg-orange-50/30 border-b border-orange-100/50 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="eye" class="h-5 w-5 text-[#ff5e00]"></i>
                                        <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider">Quick Inspector</h2>
                                    </div>
                                    <button @click="showDrawer = false" class="rounded-xl p-1 bg-white hover:bg-gray-100 border border-gray-200 text-gray-400 hover:text-gray-900 transition cursor-pointer shadow-sm">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </button>
                                </div>

                                <!-- Drawer Body Content -->
                                <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6">
                                    
                                    <!-- Photo Block -->
                                    <div class="rounded-xl overflow-hidden border border-gray-100 shadow-sm relative h-52 bg-gray-50">
                                        <img :src="photoUrl" class="w-full h-full object-cover" alt="Foto jalan rusak">
                                    </div>

                                    <!-- Title & Description -->
                                    <div class="space-y-2">
                                        <h3 class="text-lg font-black text-gray-900 leading-snug" x-text="activeReport ? activeReport.title : ''"></h3>
                                        <div class="text-xs text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-100/50 leading-relaxed font-semibold shadow-inner" x-text="activeReport && activeReport.description ? activeReport.description : 'Tidak ada keterangan tambahan.'"></div>
                                    </div>

                                    <!-- Report Metadatas -->
                                    <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-5">
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pelapor</span>
                                            <p class="text-xs font-black text-gray-900 mt-1" x-text="userName"></p>
                                            <p class="text-[10px] text-gray-400 line-clamp-1" x-text="userEmail"></p>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Masuk</span>
                                            <p class="text-xs font-semibold text-gray-800 mt-1 flex items-center gap-1">
                                                <i data-lucide="calendar" class="h-3.5 w-3.5 text-gray-400"></i>
                                                <span x-text="dateFormatted"></span>
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Wilayah</span>
                                            <p class="text-xs font-bold text-gray-900 mt-1 flex items-center gap-1">
                                                <i data-lucide="navigation" class="h-3.5 w-3.5 text-[#ff5e00]"></i>
                                                <span x-text="activeReport ? activeReport.region : ''"></span>
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tingkat Kerusakan</span>
                                            <p class="text-xs font-bold text-gray-900 mt-1 flex items-center gap-1">
                                                <i data-lucide="gauge" class="h-3.5 w-3.5 text-amber-600"></i>
                                                <span x-text="activeReport ? activeReport.damage_level : ''"></span>
                                            </p>
                                        </div>
                                        <div class="col-span-2">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Alamat Lengkap</span>
                                            <p class="text-xs font-bold text-gray-900 mt-1 flex items-start gap-1">
                                                <i data-lucide="map-pin" class="h-4 w-4 text-[#ff5e00] shrink-0 mt-0.5"></i>
                                                <span x-text="activeReport ? activeReport.location : ''"></span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Quick Action Form (Update Status) -->
                                    <div class="border-t border-gray-100 pt-5 space-y-4">
                                        <h4 class="font-extrabold text-gray-700 text-xs uppercase tracking-wider flex items-center gap-1.5">
                                            <i data-lucide="edit-3" class="h-4.5 w-4.5 text-[#ff5e00]"></i>
                                            Tindak Lanjut Laporan
                                        </h4>

                                        <!-- Update form referencing dynamic ID action -->
                                        <form method="POST" :action="'/admin/reports/' + (activeReport ? activeReport.id : '') + '/status'" class="space-y-4">
                                            @csrf
                                            @method('PUT')

                                            <div>
                                                <label for="drawer_status" class="block text-xs font-bold text-gray-500 uppercase">Status Tindakan</label>
                                                <select id="drawer_status" name="status" x-model="selectStatus" class="field-control mt-1 block w-full text-xs" required>
                                                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                                                    <option value="Diterima">Diterima</option>
                                                    <option value="Diverifikasi">Diverifikasi</option>
                                                    <option value="Diproses">Diproses</option>
                                                    <option value="Selesai">Selesai</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="drawer_admin_note" class="block text-xs font-bold text-gray-500 uppercase">Tanggapan Resmi Dinas</label>
                                                
                                                <!-- Template Buttons Container -->
                                                <div class="flex flex-wrap gap-1.5 mt-1.5 mb-2">
                                                    <button type="button" @click="adminNote = 'Laporan terverifikasi. Petugas survei dinas pekerjaan umum akan segera menuju lokasi.'" class="px-2 py-1 rounded bg-orange-50/50 hover:bg-orange-100/50 text-[#ff5e00] text-[9px] font-bold border border-[#ff5e00]/25 transition cursor-pointer">Template 1</button>
                                                    <button type="button" @click="adminNote = 'Perbaikan jalan dijadwalkan pada anggaran pembangunan daerah triwulan ini.'" class="px-2 py-1 rounded bg-orange-50/50 hover:bg-orange-100/50 text-[#ff5e00] text-[9px] font-bold border border-[#ff5e00]/25 transition cursor-pointer">Template 2</button>
                                                    <button type="button" @click="adminNote = 'Pekerjaan perbaikan selesai dikerjakan 100%. Laporan ditutup.'" class="px-2 py-1 rounded bg-orange-50/50 hover:bg-orange-100/50 text-[#ff5e00] text-[9px] font-bold border border-[#ff5e00]/25 transition cursor-pointer">Template 3</button>
                                                </div>

                                                <textarea id="drawer_admin_note" name="admin_note" rows="3" x-model="adminNote" class="field-control block w-full text-xs" placeholder="Ketik deskripsi tindak lanjut dinas di sini..."></textarea>
                                            </div>

                                            <div class="pt-3 flex gap-2">
                                                <button type="submit" class="premium-btn-primary flex-grow text-xs py-2 shadow-sm font-extrabold cursor-pointer">
                                                    <i data-lucide="save" class="me-1 h-3.5 w-3.5"></i>
                                                    Simpan Tindakan
                                                </button>
                                                <a :href="'/admin/reports/' + (activeReport ? activeReport.id : '')" class="premium-btn-muted text-xs py-2 font-bold flex items-center justify-center gap-1">
                                                    Detail Lengkap
                                                    <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data for Region Chart
            const regionData = @json($regionChartData);
            const regionLabels = Object.keys(regionData);
            const regionValues = Object.values(regionData);

            const ctxRegion = document.getElementById('regionChart').getContext('2d');
            new Chart(ctxRegion, {
                type: 'bar',
                data: {
                    labels: regionLabels,
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: regionValues,
                        backgroundColor: 'rgba(255, 94, 0, 0.75)', // Premium orange matching our theme
                        borderColor: '#ff5e00',
                        borderWidth: 1.5,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(229, 231, 235, 0.5)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Data for Status Chart
            const stats = @json($stats);
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Diterima', 'Diverifikasi', 'Diproses', 'Selesai', 'Ditolak'],
                    datasets: [{
                        data: [
                            stats.menunggu,
                            stats.diterima,
                            stats.diverifikasi,
                            stats.diproses,
                            stats.selesai,
                            stats.ditolak
                        ],
                        backgroundColor: [
                            '#f2b84b', // Yellow
                            '#a8a29e', // Stone
                            '#60a5fa', // Blue
                            '#ff5e00', // Premium Orange theme
                            '#22c55e', // Green
                            '#ef4444'  // Red
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 11,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        });
    </script>
</x-app-layout>
