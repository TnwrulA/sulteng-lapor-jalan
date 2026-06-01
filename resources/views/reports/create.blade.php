<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Laporan Jalan Rusak
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" class="ui-card p-6">
                @csrf

                <div>
                    <x-input-label for="title" value="Judul laporan" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="location" value="Lokasi jalan rusak" />
                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="region" value="Kabupaten atau kota" />
                    <select id="region" name="region" class="field-control mt-1 block w-full" required>
                        <option value="">Pilih wilayah</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region }}" @selected(old('region') === $region)>{{ $region }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('region')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="maps_link" value="Link Google Maps atau koordinat" />
                    <x-text-input id="maps_link" name="maps_link" type="text" class="mt-1 block w-full" :value="old('maps_link')" />
                    <x-input-error :messages="$errors->get('maps_link')" class="mt-2" />
                </div>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="damage_type" value="Jenis kerusakan" />
                        <select id="damage_type" name="damage_type" class="field-control mt-1 block w-full" required>
                            <option value="">Pilih jenis</option>
                            @foreach ($damageTypes as $type)
                                <option value="{{ $type }}" @selected(old('damage_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('damage_type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="damage_level" value="Tingkat kerusakan" />
                        <select id="damage_level" name="damage_level" class="field-control mt-1 block w-full" required>
                            <option value="">Pilih tingkat</option>
                            @foreach ($damageLevels as $level)
                                <option value="{{ $level }}" @selected(old('damage_level') === $level)>{{ $level }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('damage_level')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-4">
                    <x-input-label for="photo" value="Foto bukti jalan rusak" />
                    <input id="photo" name="photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="mt-1 block w-full rounded-md border border-[#cbd3bf] text-sm text-[#30382e] file:mr-4 file:border-0 file:bg-[#f4f6ed] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#30382e] hover:file:bg-[#e7ebdd]" required>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="description" value="Keterangan tambahan" />
                    <textarea id="description" name="description" rows="5" class="field-control mt-1 block w-full">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <a href="{{ route('reports.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Kirim Laporan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
