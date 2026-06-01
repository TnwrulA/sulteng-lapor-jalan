<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Laporan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Laporan Saya</h3>
                    <p class="mt-1 text-sm text-gray-600">Semua laporan jalan rusak yang pernah kamu kirim.</p>
                </div>
                <a href="{{ route('reports.create') }}" class="action-primary">
                    Buat Laporan
                </a>
            </div>

            <div class="ui-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="table-head">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Wilayah</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kerusakan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($reports as $report)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $reports->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $report->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $report->location }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $report->region }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $report->damage_type }} - {{ $report->damage_level }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $report->statusBadgeClass() }}">{{ $report->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $report->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('reports.show', $report) }}" class="link-accent">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500">
                                        Belum ada laporan jalan rusak.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reports->hasPages())
                    <div class="border-t border-[#d7dccd] px-6 py-4">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
