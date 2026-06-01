<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Masyarakat
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="ui-card mb-6 overflow-hidden">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-lg font-semibold">Halo, {{ Auth::user()->name }}!</p>
                            <p class="mt-1 text-sm text-gray-600">Berikut ringkasan laporan jalan rusak yang sudah kamu kirim.</p>
                        </div>
                        <a href="{{ route('reports.create') }}" class="action-primary">
                            Buat Laporan
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach ([
                    'Total Laporan' => $stats['total'],
                    'Menunggu' => $stats['menunggu'],
                    'Diterima' => $stats['diterima'],
                    'Diverifikasi' => $stats['diverifikasi'],
                    'Diproses' => $stats['diproses'],
                    'Selesai' => $stats['selesai'],
                ] as $label => $value)
                    <div class="ui-card p-5">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <div class="ui-card mt-6">
                <div class="border-b border-[#d7dccd] px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Laporan Terbaru</h3>
                        <a href="{{ route('reports.index') }}" class="link-accent text-sm">Lihat semua</a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="table-head">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Wilayah</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($recentReports as $report)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        <a href="{{ route('reports.show', $report) }}" class="hover:text-[#6b7b42]">{{ $report->title }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $report->region }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $report->statusBadgeClass() }}">{{ $report->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $report->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                        Belum ada laporan. Buat laporan pertama untuk mulai memantau statusnya.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
