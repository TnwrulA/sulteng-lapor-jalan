<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-900 leading-tight flex items-center gap-2">
            <i data-lucide="folder-cog" class="h-6 w-6 text-[#ff5e00]"></i>
            Kelola Semua Laporan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm font-semibold text-green-800 flex items-center shadow-sm">
                    <i data-lucide="check-circle-2" class="me-2 h-5 w-5 text-green-600 shrink-0"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Filter Panel -->
            <div class="glass-card p-6 shadow-sm border border-gray-100">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-12 items-end">
                    <div class="lg:col-span-3">
                        <x-input-label for="search" value="Cari Judul / Lokasi" class="font-bold text-gray-600" />
                        <x-text-input id="search" name="search" type="text" class="field-control mt-1 block w-full text-xs py-2" placeholder="Ketik kata kunci..." :value="$filters['search'] ?? ''" />
                    </div>

                    <div class="lg:col-span-2">
                        <x-input-label for="status" value="Status Tindakan" class="font-bold text-gray-600" />
                        <select id="status" name="status" class="field-control mt-1 block w-full text-xs">
                            <option value="">Semua status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lg:col-span-2">
                        <x-input-label for="damage_level" value="Tingkat Keparahan" class="font-bold text-gray-600" />
                        <select id="damage_level" name="damage_level" class="field-control mt-1 block w-full text-xs">
                            <option value="">Semua tingkat</option>
                            @foreach ($damageLevels as $level)
                                <option value="{{ $level }}" @selected(($filters['damage_level'] ?? '') === $level)>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lg:col-span-2">
                        <x-input-label for="region" value="Wilayah Kabupaten / Kota" class="font-bold text-gray-600" />
                        <select id="region" name="region" class="field-control mt-1 block w-full text-xs">
                            <option value="">Semua wilayah</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region }}" @selected(($filters['region'] ?? '') === $region)>{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lg:col-span-3 grid grid-cols-3 gap-2">
                        <button type="submit" class="premium-btn-primary py-2 text-xs font-bold cursor-pointer col-span-2">
                            <i data-lucide="filter" class="me-1 h-3.5 w-3.5"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="premium-btn-muted py-2 text-xs font-bold text-center flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Header Panel Table with Export CSV -->
            <div class="glass-card shadow-sm overflow-hidden border border-gray-100">
                <div class="border-b border-gray-100 px-6 py-4 bg-white/40 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-extrabold text-gray-900 flex items-center gap-2 text-sm">
                            <i data-lucide="table-properties" class="h-5 w-5 text-[#ff5e00]"></i>
                            Daftar Laporan Masyarakat
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Total terdapat {{ $reports->total() }} laporan terdaftar.</p>
                    </div>
                    
                    <!-- Export CSV Button -->
                    <a href="{{ route('admin.reports.export', request()->query()) }}" class="premium-btn-muted py-2 text-xs font-bold inline-flex items-center gap-1.5 bg-orange-50/50 text-[#ff5e00] border border-[#ff5e00]/25 hover:bg-[#ff5e00]/10 transition shadow-sm cursor-pointer" title="Ekspor data terfilter ke file CSV">
                        <i data-lucide="download" class="h-4.5 w-4.5 text-[#ff5e00]"></i>
                        Unduh Rekap Laporan (CSV)
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200/50 bg-white/70">
                        <thead class="table-head">
                            <tr>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500 w-12 text-center">No</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Pelapor</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Judul Laporan</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Wilayah</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Kerusakan</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500">Tanggal</th>
                                <th class="px-6 py-3.5 text-xs font-extrabold uppercase tracking-wider text-gray-500 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white/40">
                            @forelse ($reports as $report)
                                <tr class="hover:bg-orange-50/20 transition duration-150 group">
                                    <td class="px-6 py-4 text-sm text-gray-400 font-extrabold text-center">{{ $reports->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-semibold">
                                        <div class="flex flex-col">
                                            <span class="text-gray-900 font-extrabold text-xs sm:text-sm">{{ $report->user->name }}</span>
                                            <span class="text-[10px] text-gray-400 font-normal leading-normal mt-0.5">{{ $report->user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-extrabold text-gray-900">
                                        <div class="line-clamp-1" title="{{ $report->title }}">{{ $report->title }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium line-clamp-1 mt-0.5" title="{{ $report->location }}">{{ $report->location }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-semibold">
                                        <span class="inline-flex items-center gap-1">
                                            <i data-lucide="map-pin" class="h-3.5 w-3.5 text-[#ff5e00]/70 shrink-0"></i>
                                            {{ $report->region }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        <div class="text-gray-900 text-xs font-bold">{{ $report->damage_type }}</div>
                                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">Level: {{ $report->damage_level }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-block rounded-full border px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider shadow-sm {{ $report->statusBadgeClass() }}">
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 font-semibold">
                                        {{ $report->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center justify-center gap-3.5">
                                            <a href="{{ route('admin.reports.show', $report) }}" class="inline-flex items-center gap-1 text-[#ff5e00] hover:text-[#d34f00] font-extrabold text-xs transition duration-200">
                                                <i data-lucide="settings" class="h-4.5 w-4.5"></i>
                                                Tindak
                                            </a>
                                            <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-extrabold text-red-600 hover:text-red-700 flex items-center gap-0.5 cursor-pointer text-xs">
                                                    <i data-lucide="trash-2" class="h-4.5 w-4.5"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center text-sm text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-14 w-14 items-center justify-center rounded-full bg-gray-50 flex mb-3 shadow-inner">
                                                <i data-lucide="folder-search" class="h-7 w-7 text-gray-300"></i>
                                            </div>
                                            <span class="font-bold">Tidak ada data laporan yang cocok dengan filter aktif.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reports->hasPages())
                    <div class="border-t border-gray-100 px-6 py-4 bg-white/40">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
