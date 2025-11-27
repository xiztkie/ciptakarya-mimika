<x-app-layout :title="$title" :subtitle="$subtitle ?? ''">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <div class="px-4 md:px-6 lg:px-8 max-w-screen-2xl mx-auto">
        <div
            class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-t-xl shadow-2xl mt-20 overflow-hidden relative">
            <div class="absolute inset-0 bg-gradient-to-r from-white/5 to-transparent"></div>
            <div
                class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white/5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32">
            </div>
            <div
                class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white/5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24">
            </div>

            <div class="relative p-4 md:p-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 lg:gap-6">
                    <div class="text-white space-y-2">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-box text-sm"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-bold tracking-tight">{{ $title }}</h2>
                                <p class="text-blue-100 text-xs font-medium">
                                    Informasi lengkap paket dan dokumentasi
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('datapaket') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all backdrop-blur-sm">
                        <i class="fas fa-arrow-left text-sm"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="space-y-2">
            <div class="bg-white p-5 md:p-6 border border-gray-200/80 shadow-sm">
                <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-2">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2  ">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        <span>Informasi Paket</span>
                    </h3>
                    <div class="flex items-center gap-2">
                        <button data-modal-target="maps-modal-{{ $paket->id }}"
                            data-modal-toggle="maps-modal-{{ $paket->id }}"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md text-xs font-medium transition-all"
                            type="button">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Edit Lokasi</span>
                        </button>
                    </div>

                    <div id="maps-modal-{{ $paket->id }}" tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 min-h-screen bg-black/30 backdrop-blur-sm">
                        <div class="relative w-full max-w-2xl max-h-full">
                            <div class="relative bg-white rounded-xl shadow-sm">
                                <div class="flex items-center justify-between p-4 border-b rounded-t-xl bg-blue-600">
                                    <h3 class="text-xl font-semibold text-gray-100">
                                        Pilih Lokasi untuk Paket {{ $paket->nama_paket }}
                                    </h3>
                                    <button type="button"
                                        class="bg-transparent hover:bg-gray-100 hover:text-gray-900 text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                        data-modal-hide="maps-modal-{{ $paket->id }}">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route('updatemaps', ['id' => encrypt($paket->id)]) }}">
                                    @csrf
                                    <div class="p-4 space-y-4">
                                        <div id="map-{{ $paket->id }}" style="height: 400px; width: 100%;"
                                            data-map-initialized="false"></div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="latitude-{{ $paket->id }}"
                                                    class="block mb-2 text-sm font-medium text-gray-900">Latitude:</label>
                                                <input type="text" id="latitude-{{ $paket->id }}" name="latitude"
                                                    value="{{ $paket->latitude }}"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                            </div>
                                            <div>
                                                <label for="longitude-{{ $paket->id }}"
                                                    class="block mb-2 text-sm font-medium text-gray-900">Longitude:</label>
                                                <input type="text" id="longitude-{{ $paket->id }}"
                                                    name="longitude" value="{{ $paket->longitude }}"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b">
                                        <button type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        const leafletMaps = {};

                        function initializeLeafletMap(itemId) {
                            const mapElement = document.getElementById(`map-${itemId}`);
                            const initialLat = document.getElementById(`latitude-${itemId}`).value;
                            const initialLng = document.getElementById(`longitude-${itemId}`).value;
                            if (mapElement.getAttribute('data-map-initialized') === 'true') {
                                setTimeout(() => {
                                    if (leafletMaps[itemId]) {
                                        leafletMaps[itemId].invalidateSize();
                                    }
                                }, 200);
                                return;
                            }
                            const lat = parseFloat(initialLat) || -4.546570173730646;
                            const lng = parseFloat(initialLng) || 136.88341816893882;

                            const map = L.map(mapElement).setView([lat, lng], 13);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            const marker = L.marker([lat, lng], {
                                draggable: true
                            }).addTo(map);
                            const updateInputs = (latlng) => {
                                document.getElementById(`latitude-${itemId}`).value = latlng.lat.toFixed(7);
                                document.getElementById(`longitude-${itemId}`).value = latlng.lng.toFixed(7);
                            };

                            marker.on('dragend', function() {
                                updateInputs(marker.getLatLng());
                            });

                            map.on('click', function(e) {
                                marker.setLatLng(e.latlng);
                                updateInputs(e.latlng);
                            });

                            leafletMaps[itemId] = map;
                            mapElement.setAttribute('data-map-initialized', 'true');
                            setTimeout(() => map.invalidateSize(), 200);
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            const mapModals = document.querySelectorAll('[id^="maps-modal-"]');

                            mapModals.forEach(modal => {
                                const observer = new MutationObserver((mutationsList) => {
                                    for (const mutation of mutationsList) {
                                        if (mutation.type === 'attributes' &&
                                            mutation.attributeName === 'class' &&
                                            !modal.classList.contains('hidden')) {
                                            const itemId = modal.id.split('-')[2];
                                            initializeLeafletMap(itemId);
                                        }
                                    }
                                });
                                observer.observe(modal, {
                                    attributes: true
                                });
                            });
                        });
                    </script>
                </div>
                <div class="flex flex-col lg:flex-row gap-6">
                    <div class="w-full md:w-2/3">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-2 gap-y-2 text-sm">
                            <div class="sm:col-span-2 lg:col-span-3">
                                <dt class="font-medium text-gray-500">Nama Paket</dt>
                                <dd class="mt-1 font-semibold text-gray-900">{{ $paket->nama_paket ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Lokasi</dt>
                                <dd class="mt-1 text-gray-700">{{ $paket->detail_lokasi ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Kode RUP</dt>
                                <dd class="mt-1 text-gray-700">{{ $paket->kd_rup ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Jenis Pengadaan</dt>
                                <dd class="mt-1 text-gray-700">{{ $paket->jenis_pengadaan ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2 lg:col-span-3">
                                <dt class="font-medium text-gray-500">Sumber Dana</dt>
                                <dd class="mt-1 text-gray-700">{{ $paket->sumber_dana ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2 lg:col-span-3 border-t border-gray-200 my-2"></div>
                            <div>
                                <dt class="font-medium text-gray-500">Nomor Kontrak</dt>
                                <dd class="mt-1 font-semibold text-gray-800">{{ $paket->no_kontrak ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Nilai Kontrak</dt>
                                <dd class="mt-1 text-green-600 font-bold">
                                    {{ $paket->nilai_kontrak ? 'Rp ' . number_format($paket->nilai_kontrak, 0, ',', '.') : '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Tanggal Kontrak</dt>
                                <dd class="mt-1 text-gray-700">
                                    {{ $paket->tgl_kontrak ? \Carbon\Carbon::parse($paket->tgl_kontrak)->isoFormat('D MMMM Y') : '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Nilai Penawaran</dt>
                                <dd class="mt-1 text-gray-700">
                                    {{ $paket->nilai_penawaran ? 'Rp ' . number_format($paket->nilai_penawaran, 0, ',', '.') : '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Waktu Pelaksanaan</dt>
                                <dd class="mt-1 text-gray-700">
                                    {{ $paket->waktu_pelaksanaan ? $paket->waktu_pelaksanaan . ' Hari' : '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2 lg:col-span-3 border-t border-gray-200 my-2"></div>
                            <div>
                                <dt class="font-medium text-gray-500">Nama Penyedia</dt>
                                <dd class="mt-1 font-semibold text-gray-800">{{ $paket->nama_penyedia ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Wakil Sah</dt>
                                <dd class="mt-1 text-gray-700">{{ $paket->wakil_sah_penyedia ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">NPWP</dt>
                                <dd class="mt-1 text-gray-700">{{ $paket->npwp_penyedia ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Kode Penyedia</dt>
                                <dd class="mt-1 text-gray-700">{{ $paket->kd_penyedia ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">OAP Status</dt>
                                <dd class="mt-1">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md {{ $paket->oap ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $paket->oap ? 'Orang Asli Papua' : 'Bukan OAP' }}
                                    </span>
                                </dd>
                            </div>
                            <div class="lg:col-span-3 border-t border-gray-200 my-2"></div>
                            <div class="lg:col-span-3 flex justify-end mt-2 mb-2">
                                <button type="button"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg text-xs font-semibold shadow hover:brightness-110 transition"
                                    data-modal-target="edit-kategori-modal" data-modal-toggle="edit-kategori-modal">
                                    <i class="fas fa-edit"></i>
                                    Edit Kategori / Jenis / Umur
                                </button>
                            </div>
                            <div
                                class="lg:col-span-1 bg-blue-50 border border-blue-100 rounded-xl p-4 flex flex-col items-start mb-2">
                                <dt class="font-medium text-blue-700 flex items-center gap-2">
                                    <i class="fas fa-tags"></i>
                                    Kategori
                                </dt>
                                <dd class="mt-1 text-blue-900 font-semibold">{{ $paket->kategori ?? '-' }}</dd>
                            </div>
                            <div
                                class="lg:col-span-1 bg-cyan-50 border border-cyan-100 rounded-xl p-4 flex flex-col items-start mb-2">
                                <dt class="font-medium text-cyan-700 flex items-center gap-2">
                                    <i class="fas fa-list"></i>
                                    Jenis
                                </dt>
                                <dd class="mt-1 text-cyan-900 font-semibold">{{ $paket->jenis ?? '-' }}</dd>
                            </div>
                            <div
                                class="lg:col-span-1 bg-teal-50 border border-teal-100 rounded-xl p-4 flex flex-col items-start mb-2">
                                <dt class="font-medium text-teal-700 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    Umur
                                </dt>
                                <dd class="mt-1 text-teal-900 font-semibold">
                                    @if ($paket->umur)
                                        @php
                                            $umurDate = \Carbon\Carbon::parse($paket->umur);
                                            $now = \Carbon\Carbon::now();
                                            $diff = $umurDate->diff($now);
                                            $years = $diff->y;
                                            $months = $diff->m;
                                            $days = $diff->d;
                                        @endphp
                                        {{ $years > 0 ? $years . ' tahun ' : '' }}{{ $months > 0 ? $months . ' bulan ' : '' }}{{ $days > 0 ? $days . ' hari' : '' }}
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                            <div class="lg:col-span-3 mb-2">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-start gap-3">
                                    <span
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-cyan-600 text-white shadow">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                    <div>
                                        <dt class="font-medium text-slate-700 mb-1">Keterangan</dt>
                                        <dd class="text-xs text-slate-600">
                                            {{ $paket->keterangan ?? 'Tidak ada keterangan.' }}</dd>
                                    </div>
                                </div>
                            </div>

                        </dl>
                    </div>


                    <div class="w-full h-100 md:h-auto md:w-1/3 flex items-center justify-center bg-gray-100 border border-gray-200 p-4 rounded-lg z-20"
                        id="map">
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                let lat, lng, zoom, popupContent;

                                @if ($paket->latitude && $paket->longitude)
                                    lat = {{ $paket->latitude }};
                                    lng = {{ $paket->longitude }};
                                    zoom = 15;
                                    popupContent = '<b>{{ Str::limit($paket->nama_paket, 30) }}</b>';
                                @else
                                    lat = -4.63;
                                    lng = 136.88;
                                    zoom = 13;
                                    popupContent = '<b>Pusat Kota Mimika</b><br>Lokasi paket tidak spesifik.';
                                @endif

                                var map = L.map('map').setView([lat, lng], zoom);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                L.marker([lat, lng]).addTo(map)
                                    .bindPopup(popupContent)
                                    .openPopup();
                            });
                        </script>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
                        <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-500"></div>

                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <span
                                        class="absolute inset-0 rounded-xl bg-gradient-to-tr from-blue-500/10 to-cyan-500/10 blur-md"></span>
                                    <span
                                        class="relative inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-cyan-600 text-white shadow-sm">
                                        <i class="fas fa-camera-retro text-sm"></i>
                                    </span>
                                </div>
                                <div>
                                    <h2 class="text-base font-semibold text-slate-900">Dokumentasi Paket</h2>
                                    <p class="text-xs text-slate-500">Foto dokumentasi kegiatan paket</p>
                                </div>
                            </div>

                            <button type="button" data-modal-target="add-documentation-modal"
                                data-modal-toggle="add-documentation-modal"
                                class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-sm hover:shadow-md hover:brightness-110 active:brightness-95 transition">
                                <i class="fas fa-plus"></i>
                                Tambah Dokumentasi
                            </button>
                        </div>

                        <div class="px-6 pb-6">
                            @if ($dokumentasi && $dokumentasi->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach ($dokumentasi as $index => $doc)
                                        <div class="relative group rounded-lg overflow-hidden border-2 border-slate-200 hover:border-blue-500 transition cursor-pointer"
                                            onclick="openSlideshow({{ $index }})">
                                            <img src="{{ asset($doc->file_path) }}" class="w-full h-32 object-cover"
                                                alt="Dokumentasi {{ $paket->nama_paket }}">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition">
                                                <div class="absolute top-2 right-2">
                                                    <button type="button"
                                                        onclick="event.stopPropagation(); openDeleteModal('{{ $doc->id }}')"
                                                        class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-red-600 text-white hover:bg-red-700 shadow-sm transition"
                                                        title="Hapus Dokumentasi">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </div>
                                                <div class="absolute bottom-2 left-2 right-2">
                                                    <p class="text-white text-xs bg-black/50 rounded-md px-2 py-1">
                                                        {{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-slate-400 text-sm py-8">
                                    <i class="fas fa-image text-4xl text-slate-300 mb-3 block"></i>
                                    <h3 class="text-lg font-semibold text-slate-600 mb-1">Belum Ada Dokumentasi</h3>
                                    <p class="text-slate-500">Silakan tambahkan gambar dokumentasi untuk paket ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Kategori/Jenis/Umur -->
                <div id="edit-kategori-modal" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full bg-black/30 backdrop-blur-sm">
                    <div class="relative w-full max-w-2xl mx-auto h-full flex items-center">
                        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-h-[90vh] overflow-hidden">
                            <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-500"></div>
                            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-cyan-600 text-white shadow-sm">
                                        <i class="fas fa-tags text-lg"></i>
                                    </span>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900">Edit Kategori, Jenis, dan Umur
                                        </h3>
                                        <p class="text-xs text-slate-500">Ubah data kategori, jenis, umur, dan
                                            keterangan paket</p>
                                    </div>
                                </div>
                                <button type="button"
                                    class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm p-2 inline-flex items-center transition"
                                    data-modal-hide="edit-kategori-modal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <form method="POST"
                                action="{{ route('editpaketdetail', ['id' => encrypt($paket->id)]) }}"
                                class="px-6 py-6 space-y-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                                @csrf
                                <div>
                                    <label for="kategori"
                                        class="block mb-2 text-sm font-semibold text-slate-700">Kategori</label>
                                    <select id="kategori" name="kategori"
                                        class="mt-1 block w-full rounded-lg border border-blue-200 bg-blue-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition">
                                        <option value="">Pilih Kategori Bangunan</option>
                                        <option value="Bangunan Hunian"
                                            {{ $paket->kategori == 'Bangunan Hunian' ? 'selected' : '' }}>Bangunan
                                            Hunian</option>
                                        <option value="Bangunan Keagamaan"
                                            {{ $paket->kategori == 'Bangunan Keagamaan' ? 'selected' : '' }}>Bangunan
                                            Keagamaan</option>
                                        <option value="Bangunan Usaha (Komersial)"
                                            {{ $paket->kategori == 'Bangunan Usaha (Komersial)' ? 'selected' : '' }}>
                                            Bangunan Usaha (Komersial)</option>
                                        <option value="Bangunan Sosial dan Budaya"
                                            {{ $paket->kategori == 'Bangunan Sosial dan Budaya' ? 'selected' : '' }}>
                                            Bangunan Sosial dan Budaya</option>
                                        <option value="Bangunan Khusus"
                                            {{ $paket->kategori == 'Bangunan Khusus' ? 'selected' : '' }}>Bangunan
                                            Khusus</option>
                                        <option value="Bangunan Negara / Pemerintah"
                                            {{ $paket->kategori == 'Bangunan Negara / Pemerintah' ? 'selected' : '' }}>
                                            Bangunan Negara / Pemerintah</option>
                                        <option value="Bangunan Industri"
                                            {{ $paket->kategori == 'Bangunan Industri' ? 'selected' : '' }}>Bangunan
                                            Industri</option>
                                        <option value="Bangunan Pertanian / Perkebunan"
                                            {{ $paket->kategori == 'Bangunan Pertanian / Perkebunan' ? 'selected' : '' }}>
                                            Bangunan Pertanian / Perkebunan</option>
                                        <option value="Bangunan Transportasi"
                                            {{ $paket->kategori == 'Bangunan Transportasi' ? 'selected' : '' }}>
                                            Bangunan Transportasi</option>
                                        <option value="Bangunan Utilitas Umum"
                                            {{ $paket->kategori == 'Bangunan Utilitas Umum' ? 'selected' : '' }}>
                                            Bangunan Utilitas Umum</option>
                                        <option value="Jalan Nasional"
                                            {{ $paket->kategori == 'Jalan Nasional' ? 'selected' : '' }}>Jalan Nasional</option>
                                        <option value="Jalan Provinsi"
                                            {{ $paket->kategori == 'Jalan Provinsi' ? 'selected' : '' }}>Jalan Provinsi</option>
                                        <option value="Jalan Kabupaten/Kota"
                                            {{ $paket->kategori == 'Jalan Kabupaten/Kota' ? 'selected' : '' }}>Jalan Kabupaten/Kota</option>
                                        <option value="Jalan Desa"
                                            {{ $paket->kategori == 'Jalan Desa' ? 'selected' : '' }}>Jalan Desa</option>
                                    </select>
                                </div>
                                <div id="jenis-container">
                                    <label for="jenis"
                                        class="block mb-2 text-sm font-semibold text-slate-700">Jenis</label>
                                    <select id="jenis" name="jenis"
                                        class="mt-1 block w-full rounded-lg border border-cyan-200 bg-cyan-50 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm transition">
                                        <option value="">Pilih Jenis Bangunan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="umur"
                                        class="block mb-2 text-sm font-semibold text-slate-700">Umur</label>
                                    <input type="date" id="umur" name="umur" value="{{ $paket->umur }}"
                                        class="mt-1 block w-full rounded-lg border border-teal-200 bg-teal-50 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm transition">
                                </div>
                                <div>
                                    <label for="keterangan"
                                        class="block mb-2 text-sm font-semibold text-slate-700">Keterangan</label>
                                    <div class="relative">
                                        <textarea id="keterangan" name="keterangan" rows="3"
                                            class="mt-1 block w-full rounded-xl border border-blue-200 bg-blue-50 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-300 text-sm resize-none transition duration-150 ease-in-out px-4 py-3 placeholder:text-blue-400"
                                            placeholder="Tulis keterangan paket di sini...">{{ $paket->keterangan }}</textarea>
                                        <span
                                            class="absolute right-3 bottom-3 text-xs text-blue-400 select-none pointer-events-none">
                                            <i class="fas fa-pencil-alt mr-1"></i>Keterangan
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-end items-center pt-4 border-t border-slate-200 gap-2">
                                    <button type="button" data-modal-hide="edit-kategori-modal"
                                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white hover:brightness-110 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                </div>
                            </form>
                            <script>
                                const jenisOptions = {
                                    "Bangunan Hunian": [
                                        "Rumah tinggal", "Rumah susun", "Apartemen", "Asrama", "Pondok pesantren"
                                    ],
                                    "Bangunan Keagamaan": [
                                        "Masjid", "Gereja", "Pura", "Vihara", "Kelenteng"
                                    ],
                                    "Bangunan Usaha (Komersial)": [
                                        "Pertokoan", "Pasar", "Hotel", "Restoran", "Ruko", "Gedung perkantoran swasta", "SPBU"
                                    ],
                                    "Bangunan Sosial dan Budaya": [
                                        "Sekolah", "Kampus", "Rumah sakit", "Panti asuhan", "Museum", "Balai pertemuan", "Perpustakaan"
                                    ],
                                    "Bangunan Khusus": [
                                        "Menara telekomunikasi", "Gardu listrik", "Tangki air", "Terminal", "Bandara", "Jembatan layang"
                                    ],
                                    "Bangunan Negara / Pemerintah": [
                                        "Kantor dinas", "Balai kota", "Kantor camat", "Gedung DPRD", "Kantor kelurahan/desa"
                                    ],
                                    "Bangunan Industri": [
                                        "Pabrik", "Gudang", "Bengkel", "Workshop", "Depo logistik"
                                    ],
                                    "Bangunan Pertanian / Perkebunan": [
                                        "Lumbung", "Kandang", "Rumah kaca", "Gudang pupuk", "Bangsal pengering"
                                    ],
                                    "Bangunan Transportasi": [
                                        "Terminal", "Stasiun", "Pelabuhan", "Bandara", "Garasi bus", "Jembatan timbang"
                                    ],
                                    "Bangunan Utilitas Umum": [
                                        "IPA (Instalasi Pengolahan Air)", "IPAL", "PLTA", "PLTD", "Menara air", "TPS", "TPA"
                                    ]
                                };

                                const kategoriJalan = [
                                    "Jalan Nasional",
                                    "Jalan Provinsi",
                                    "Jalan Kabupaten/Kota",
                                    "Jalan Desa"
                                ];

                                function updateJenisOptions() {
                                    const kategoriSelect = document.getElementById('kategori');
                                    const jenisSelect = document.getElementById('jenis');
                                    const jenisContainer = document.getElementById('jenis-container');
                                    const selectedKategori = kategoriSelect.value;

                                    // Hide jenis if kategori jalan
                                    if (kategoriJalan.includes(selectedKategori)) {
                                        jenisContainer.style.display = 'none';
                                        jenisSelect.value = '';
                                    } else {
                                        jenisContainer.style.display = '';
                                        jenisSelect.innerHTML = '<option value="">Pilih Jenis Bangunan</option>';
                                        if (jenisOptions[selectedKategori]) {
                                            jenisOptions[selectedKategori].forEach(jenis => {
                                                const option = document.createElement('option');
                                                option.value = jenis;
                                                option.textContent = jenis;
                                                @if ($paket->jenis)
                                                    if (jenis === @json($paket->jenis)) {
                                                        option.selected = true;
                                                    }
                                                @endif
                                                jenisSelect.appendChild(option);
                                            });
                                        }
                                    }
                                }

                                document.getElementById('kategori').addEventListener('change', updateJenisOptions);
                                document.addEventListener('DOMContentLoaded', function() {
                                    updateJenisOptions();
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <!-- Add Documentation Modal -->
                <div id="add-documentation-modal" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full bg-black/30 backdrop-blur-sm">
                    <div class="relative w-full max-w-3xl mx-auto h-full flex items-center">
                        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-h-[90vh] overflow-hidden">
                            <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-500"></div>
                            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-cyan-600 text-white shadow-sm">
                                        <i class="fas fa-images text-sm"></i>
                                    </span>
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900">Tambah Dokumentasi Baru</h3>
                                        <p class="text-xs text-slate-500">Upload gambar dokumentasi paket</p>
                                    </div>
                                </div>
                                <button type="button"
                                    class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm p-2 inline-flex items-center transition"
                                    data-modal-hide="add-documentation-modal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>

                            <form action="{{ route('adddokumentasi', ['id' => encrypt($paket->id)]) }}"
                                method="POST" enctype="multipart/form-data"
                                class="px-6 py-6 space-y-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                                @csrf
                                <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                                <div>
                                    <label class="block mb-3 text-sm font-semibold text-slate-700">Upload
                                        Gambar</label>
                                    <div class="relative">
                                        <input type="file" name="files[]" id="file-upload" accept="image/*"
                                            multiple required class="hidden">
                                        <label for="file-upload"
                                            class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition group">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i
                                                    class="fas fa-cloud-upload-alt text-4xl text-slate-400 group-hover:text-blue-500 transition mb-3"></i>
                                                <p class="mb-1 text-sm text-slate-600 font-medium">
                                                    <span class="text-blue-600">Klik untuk upload</span> atau drag &
                                                    drop
                                                </p>
                                                <p class="text-xs text-slate-500">JPG, JPEG, PNG (Max. 5MB per file)
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div id="preview-container" class="hidden">
                                    <label class="block mb-3 text-sm font-semibold text-slate-700">Preview
                                        Gambar</label>
                                    <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-4 border-t border-slate-200">
                                    <p id="file-count" class="text-sm text-slate-600">
                                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                        <span class="font-medium">0 gambar dipilih</span>
                                    </p>
                                    <div class="flex gap-2">
                                        <button type="button" data-modal-hide="add-documentation-modal"
                                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                            Batal
                                        </button>
                                        <button type="submit" id="submit-btn" disabled
                                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white hover:brightness-110 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                            <i class="fas fa-upload mr-2"></i>Simpan Dokumentasi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="modal-delete-dokumentasi" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full bg-black/30 backdrop-blur-sm">
                    <div class="relative w-full max-w-md mx-auto h-full flex items-center">
                        <div class="relative bg-white rounded-2xl shadow-2xl w-full">
                            <div class="h-1 w-full bg-gradient-to-r from-red-600 to-rose-600"></div>
                            <div class="p-6 text-center">
                                <div
                                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                                </div>
                                <h3 class="mb-2 text-lg font-semibold text-slate-900">Hapus Dokumentasi?</h3>
                                <p class="mb-6 text-sm text-slate-500">Dokumentasi yang dihapus tidak dapat
                                    dikembalikan.</p>
                                <form id="delete-form" method="POST">
                                    @csrf
                                    <div class="flex gap-3 justify-center">
                                        <button type="button" onclick="closeDeleteModal()"
                                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-red-600 to-rose-600 text-white hover:brightness-110 transition">
                                            <i class="fas fa-trash-alt mr-2"></i>Ya, Hapus
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slideshow Modal -->
                <div id="modal-slideshow" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full bg-black/50 backdrop-blur-sm">
                    <div class="relative w-full h-full flex items-center justify-center p-4">
                        <button type="button" onclick="closeSlideshow()"
                            class="absolute top-4 right-4 text-white hover:text-slate-300 transition z-10">
                            <i class="fas fa-times text-3xl"></i>
                        </button>

                        <button type="button" onclick="prevSlide()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-slate-300 transition z-10">
                            <i class="fas fa-chevron-left text-4xl"></i>
                        </button>

                        <div class="max-w-5xl max-h-full w-full h-full flex items-center justify-center">
                            <img id="slideshow-image" src=""
                                class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                        </div>

                        <button type="button" onclick="nextSlide()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-slate-300 transition z-10">
                            <i class="fas fa-chevron-right text-4xl"></i>
                        </button>

                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white text-sm">
                            <span id="slide-counter"></span>
                        </div>
                    </div>
                </div>

                <script>
                    const dokumentasiImages = @json($dokumentasi->map(fn($doc) => asset($doc->file_path))->toArray());
                    let currentSlide = 0;

                    function openDeleteModal(docId) {
                        const form = document.getElementById('delete-form');
                        const encryptedIds = @json($dokumentasi->pluck('id')->mapWithKeys(fn($id) => [$id => encrypt($id)]));
                        form.action = "{{ route('deletedokumentasi', ['id' => 'DOC_ID_PLACEHOLDER']) }}".replace('DOC_ID_PLACEHOLDER',
                            encryptedIds[docId]);
                        document.getElementById('modal-delete-dokumentasi').classList.remove('hidden');
                    }

                    function closeDeleteModal() {
                        document.getElementById('modal-delete-dokumentasi').classList.add('hidden');
                    }

                    function openSlideshow(index) {
                        currentSlide = index;
                        updateSlideshow();
                        document.getElementById('modal-slideshow').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeSlideshow() {
                        document.getElementById('modal-slideshow').classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }

                    function prevSlide() {
                        currentSlide = (currentSlide - 1 + dokumentasiImages.length) % dokumentasiImages.length;
                        updateSlideshow();
                    }

                    function nextSlide() {
                        currentSlide = (currentSlide + 1) % dokumentasiImages.length;
                        updateSlideshow();
                    }

                    function updateSlideshow() {
                        document.getElementById('slideshow-image').src = dokumentasiImages[currentSlide];
                        document.getElementById('slide-counter').textContent = `${currentSlide + 1} / ${dokumentasiImages.length}`;
                    }

                    // Keyboard navigation for slideshow
                    document.addEventListener('keydown', function(e) {
                        const slideshow = document.getElementById('modal-slideshow');
                        if (!slideshow.classList.contains('hidden')) {
                            if (e.key === 'ArrowLeft') prevSlide();
                            if (e.key === 'ArrowRight') nextSlide();
                            if (e.key === 'Escape') closeSlideshow();
                        }
                    });

                    // File upload preview functionality
                    const fileInput = document.getElementById('file-upload');
                    const previewContainer = document.getElementById('preview-container');
                    const previewGrid = document.getElementById('preview-grid');
                    const fileCount = document.getElementById('file-count');
                    const submitBtn = document.getElementById('submit-btn');

                    fileInput.addEventListener('change', function(e) {
                        const files = Array.from(e.target.files);
                        previewGrid.innerHTML = '';

                        if (files.length > 0) {
                            previewContainer.classList.remove('hidden');
                            submitBtn.disabled = false;
                            fileCount.innerHTML =
                                `<i class="fas fa-check-circle text-green-500 mr-1"></i><span class="font-medium">${files.length} gambar dipilih</span>`;

                            files.forEach((file, index) => {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const previewItem = document.createElement('div');
                                    previewItem.className =
                                        'relative group rounded-lg overflow-hidden border-2 border-slate-200 hover:border-blue-500 transition';
                                    previewItem.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition">
                            <div class="absolute bottom-2 left-2 right-2">
                                <p class="text-white text-xs font-medium truncate">${file.name}</p>
                                <p class="text-white/80 text-xs">${(file.size / 1024).toFixed(1)} KB</p>
                            </div>
                        </div>
                    `;
                                    previewGrid.appendChild(previewItem);
                                };
                                reader.readAsDataURL(file);
                            });
                        } else {
                            previewContainer.classList.add('hidden');
                            submitBtn.disabled = true;
                            fileCount.innerHTML =
                                '<i class="fas fa-info-circle text-blue-500 mr-1"></i><span class="font-medium">0 gambar dipilih</span>';
                        }
                    });
                </script>
            </div>
        </div>
    </div>

</x-app-layout>
