@extends('layouts.app')

@section('title', 'Pilih Laundry Terdekat')

@php
    use Illuminate\Support\Str;
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
    }
    .accordion-content.active {
        max-height: 1000px;
    }
    .accordion-toggle svg {
        transition: transform 0.3s ease;
    }
    .accordion-toggle.active svg {
        transform: rotate(180deg);
    }
    .laundry-card {
        background: linear-gradient(135deg, #f0fdfa, #e0f2fe);
        border: 1px solid #99ebeb;
        border-radius: 0.5rem;
        padding: 0.75rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .laundry-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    .distance-tag {
        transition: background-color 0.3s ease;
    }
    .distance-tag.near {
        background-color: #10b981;
    }
    .distance-tag.far {
        background-color: #ef4444;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 bg-gradient-to-br from-teal-50 to-blue-100">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-blue-800 mb-2">Pilih Laundry Terdekat</h1>
        <p class="text-gray-700 text-lg">Temukan toko laundry terdekat dari lokasi Anda dengan mudah!</p>
        <button onclick="findNearbyLaundry()" class="mt-4 bg-teal-500 hover:bg-teal-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-300 flex items-center gap-2 mx-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Cari Laundry Terdekat
        </button>
    </div>

    <div id="laundry-list" class="space-y-3">
        @php
            $kecamatan_laundry = [
                'Indramayu' => [
                    ['id' => 1, 'nama' => "Kilo's Laundry", 'alamat' => 'Jl. Jend. Sudirman, Indramayu', 'gambar' => 'kilos.jpg', 'lat' => -6.3271, 'lng' => 108.3245],
                    ['id' => 2, 'nama' => 'Tomodachi Laundry', 'alamat' => 'Jl. Jend. Sudirman No.144, Lemahmekar, Indramayu', 'gambar' => 'tomodachi.jpg', 'lat' => -6.3282, 'lng' => 108.3231],
                    ['id' => 3, 'nama' => 'Omeh Laundry', 'alamat' => 'Wisma An Nur, Karangmalang, Indramayu', 'gambar' => 'omeh.jpg', 'lat' => -6.3290, 'lng' => 108.3258],
                ],
                'Sindang' => [
                    ['id' => 4, 'nama' => 'Bebasuh Coin Laundry', 'alamat' => 'Jl. Dharma Ayu, Sindang', 'gambar' => 'bebasuh.jpg', 'lat' => -6.3341, 'lng' => 108.3378],
                    ['id' => 5, 'nama' => 'Kino Laundry', 'alamat' => 'Jl. Cimanuk Barat No.32, Sindang', 'gambar' => 'kino.jpg', 'lat' => -6.3330, 'lng' => 108.3390],
                    ['id' => 6, 'nama' => "Kilo's Laundry", 'alamat' => 'Jl. Cimanuk Barat No.2, Sindang', 'gambar' => 'kilos_sindang.jpg', 'lat' => -6.3325, 'lng' => 108.3385],
                    ['id' => 7, 'nama' => 'Shayn Laundry', 'alamat' => 'Jl. Wirapati, dekat STIKES Indramayu, Sindang', 'gambar' => 'shayn.jpg', 'lat' => -6.3345, 'lng' => 108.3362],
                ],
                'Lohbener' => [
                    ['id' => 8, 'nama' => 'Laundry Ibu Ilah', 'alamat' => 'Blok Cangkring, Lohbener', 'gambar' => 'ibu_ilah.jpg', 'lat' => -6.3132, 'lng' => 108.3101],
                    ['id' => 9, 'nama' => 'Amanah Laundry', 'alamat' => 'Rambatan Kulon, Lohbener', 'gambar' => 'amanah.jpg', 'lat' => -6.3141, 'lng' => 108.3112],
                    ['id' => 10, 'nama' => 'Awan Laundry', 'alamat' => 'Jl. Raya Lohbener', 'gambar' => 'awan.jpg', 'lat' => -6.3153, 'lng' => 108.3120],
                ],
            ];
        @endphp

        @foreach ($kecamatan_laundry as $kecamatan => $list)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <button class="accordion-toggle w-full flex justify-between items-center p-4 bg-teal-100 hover:bg-teal-200 transition-colors text-left">
                    <h3 class="text-lg font-semibold text-blue-800">Kecamatan {{ $kecamatan }}</h3>
                    <svg class="w-5 h-5 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="accordion-content">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4 bg-teal-50">
                        @foreach ($list as $laundry)
                            <div class="laundry-card" data-id="{{ $laundry['id'] }}" data-lat="{{ $laundry['lat'] }}" data-lng="{{ $laundry['lng'] }}">
                                <img src="{{ asset('images/' . $laundry['gambar']) }}" alt="{{ $laundry['nama'] }}" class="w-12 h-12 object-cover rounded-full mx-auto mb-2" />
                                <h2 class="text-sm font-semibold text-blue-800 mb-1">{{ $laundry['nama'] }}</h2>
                                <p class="text-xs text-gray-700 mb-1 line-clamp-2">{{ $laundry['alamat'] }}</p>
                                <div class="flex justify-between items-center">
                                    <span id="distance-{{ $laundry['id'] }}" class="distance-tag text-xs font-medium px-2 py-1 rounded-full text-white hidden"></span>
                                    <a href="{{ url('/pelanggan/layanan/' . Str::slug($laundry['nama'], '-')) }}" class="bg-teal-500 text-white px-2 py-1 rounded-md text-xs hover:bg-teal-600 transition-all">
                                        Lihat Layanan
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    function findNearbyLaundry() {
        if (!navigator.geolocation) {
            alert("Browser Anda tidak mendukung geolokasi.");
            return;
        }

        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            const cards = document.querySelectorAll(".laundry-card");

            let nearbyCards = [];

            cards.forEach(card => {
                const lat = parseFloat(card.dataset.lat);
                const lng = parseFloat(card.dataset.lng);
                const distance = getDistanceFromLatLonInKm(userLat, userLng, lat, lng);
                const distanceElement = document.getElementById(`distance-${card.dataset.id}`);

                card.setAttribute('data-distance', distance.toFixed(2));
                distanceElement.textContent = `${distance.toFixed(2)} km`;
                distanceElement.classList.remove('hidden');
                distanceElement.classList.add(distance <= 5 ? 'near' : 'far');

                if (distance <= 5) {
                    nearbyCards.push(card);
                }
            });

            const sorted = Array.from(cards).sort((a, b) =>
                parseFloat(a.getAttribute('data-distance')) - parseFloat(b.getAttribute('data-distance'))
            );

            const accordionContents = document.querySelectorAll('.accordion-content');
            accordionContents.forEach(content => {
                const cardsInContent = Array.from(content.querySelectorAll('.laundry-card'));
                content.innerHTML = '';
                sorted.forEach(card => {
                    if (cardsInContent.some(c => c.dataset.id === card.dataset.id)) {
                        content.appendChild(card);
                    }
                });
            });

            if (sorted.length === 0) {
                document.getElementById('laundry-list').innerHTML = `<p class="text-center col-span-full text-gray-700 text-lg py-6">Tidak ada laundry dalam radius 5km dari lokasi Anda.</p>`;
                return;
            }
        }, function(error) {
            alert("Tidak bisa mendapatkan lokasi Anda: " + error.message);
        });
    }

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
</script>
@endpush
@endsection
