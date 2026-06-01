<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Laporan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('reports.index') }}" class="link-accent text-sm">Kembali ke riwayat</a>
                <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $report->statusBadgeClass() }}">{{ $report->status }}</span>
            </div>

            <div class="grid gap-6 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <div class="ui-card overflow-hidden">
                        <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto laporan {{ $report->title }}" class="h-72 w-full object-cover">
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <div class="ui-card p-6">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $report->title }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $report->description ?: 'Tidak ada keterangan tambahan.' }}</p>

                        <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Lokasi</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->location }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kabupaten atau kota</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->region }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jenis kerusakan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->damage_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tingkat kerusakan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->damage_level }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal laporan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->created_at->format('d M Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Terakhir diperbarui</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->updated_at->format('d M Y H:i') }}</dd>
                            </div>
                        </dl>

                        @if ($report->maps_link)
                            <div class="mt-6">
                                <a href="{{ $report->maps_link }}" target="_blank" rel="noopener noreferrer" class="action-dark">
                                    Buka Lokasi
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="ui-card mt-6 p-6">
                        <h3 class="font-semibold text-gray-900">Catatan Admin</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $report->admin_note ?: 'Belum ada catatan dari admin.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
