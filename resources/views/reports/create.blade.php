<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-900 leading-tight">
            Buat Laporan Jalan Rusak Baru
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-12 items-stretch">
                
                <!-- Left Column: Immersive Map Selection (7 cols) -->
                <div class="lg:col-span-7 flex flex-col space-y-4">
                    <div class="glass-card p-5 shadow-sm flex flex-col justify-between flex-grow">
                        <div class="mb-4">
                            <h3 class="font-extrabold text-base text-gray-900 flex items-center gap-2">
                                <i data-lucide="map-pin" class="h-5 w-5 text-[#ff5e00]"></i>
                                Tentukan Titik Kerusakan pada Peta
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">Geser pin merah atau klik langsung pada peta di bawah ini untuk menandai posisi jalan rusak secara akurat.</p>
                        </div>

                        <!-- Map Container -->
                        <div class="rounded-xl overflow-hidden border border-gray-200 min-h-[400px] lg:h-[500px] relative shadow-inner">
                            <div id="map-select" class="h-full w-full z-10"></div>
                        </div>

                        <div class="mt-4 flex items-start gap-2 bg-orange-50/50 p-3.5 rounded-xl border border-orange-100/50">
                            <i data-lucide="info" class="h-5 w-5 text-[#ff5e00] shrink-0 mt-0.5"></i>
                            <p class="text-xs text-[#1a1e1b]/80 leading-relaxed">
                                Sistem kami akan secara otomatis menerjemahkan posisi koordinat peta ini menjadi link Google Maps presisi untuk memudahkan tim survei dinas menuju lokasi penanganan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Frosted Glass Form (5 cols) -->
                <div class="lg:col-span-5">
                    <form id="create-report-form" method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" class="glass-card p-6 shadow-md space-y-4 h-full flex flex-col justify-between border border-gray-200/50">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="title" value="Judul Laporan" class="font-bold text-gray-700" />
                                <x-text-input id="title" name="title" type="text" class="field-control mt-1 block w-full text-sm py-2.5" :value="old('title')" placeholder="Contoh: Lubang Besar di Jl. Tadulako" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="damage_type" value="Jenis Kerusakan" class="font-bold text-gray-700" />
                                    <select id="damage_type" name="damage_type" class="field-control mt-1 block w-full text-xs" required>
                                        <option value="">Pilih jenis</option>
                                        @foreach ($damageTypes as $type)
                                            <option value="{{ $type }}" @selected(old('damage_type') === $type)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('damage_type')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="damage_level" value="Tingkat Kerusakan" class="font-bold text-gray-700" />
                                    <select id="damage_level" name="damage_level" class="field-control mt-1 block w-full text-xs" required>
                                        <option value="">Pilih tingkat</option>
                                        @foreach ($damageLevels as $level)
                                            <option value="{{ $level }}" @selected(old('damage_level') === $level)>{{ $level }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('damage_level')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="region" value="Kabupaten / Kota" class="font-bold text-gray-700" />
                                <select id="region" name="region" class="field-control mt-1 block w-full text-xs" required>
                                    <option value="">Pilih wilayah</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region }}" @selected(old('region') === $region)>{{ $region }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('region')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="location" value="Alamat Detail Lokasi" class="font-bold text-gray-700" />
                                <x-text-input id="location" name="location" type="text" class="field-control mt-1 block w-full text-sm py-2.5" :value="old('location')" placeholder="Contoh: Depan Kampus Untad, dekat lampu merah" required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="maps_link" value="Koordinat Laporan (Auto-Fill)" class="font-bold text-gray-700" />
                                <x-text-input id="maps_link" name="maps_link" type="text" class="field-control mt-1 block w-full text-sm bg-gray-50/50 py-2.5 font-mono text-gray-500" :value="old('maps_link')" placeholder="Geser marker peta di samping..." required />
                                <x-input-error :messages="$errors->get('maps_link')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label value="Foto Bukti Kerusakan" class="font-bold text-gray-700 mb-1" />
                                <div onclick="document.getElementById('photo').click()" class="drag-drop-zone transition-all duration-300">
                                    <div id="dropzone-text" class="flex flex-col items-center">
                                        <i data-lucide="cloud-upload" class="h-10 w-10 text-gray-400 mb-2"></i>
                                        <span class="text-xs font-extrabold text-gray-700">Pilih Berkas Foto Jalan</span>
                                        <span class="text-[10px] text-gray-400 mt-1">Format: JPG, JPEG, PNG (Maks 2MB)</span>
                                    </div>
                                    <div id="dropzone-preview" class="hidden flex-col items-center">
                                        <i data-lucide="file-check" class="h-10 w-10 text-green-600 mb-2"></i>
                                        <span id="file-name" class="text-xs font-extrabold text-gray-800 line-clamp-1">file.jpg</span>
                                        <span class="text-[10px] text-green-600 mt-1">Siap diunggah. Klik untuk ganti.</span>
                                    </div>
                                    <!-- REMOVED native 'required' attribute to prevent silent browser blocking -->
                                    <input id="photo" name="photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="hidden" onchange="handleFileSelected(this)">
                                </div>
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" value="Keterangan / Detail Tambahan" class="font-bold text-gray-700" />
                                <textarea id="description" name="description" rows="3" class="field-control mt-1 block w-full text-xs" placeholder="Jelaskan kondisi jalan lebih rinci (misal: kedalaman lubang, bahaya malam hari)...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-4 border-t border-gray-100 pt-4 shrink-0">
                            <a href="{{ route('reports.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-900 transition duration-200">Batal</a>
                            <x-primary-button class="premium-btn-primary">
                                <i data-lucide="send-to-back" class="me-2 h-4 w-4"></i>
                                Kirim Laporan
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Leaflet Selection & Dropzone script -->
    <script>
        function handleFileSelected(input) {
            const file = input.files[0];
            const dropzoneText = document.getElementById('dropzone-text');
            const dropzonePreview = document.getElementById('dropzone-preview');
            const fileNameSpan = document.getElementById('file-name');

            if (file) {
                fileNameSpan.innerText = file.name;
                dropzoneText.classList.add('hidden');
                dropzonePreview.classList.remove('hidden');
                dropzonePreview.classList.add('flex');
            } else {
                dropzoneText.classList.remove('hidden');
                dropzonePreview.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Default center: Palu, Central Sulawesi
            const defaultLat = -0.8917;
            const defaultLng = 119.8707;

            const map = L.map('map-select', {
                scrollWheelZoom: false
            }).setView([defaultLat, defaultLng], 12);

            // Add OSM tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Red marker that is draggable
            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            // Update coordinate value inside input
            function updateCoordinates(lat, lng) {
                const coordStr = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                document.getElementById('maps_link').value = coordStr;
            }

            // Set coordinates to input initially
            updateCoordinates(defaultLat, defaultLng);

            // Map click handler to relocate marker and update input
            map.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                marker.setLatLng([lat, lng]);
                updateCoordinates(lat, lng);
            });

            // Marker drag handler to update input
            marker.on('dragend', function (e) {
                const pos = marker.getLatLng();
                updateCoordinates(pos.lat, pos.lng);
            });

            // Handle manual coordinate typing to synchronize marker & map view
            const inputField = document.getElementById('maps_link');
            inputField.addEventListener('input', function (e) {
                const value = e.target.value;
                const regex = /(-?\d+\.\d+)\s*,\s*(-?\d+\.\d+)/;
                const match = value.match(regex);
                if (match) {
                    const lat = parseFloat(match[1]);
                    const lng = parseFloat(match[2]);
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], map.getZoom());
                }
            });
        });
    </script>
</x-app-layout>
