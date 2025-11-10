<x-app-layout :title="$title" :subtitle="$subtitle ?? ''">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="px-4 md:px-6 lg:px-8 max-w-screen-2xl mx-auto mt-20">
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10 mb-4 rounded-2xl border border-gray-200 bg-white/70 backdrop-blur-sm p-6 shadow-sm p-4">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Peta Sebaran Paket</h2>
                <p class="text-xs text-gray-600 mt-1">Visualisasi lokasi proyek dalam peta interaktif</p>
            </div>
            <form method="GET" action="{{ route('peta-paket') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <select name="tahun_anggaran" id="tahun_anggaran"
                        class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm text-sm">
                        <option value="">Pilih Tahun Anggaran</option>
                        @foreach ($tahunanggaran as $opt)
                            <option value="{{ $opt->tahun_anggaran }}"
                                {{ request('tahun_anggaran') == $opt->tahun_anggaran ? 'selected' : '' }}>
                                {{ $opt->tahun_anggaran }}
                            </option>
                        @endforeach
                    </select>
                  
                </div>
                <div class="relative">
                    <select name="bidang" id="bidang"
                        class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm text-sm">
                        <option value="">Pilih Bidang</option>
                        @foreach ($bidang as $opt)
                            <option value="{{ $opt->nama_bidang }}"
                                {{ request('bidang') == $opt->nama_bidang ? 'selected' : '' }}>
                                {{ $opt->nama_bidang }}
                            </option>
                        @endforeach
                    </select>
                   
                </div>
                <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-3 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
                @if (request()->hasAny(['tahun_anggaran', 'bidang']))
                    <a href="{{ route('peta-paket') }}"
                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md text-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="floating-card">
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 p-6 rounded-3xl shadow-2xl border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div
                            class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2
                                class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                Peta Sebaran Paket
                            </h2>
                            <p class="text-sm text-gray-500 font-medium">Visualisasi lokasi proyek dalam peta interaktif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                            {{ count($paket) }} Paket
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                            Real-time
                        </span>
                    </div>
                </div>

                <div class="map-container bg-gradient-to-br from-blue-50 to-indigo-100 p-4 min-h-screen relative z-10"
                    id="petapaket">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-transparent via-white/5 to-transparent pointer-events-none">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $paketForMap = collect($paket)->map(function ($p) {
            return [
                'id' => $p->id ?? null,
                'paket_id' => $p->paket_id ?? null,
                'nama_paket' => $p->nama_paket ?? '-',
                'latitude' => $p->latitude ?? null,
                'longitude' => $p->longitude ?? null,
                'tahun_anggaran' => $p->tahun_anggaran ?? '-',
                'bidang' => $p->bidang ?? '-',
                'nama_penyedia' => $p->nama_penyedia ?? null,
                'nilai_kontrak' => $p->nilai_kontrak ?? null,
                'detail_url' => route('detailpaket', ['id' => encrypt($p->paket_id)]),
            ];
        });
    @endphp
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('petapaket', {
                zoomControl: true,
                scrollWheelZoom: true,
                doubleClickZoom: true,
                dragging: true,
                zoomAnimation: true,
                fadeAnimation: true,
                markerZoomAnimation: true
            }).setView([-4.55, 136.89], 10);

            var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            });
            var satellite = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '&copy; Esri'
                });
            var dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CartoDB'
            });
            osm.addTo(map);

            var baseMaps = {
                "🗺️ OpenStreetMap": osm,
                "🛰️ Satelit": satellite,
                "🌙 Dark Mode": dark
            };
            L.control.layers(baseMaps).addTo(map);

            var customIcon = L.divIcon({
                className: 'custom-marker',
                html: `
            <div style="
                width: 30px;
                height: 30px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: 3px solid white;
                border-radius: 50%;
                box-shadow: 0 4px 15px rgba(0,0,0,0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                animation: bounce 2s infinite;
            ">
                <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
        `,
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            var paketData = @json($paketForMap);
            var markers = [];

            paketData.forEach(function(item) {
                if (item.latitude && item.longitude) {
                    var marker = L.marker([item.latitude, item.longitude], {
                        icon: customIcon
                    }).addTo(map);

                    var popupContent = `
                <a href="${item.detail_url}" class="popup-card-link" aria-label="Lihat detail paket ${item.nama_paket}" target="_blank" rel="noopener noreferrer">
                    <div class="popup-card">
                        <div class="popup-card__header">
                            <h3 class="popup-card__title">${item.nama_paket}</h3>
                            <div class="popup-card__id">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                </svg>
                                ID: ${item.id ?? '-'}
                            </div>
                        </div>

                        <div class="popup-card__body">
                            <div class="popup-row">
                                <div class="popup-icon popup-icon--blue">
                                    <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                                        <path d="M9 11H7v8h2v-8zm4 0h-2v8h2v-8zm4 0h-2v8h2v-8zm2-7v2H3V4h4V2h10v2h4zm-2 4H5v16h14V8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="popup-label">Tahun Anggaran</div>
                                    <div class="popup-value">${item.tahun_anggaran ?? '-'}</div>
                                </div>
                            </div>

                            <div class="popup-row">
                                <div class="popup-icon popup-icon--green">
                                    <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="popup-label">Bidang</div>
                                    <div class="popup-value">${item.bidang || '-'}</div>
                                </div>
                            </div>

                            <div class="popup-row">
                                <div class="popup-icon popup-icon--purple">
                                    <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="popup-label">Penyedia</div>
                                    <div class="popup-value">${item.nama_penyedia || 'Belum Ditentukan'}</div>
                                </div>
                            </div>

                            <div class="popup-row">
                                <div class="popup-icon popup-icon--amber">
                                    <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="popup-label">Nilai Kontrak</div>
                                    <div class="popup-value">${item.nilai_kontrak ? 'Rp ' + new Intl.NumberFormat('id-ID').format(item.nilai_kontrak) : 'Belum Ditentukan'}</div>
                                </div>
                            </div>
                        </div>

                        <div class="popup-card__footer">
                            <span>Lihat detail</span>
                            <svg class="chevron" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </a>
            `;

                    marker.bindPopup(popupContent, {
                        maxWidth: 320,
                        className: 'custom-popup'
                    });

                    // Opsional: double-click marker langsung ke detail tanpa buka popup
                    marker.on('dblclick', function() {
                        if (item.detail_url) window.location.href = item.detail_url;
                    });

                    markers.push(marker);
                }
            });

            if (markers.length > 0) {
                var group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }

            // Styles
            var style = document.createElement('style');
            style.textContent = `
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% { transform: translate3d(0,0,0); }
            40%, 43% { transform: translate3d(0, -8px, 0); }
            70% { transform: translate3d(0, -4px, 0); }
            90% { transform: translate3d(0, -2px, 0); }
        }

        .custom-popup .leaflet-popup-content-wrapper {
            border-radius: 18px !important;
            padding: 0 !important;
            overflow: hidden;
            box-shadow: 0 18px 40px -10px rgba(0, 0, 0, 0.35) !important;
            border: 1px solid rgba(102, 126, 234, 0.25);
        }
        .custom-popup .leaflet-popup-content {
            margin: 0 !important;
        }
        .custom-popup .leaflet-popup-tip {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            box-shadow: none !important;
        }

        .popup-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            outline: none;
        }
        .popup-card {
            background: white;
            display: grid;
            grid-template-rows: auto 1fr auto;
            min-width: 300px;
            max-width: 320px;
            border-radius: 18px;
            overflow: hidden;
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .popup-card-link:hover .popup-card,
        .popup-card-link:focus-visible .popup-card {
            transform: translateY(-1px);
            box-shadow: 0 22px 45px -12px rgba(102, 126, 234, 0.45);
        }

        .popup-card__header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 16px 16px 14px 16px;
            color: white;
        }
        .popup-card__title {
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.3;
            letter-spacing: .2px;
        }
        .popup-card__id {
            display: flex;
            align-items: center;
            font-size: 12px;
            opacity: .95;
            gap: 6px;
        }

        .popup-card__body {
            padding: 14px 16px;
            color: #111827;
            background: #fff;
        }
        .popup-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
        }
        .popup-row + .popup-row {
            border-top: 1px dashed #E5E7EB;
        }
        .popup-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .popup-icon--blue { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
        .popup-icon--green { background: linear-gradient(135deg, #10B981, #047857); }
        .popup-icon--purple { background: linear-gradient(135deg, #8B5CF6, #5B21B6); }
        .popup-icon--amber { background: linear-gradient(135deg, #F59E0B, #D97706); }

        .popup-label {
            font-size: 12px;
            color: #6B7280;
            font-weight: 600;
            letter-spacing: .2px;
        }
        .popup-value {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }

        .popup-card__footer {
            background: #F9FAFB;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-top: 1px solid #EEF2FF;
            color: #4F46E5;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .popup-card__footer .chevron {
            transition: transform .15s ease;
        }
        .popup-card-link:hover .popup-card__footer .chevron,
        .popup-card-link:focus-visible .popup-card__footer .chevron {
            transform: translateX(3px);
        }

        .leaflet-control-layers {
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }
        .leaflet-control-zoom {
            border-radius: 12px !important;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }
        .leaflet-control-zoom a {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border: none !important;
            font-weight: bold !important;
            transition: all 0.3s ease !important;
        }
        .leaflet-control-zoom a:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%) !important;
            transform: scale(1.05) !important;
        }
    `;
            document.head.appendChild(style);
        });
    </script>
</x-app-layout>
