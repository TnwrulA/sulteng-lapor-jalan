<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-900 leading-tight flex items-center gap-2">
            <i data-lucide="file-clock" class="h-6 w-6 text-[#ff5e00]"></i>
            Riwayat Laporan Saya
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

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-xl font-black text-gray-900 tracking-tight">Daftar Laporan Anda</h3>
                    <p class="mt-1 text-sm text-gray-500">Kumpulan seluruh laporan kerusakan jalan yang pernah Anda kirimkan.</p>
                </div>
                <a href="{{ route('reports.create') }}" class="premium-btn-primary shrink-0 self-start sm:self-center">
                    <i data-lucide="plus-circle" class="me-2 h-5 w-5"></i>
                    Buat Laporan
                </a>
            </div>

            <!-- Reports Card Grid -->
            @if ($reports->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($reports as $report)
                        <div class="glass-card overflow-hidden shadow-sm flex flex-col justify-between group hover:scale-[1.02] hover:shadow-md hover:border-[#ff5e00]/20 transition duration-300">
                            <div>
                                <!-- Report Photo Frame -->
                                <div class="relative h-48 overflow-hidden bg-gray-100 border-b border-gray-100">
                                    <img src="{{ asset('storage/' . $report->photo) }}" alt="{{ $report->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    
                                    <!-- Floating Badges -->
                                    <div class="absolute top-3 left-3 right-3 flex justify-between items-center">
                                        <span class="rounded-full border px-2.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider bg-white/90 backdrop-blur shadow-sm {{ $report->statusBadgeClass() }}">
                                            {{ $report->status }}
                                        </span>
                                        <span class="rounded-full px-2.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider bg-black/60 text-white backdrop-blur shadow-sm">
                                            {{ $report->damage_level }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Contents -->
                                <div class="p-5 space-y-3">
                                    <div class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider flex items-center">
                                        <i data-lucide="calendar" class="me-1 h-3.5 w-3.5"></i>
                                        {{ $report->created_at->format('d M Y') }}
                                    </div>
                                    <h4 class="font-extrabold text-gray-900 group-hover:text-[#ff5e00] transition duration-200 text-base leading-snug line-clamp-1">
                                        {{ $report->title }}
                                    </h4>
                                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                        {{ $report->description ?: 'Tidak ada keterangan tambahan.' }}
                                    </p>

                                    <!-- Metadatas -->
                                    <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                                        <div class="text-xs text-gray-600 font-medium flex items-start gap-1.5">
                                            <i data-lucide="map-pin" class="h-4 w-4 text-[#ff5e00] shrink-0 mt-0.5"></i>
                                            <span class="line-clamp-1" title="{{ $report->location }}">{{ $report->location }}</span>
                                        </div>
                                        <div class="text-xs text-gray-600 font-medium flex items-center gap-1.5 bg-orange-50/50 py-1 px-2.5 rounded-md w-fit">
                                            <i data-lucide="navigation" class="h-3.5 w-3.5 text-[#ff5e00] shrink-0"></i>
                                            <span>{{ $report->region }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer CTA -->
                            <div class="px-5 pb-5 pt-2">
                                <a href="{{ route('reports.show', $report) }}" class="premium-btn-dark w-full py-2 flex items-center justify-center font-bold text-xs">
                                    Lihat Detail & Lacak Status
                                    <i data-lucide="arrow-right" class="ms-1.5 h-4 w-4 transition duration-300 group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($reports->hasPages())
                    <div class="glass-card px-6 py-4 border border-gray-200/50">
                        {{ $reports->links() }}
                    </div>
                @endif
            @else
                <div class="glass-card py-20 text-center text-gray-500 border border-gray-200/50">
                    <div class="flex flex-col items-center">
                        <div class="h-16 w-16 items-center justify-center rounded-full bg-gray-50 flex mb-4 shadow-inner">
                            <i data-lucide="folder-warning" class="h-8 w-8 text-gray-300"></i>
                        </div>
                        <span class="font-bold text-gray-700">Anda belum pernah mengirimkan laporan kerusakan jalan.</span>
                        <p class="text-sm text-gray-400 mt-1 max-w-sm">Laporkan jalan berlubang atau rusak di sekitar Anda agar segera ditindaklanjuti.</p>
                        <a href="{{ route('reports.create') }}" class="mt-6 premium-btn-primary px-6 py-3">
                            Buat Laporan Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
