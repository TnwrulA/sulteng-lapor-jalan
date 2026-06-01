<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Laporan Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('admin.reports.index') }}" class="link-accent text-sm">Kembali ke daftar laporan</a>
                <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $report->statusBadgeClass() }}">{{ $report->status }}</span>
            </div>

            <div class="grid gap-6 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <div class="ui-card overflow-hidden">
                        <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto laporan {{ $report->title }}" class="h-72 w-full object-cover">
                    </div>

                    <div class="ui-card mt-6 p-6">
                        <h3 class="font-semibold text-gray-900">Data Pelapor</h3>
                        <dl class="mt-4 space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $report->user->email }}</dd>
                            </div>
                        </dl>
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
                                <a href="{{ $report->maps_link }}" target="_blank" class="action-dark">
                                    Buka Lokasi
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="ui-card mt-6 p-6">
                        <h3 class="font-semibold text-gray-900">Update Status Laporan</h3>

                        <form method="POST" action="{{ route('admin.reports.update-status', $report) }}" class="mt-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label for="status" value="Status laporan" />
                                <select id="status" name="status" class="field-control mt-1 block w-full" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" @selected(old('status', $report->status) === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="admin_note" value="Catatan admin" />
                                <textarea id="admin_note" name="admin_note" rows="5" class="field-control mt-1 block w-full">{{ old('admin_note', $report->admin_note) }}</textarea>
                                <x-input-error :messages="$errors->get('admin_note')" class="mt-2" />
                            </div>

                            <div class="mt-6 flex justify-end">
                                <x-primary-button>Simpan Perubahan</x-primary-button>
                            </div>
                        </form>

                        <div class="mt-6 border-t border-[#d7dccd] pt-4">
                            <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Hapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-700 hover:text-red-800">Hapus Laporan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
