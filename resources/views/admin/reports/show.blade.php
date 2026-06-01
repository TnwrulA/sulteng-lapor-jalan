<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-900 leading-tight">
            Tindak Lanjut Laporan Masyarakat (Admin)
        </h2>
    </x-slot>

    @php
        $currentStatus = $report->status;
        $statusesList = ['Diterima', 'Diverifikasi', 'Diproses', 'Selesai'];
        if ($currentStatus === 'Menunggu Verifikasi') {
            $currentStatus = 'Diterima';
        }
        
        $isRejected = $currentStatus === 'Ditolak';
        $currentIndex = array_search($currentStatus, $statusesList);
        if ($currentIndex === false) {
            $currentIndex = 0;
        }
    @endphp

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm font-semibold text-green-800 flex items-center shadow-sm">
                    <i data-lucide="check-circle" class="me-2 h-5 w-5 text-green-600 shrink-0"></i>
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.reports.index') }}" class="link-accent text-xs flex items-center font-extrabold text-[#ff5e00]">
                    <i data-lucide="arrow-left" class="me-1.5 h-4 w-4"></i>
                    Kembali ke Daftar Kelola
                </a>
                <span class="rounded-full px-4 py-1 text-xs font-extrabold border shadow-sm uppercase tracking-wider {{ $report->statusBadgeClass() }}">
                    {{ $report->status }}
                </span>
            </div>

            <!-- Timeline Stepper Track -->
            <div class="glass-card p-6 shadow-sm border border-gray-200/50">
                <h3 class="font-extrabold text-gray-900 mb-6 text-xs uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="git-commit" class="h-4.5 w-4.5 text-[#ff5e00]"></i>
                    Status Pelacakan Laporan Kerusakan
                </h3>
                <div class="timeline-stepper">
                    @if ($isRejected)
                        <div class="timeline-step completed">
                            <div class="timeline-icon">
                                <i data-lucide="check" class="h-5 w-5"></i>
                            </div>
                            <div class="mt-2 text-xs font-bold text-gray-900 sm:text-sm">Laporan Diterima</div>
                        </div>
                        <div class="timeline-step active">
                            <div class="timeline-icon bg-red-100 border-red-500 text-red-600 shadow-sm animate-pulse">
                                <i data-lucide="x-circle" class="h-5 w-5"></i>
                            </div>
                            <div class="mt-2 text-xs font-bold text-red-600 sm:text-sm">Laporan Ditolak</div>
                        </div>
                    @else
                        @foreach ($statusesList as $index => $statusName)
                            @php
                                $isCompleted = $currentIndex > $index;
                                $isActive = $currentIndex === $index;
                            @endphp
                            <div class="timeline-step {{ $isCompleted ? 'completed' : ($isActive ? 'active' : '') }}">
                                <div class="timeline-icon">
                                    @if ($isCompleted)
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    @elseif ($isActive)
                                        @if ($statusName === 'Selesai')
                                            <i data-lucide="check-circle" class="h-5 w-5"></i>
                                        @else
                                            <i data-lucide="loader" class="h-5 w-5 animate-spin"></i>
                                        @endif
                                    @else
                                        <i data-lucide="circle-dot" class="h-5 w-5 text-gray-300"></i>
                                    @endif
                                </div>
                                <div class="mt-2.5 text-xs font-extrabold sm:text-sm {{ $isActive ? 'text-orange-600' : ($isCompleted ? 'text-[#ff5e00]' : 'text-gray-400') }}">
                                    {{ $statusName }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Grid Details & Actions Form -->
            <div class="grid gap-6 lg:grid-cols-5 items-start">
                
                <!-- Left Side: Photo and Pelapor Info (2 cols) -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <!-- Photo -->
                    <div class="glass-card overflow-hidden shadow-sm border border-gray-200/50">
                        <div class="border-b border-gray-100 px-5 py-3.5 bg-white/40">
                            <h3 class="font-extrabold text-sm text-gray-900 flex items-center gap-2">
                                <i data-lucide="image" class="h-4.5 w-4.5 text-[#ff5e00]"></i>
                                Foto Bukti Kerusakan
                            </h3>
                        </div>
                        <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto laporan {{ $report->title }}" class="h-72 w-full object-cover">
                    </div>

                    <!-- Pelapor Info Box -->
                    <div class="glass-card p-5 shadow-sm border-l-5 border-[#ff5e00] relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-full bg-[#ff5e00]/5 pointer-events-none"></div>
                        <h3 class="font-extrabold text-sm text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="user-check" class="h-5 w-5 text-[#ff5e00] shrink-0"></i>
                            Identitas Pengirim Laporan
                        </h3>
                        <dl class="space-y-3.5">
                            <div class="border-b border-gray-100 pb-2">
                                <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Lengkap</dt>
                                <dd class="mt-0.5 text-sm font-extrabold text-gray-900">{{ $report->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Alamat Email</dt>
                                <dd class="mt-0.5 text-sm font-semibold text-gray-600">{{ $report->user->email }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Map Preview -->
                    <div class="glass-card p-5 shadow-sm border border-gray-200/50">
                        <h3 class="font-extrabold text-sm text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="map" class="h-4.5 w-4.5 text-[#ff5e00]"></i>
                            Lokasi Presisi pada Peta
                        </h3>
                        @if ($report->getCoordinates())
                            <div class="rounded-xl overflow-hidden border border-gray-200 h-60 relative shadow-inner">
                                <div id="map-preview" class="h-full w-full z-10"></div>
                            </div>
                        @else
                            <div class="rounded-xl bg-gray-50 p-8 border border-dashed border-gray-200 text-center text-gray-500">
                                <i data-lucide="map-pin-off" class="mx-auto h-8 w-8 text-gray-400 mb-2"></i>
                                <p class="text-xs font-semibold">Koordinat peta tidak valid.</p>
                                @if ($report->maps_link)
                                    <a href="{{ $report->maps_link }}" target="_blank" rel="noopener" class="link-accent text-xs mt-2 inline-block font-bold">Buka Link Manual &rarr;</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side: Details and Update Status Form (3 cols) -->
                <div class="lg:col-span-3 flex flex-col gap-6">
                    <!-- Detail Card -->
                    <div class="glass-card p-6 shadow-sm border border-gray-200/50 space-y-5">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-snug">{{ $report->title }}</h3>
                            <div class="mt-3.5 text-sm text-gray-600 leading-relaxed bg-[#fbfcf7]/80 border border-gray-100 p-4 rounded-xl shadow-inner font-medium">
                                {{ $report->description ?: 'Tidak ada keterangan tambahan.' }}
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-5">
                            <h4 class="font-extrabold text-xs uppercase tracking-wider text-gray-400 mb-4">Rincian Informasi Laporan</h4>
                            
                            <dl class="grid gap-x-4 gap-y-5 sm:grid-cols-2">
                                <div class="border-b border-gray-100/50 pb-2.5">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat Detail Lokasi</dt>
                                    <dd class="mt-1 text-sm font-extrabold text-gray-900 flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="h-4.5 w-4.5 text-[#ff5e00] shrink-0"></i>
                                        {{ $report->location }}
                                    </dd>
                                </div>
                                <div class="border-b border-gray-100/50 pb-2.5">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kabupaten / Kota</dt>
                                    <dd class="mt-1 text-sm font-extrabold text-gray-900 flex items-center gap-1.5">
                                        <i data-lucide="navigation" class="h-4.5 w-4.5 text-[#ff5e00] shrink-0"></i>
                                        {{ $report->region }}
                                    </dd>
                                </div>
                                <div class="border-b border-gray-100/50 pb-2.5">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jenis Kerusakan</dt>
                                    <dd class="mt-1 text-sm font-extrabold text-gray-900 flex items-center gap-1.5">
                                        <i data-lucide="alert-triangle" class="h-4.5 w-4.5 text-[#ff5e00] shrink-0"></i>
                                        {{ $report->damage_type }}
                                    </dd>
                                </div>
                                <div class="border-b border-gray-100/50 pb-2.5">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tingkat Kerusakan</dt>
                                    <dd class="mt-1 text-sm font-extrabold text-gray-900 flex items-center gap-1.5">
                                        <i data-lucide="gauge" class="h-4.5 w-4.5 text-[#ff5e00] shrink-0"></i>
                                        {{ $report->damage_level }}
                                    </dd>
                                </div>
                                <div class="sm:border-none border-b border-gray-100/50 pb-2.5 sm:pb-0">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Dilaporkan</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-600 flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="h-4 w-4 text-gray-400 shrink-0"></i>
                                        {{ $report->created_at->format('d M Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Terakhir Diperbarui</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-600 flex items-center gap-1.5">
                                        <i data-lucide="clock" class="h-4 w-4 text-gray-400 shrink-0"></i>
                                        {{ $report->updated_at->format('d M Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        @if ($report->maps_link)
                            <div class="border-t border-gray-100 pt-5 flex flex-wrap gap-3">
                                <a href="{{ $report->maps_link }}" target="_blank" rel="noopener noreferrer" class="premium-btn-dark inline-flex items-center gap-2">
                                    <i data-lucide="external-link" class="h-4.5 w-4.5"></i>
                                    Buka Google Maps
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Update Status Panel -->
                    <div class="glass-card p-6 shadow-sm border-t-5 border-[#ff5e00] border-x border-b border-gray-200/50 space-y-4">
                        <h3 class="font-extrabold text-gray-900 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <i data-lucide="edit-3" class="h-5 w-5 text-[#ff5e00] shrink-0"></i>
                            Form Tindak Lanjut & Respon Dinas
                        </h3>

                        <form method="POST" action="{{ route('admin.reports.update-status', $report) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label for="status" value="Ubah Status Laporan" class="font-bold text-gray-600" />
                                <select id="status" name="status" class="field-control mt-1 block w-full text-xs py-2.5" required>
                                    <option value="Menunggu Verifikasi" @selected(old('status', $report->status) === 'Menunggu Verifikasi')>Menunggu Verifikasi</option>
                                    <option value="Diterima" @selected(old('status', $report->status) === 'Diterima')>Diterima</option>
                                    <option value="Diverifikasi" @selected(old('status', $report->status) === 'Diverifikasi')>Diverifikasi</option>
                                    <option value="Diproses" @selected(old('status', $report->status) === 'Diproses')>Diproses</option>
                                    <option value="Selesai" @selected(old('status', $report->status) === 'Selesai')>Selesai</option>
                                    <option value="Ditolak" @selected(old('status', $report->status) === 'Ditolak')>Ditolak</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="admin_note" value="Catatan Penanganan Dinas" class="font-bold text-gray-600" />
                                
                                <!-- Template Buttons (Quick Response) -->
                                <div class="flex flex-wrap gap-1.5 mt-1.5 mb-2.5">
                                    <button type="button" onclick="setTemplateText('Laporan valid dan telah diverifikasi. Petugas teknis dinas terkait dijadwalkan meninjau lokasi.')" class="px-2.5 py-1 text-[9px] font-extrabold rounded-lg border border-[#ff5e00]/20 bg-orange-50/30 hover:bg-orange-50 text-[#ff5e00] cursor-pointer transition shadow-sm">Laporan Valid</button>
                                    <button type="button" onclick="setTemplateText('Laporan sedang diproses. Anggaran pemeliharaan jalan dijadwalkan pada triwulan ini.')" class="px-2.5 py-1 text-[9px] font-extrabold rounded-lg border border-[#ff5e00]/20 bg-orange-50/30 hover:bg-orange-50 text-[#ff5e00] cursor-pointer transition shadow-sm">Penjadwalan Anggaran</button>
                                    <button type="button" onclick="setTemplateText('Pekerjaan pemeliharaan dan pengaspalan jalan rusak selesai dikerjakan 100%. Laporan ditutup.')" class="px-2.5 py-1 text-[9px] font-extrabold rounded-lg border border-[#ff5e00]/20 bg-orange-50/30 hover:bg-orange-50 text-[#ff5e00] cursor-pointer transition shadow-sm">Selesai Perbaikan</button>
                                    <button type="button" onclick="setTemplateText('Laporan ditolak karena koordinat tidak valid atau lokasi jalan rusak di luar batas wilayah administrasi kami.')" class="px-2.5 py-1 text-[9px] font-extrabold rounded-lg border border-[#ff5e00]/20 bg-orange-50/30 hover:bg-orange-50 text-[#ff5e00] cursor-pointer transition shadow-sm">Laporan Ditolak</button>
                                </div>

                                <textarea id="admin_note" name="admin_note" rows="4" class="field-control block w-full text-xs" placeholder="Pilih template di atas atau ketik deskripsi tindakan dinas secara lengkap di sini...">{{ old('admin_note', $report->admin_note) }}</textarea>
                                <x-input-error :messages="$errors->get('admin_note')" class="mt-2" />
                            </div>

                            <div class="flex justify-end pt-2">
                                <x-primary-button class="premium-btn-primary">
                                    <i data-lucide="save" class="me-2 h-4 w-4"></i>
                                    Simpan Perubahan
                                </x-primary-button>
                            </div>
                        </form>

                        <div class="mt-6 border-t border-gray-100 pt-4 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between text-xs">
                            <span class="text-gray-400 font-extrabold uppercase tracking-wider flex items-center gap-1">
                                <i data-lucide="shield-alert" class="h-4 w-4"></i>
                                Admin Action Zone
                            </span>
                            <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-extrabold text-red-600 hover:text-red-700 flex items-center gap-1 cursor-pointer">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    Hapus Laporan Secara Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script template filler & Leaflet preview initialization -->
    <script>
        function setTemplateText(text) {
            document.getElementById('admin_note').value = text;
        }

        @if ($report->getCoordinates())
            document.addEventListener('DOMContentLoaded', function () {
                const coords = @json($report->getCoordinates());
                if (coords && coords.lat && coords.lng) {
                    const map = L.map('map-preview', {
                        scrollWheelZoom: false,
                        zoomControl: true
                    }).setView([coords.lat, coords.lng], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    L.marker([coords.lat, coords.lng]).addTo(map)
                        .bindPopup(`<b class="text-xs text-gray-900">${@json($report->title)}</b><br><span class="text-[10px] text-gray-500">${@json($report->location)}</span>`)
                        .openPopup();
                }
            });
        @endif
    </script>
</x-app-layout>
