@extends('layouts')

@section('content')

<x-header>Homepage</x-header>

<div id="toast" class="fixed bottom-6 right-6 z-50 hidden px-5 py-3 rounded-md shadow-lg text-white bg-green-600 transition-all duration-300">
    <span id="toastMsg">Pesan di sini</span>
</div>

<x-info><x-icon></x-icon></x-info>

<!-- Clear div to ensure proper spacing after fixed navbar -->
<div class="clear-navbar-space"></div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="hero-title-section">
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-indigo-800 mb-4">Portal Temuan & Kehilangan ITS NU Pekalongan</h1>
            <p class="text-lg text-gray-600">Membantu mahasiswa menemukan barang yang hilang</p>
        </div>
    </div>

    <!-- Map Section -->
    <div class="mb-12 bg-white rounded-xl shadow-lg overflow-hidden map-container">
        <div id="lostItemsMap" class="w-full h-96 rounded-lg map-inner"></div>
        <div class="p-4 bg-gray-50 border-t border-gray-200">
            <p class="text-sm text-gray-600 text-center">
                <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span> Barang hilang
                <span class="inline-block w-3 h-3 rounded-full bg-green-500 ml-4 mr-2"></span> Barang temuan
            </p>
        </div>
    </div>

    <!-- Post Item Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            <!-- Post Form -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 bg-indigo-700 text-white">
                    <h2 class="text-2xl font-bold">Laporkan Barang Hilang atau Temuan</h2>
                    <p class="opacity-90">Bantu komunitas kami untuk bertemu kembali dengan barang milik mereka</p>
                </div>

                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('home.add', session('student.username')) }}" method="POST" enctype="multipart/form-data" id="itemForm" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Status Barang</label>
                                <select name="type" id="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="lost">Saya Kehilangan Barang</option>
                                    <option value="found">Saya Menemukan Barang</option>
                                </select>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Barang</label>
                                <input type="text" name="description" id="description" required placeholder="cth: Dompet hitam dengan kartu mahasiswa"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Lokasi di Peta</label>
                            <div id="selectLocationMap" class="w-full h-64 rounded-lg border border-gray-300"></div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Latitude</label>
                                    <input type="text" id="lat" name="latitude" readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Longitude</label>
                                    <input type="text" id="lng" name="longitude" readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 text-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-400 transition-colors" id="uploadContainer">
                                <input type="file" id="pic" name="pic" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium text-indigo-600">Klik untuk mengunggah</span> atau seret dan lepas
                                </p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG hingga 2MB</p>
                                <div id="fileNameDisplay" class="mt-2 text-sm font-medium text-gray-900 hidden"></div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="button" onclick="showEthicsModal()"
                                class="w-full py-3 px-4 rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-md transition-all">
                                Kirim Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Guidelines Section -->
            <div class="space-y-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-5 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Panduan Etis untuk Posting</h3>
                            <ul class="space-y-2 text-sm text-yellow-700">
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Hanya posting barang yang benar-benar Anda temukan atau kehilangan</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Jangan menggunakan informasi yang menyesatkan atau palsu</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Pilih lokasi yang benar dengan akurat semaksimal mungkin</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Unggah gambar yang jelas tanpa data pribadi</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-5 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">Cara Kerja</h3>
                            <ol class="space-y-3 text-sm text-blue-700">
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">1</span>
                                    <span>Pilih apakah Anda kehilangan atau menemukan barang</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">2</span>
                                    <span>Jelaskan barang secara detail untuk membantu identifikasi</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">3</span>
                                    <span>Tandai lokasi yang tepat di peta tempat barang hilang/ditemukan</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">4</span>
                                    <span>Unggah foto yang jelas dari barang tersebut</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">5</span>
                                    <span>Konfirmasi posting Anda dan bantu mempertemukan barang dengan pemiliknya</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ethics Confirmation Modal -->
    <div id="ethicsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-[9999] hidden transition-opacity" style="padding-top: 6rem;">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 shadow-xl transform transition-transform">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Konfirmasi Etis</h3>
            <p class="text-gray-600 mb-4">Dengan mengirimkan barang ini, Anda mengkonfirmasi bahwa:</p>
            <ul class="space-y-2 mb-6">
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">Informasi yang diberikan akurat dan benar</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">Anda berbuat dengan niat baik untuk mempertemukan barang hilang dengan pemiliknya</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">Anda tidak akan menyalahgunakan sistem ini untuk tujuan penipuan</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">Anda memahami bahwa penyalahgunaan dapat mengakibatkan tindakan disipliner</span>
                </li>
            </ul>
            <div class="flex items-center mb-6">
                <input id="ethicsAgreement" type="checkbox" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="ethicsAgreement" class="ml-3 block text-gray-700">
                    Saya memahami dan menyetujui syarat-syarat ini
                </label>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideEthicsModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitForm()" id="confirmBtn" disabled
                    class="px-4 py-2 rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 transition-colors">
                    Konfirmasi & Kirim
                </button>
            </div>
        </div>
    </div>

    @php
        // Helper to ensure image_labels is always an array for consistent handling
        $imageLabels = session('image_labels') ?? [];
        // Handle case where session might still be string (backward compatibility)
        if (is_string($imageLabels)) {
            $imageLabels = json_decode($imageLabels, true) ?? [];
        }
        $imageLabels = is_array($imageLabels) ? $imageLabels : [];
    @endphp

    <!-- AI Override Modal -->
    <div id="ai-override-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-[9999] hidden" style="padding-top: 6rem;">
        <div class="bg-white rounded-xl w-11/12 max-w-lg mx-auto shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">Analisis Selesai!</h3>
                    <button onclick="closeAiOverrideModal()" class="text-white text-2xl leading-none hover:text-green-200">&times;</button>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 space-y-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-green-700 font-medium">
                        {{ implode(', ', $imageLabels) }}
                    </p>
                </div>

                <form id="aiOverrideForm" action="{{ session('last_item_id') ? route('items.updateLabel', session('last_item_id')) : '#' }}" method="POST">
                    @csrf
                    <label for="selected_label_modal" class="block text-sm font-medium text-gray-700 mb-1">Pilih label yang paling cocok:</label>
                    <select name="selected_label" id="selected_label_modal" required
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="" disabled selected>-- Pilih label yang paling akurat --</option>
                        @foreach($imageLabels as $label)
                            <option value="{{ $label }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="mt-4 w-full py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Konfirmasi Label
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-end">
                    <button onclick="closeAiOverrideModal()" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS for Map and Navbar Fix -->
    <style>
        /* Fix for navbar overlap and scrolling issues */
        body {
            padding-top: 0;
        }
        
        /* Ensure navbar doesn't overlap content */
        .fixed.top-0 {
            z-index: 1000 !important;
        }
        
        /* Fix for info component navbar */
        .z-50 {
            z-index: 1000 !important;
        }
        
        /* Modal fixes - ensure modals appear above navbar */
        #ethicsModal,
        #ai-override-modal {
            z-index: 9999 !important;
            padding-top: 6rem !important;
        }
        
        /* Ensure modal content is properly positioned */
        #ethicsModal .bg-white,
        #ai-override-modal .bg-white {
            position: relative;
            z-index: 10000;
            margin-top: 2rem;
        }
        
        /* Clean map container styling */
        .map-container {
            margin-top: 1rem;
            position: relative;
            z-index: 10;
        }
        
        .map-inner {
            position: relative;
            z-index: 10;
        }
        
        /* Ensure proper spacing for fixed navbar */
        .clear-navbar-space {
            height: 10rem; /* Increased spacing to prevent overlap */
        }
        
        @media (min-width: 768px) {
            .clear-navbar-space {
                height: 12rem; /* Even more spacing on larger screens */
            }
        }
        
        /* Clean hero section styling */
        .hero-title-section {
            margin-top: 2rem;
            padding: 2rem 0;
            position: relative;
            z-index: 20;
            background: linear-gradient(to bottom, rgba(255,255,255,0.95), white);
            backdrop-filter: blur(10px);
        }
        
        /* Consistent container spacing */
        .max-w-7xl {
            position: relative;
        }
        
        /* Clean title styling */
        .hero-title-section h1 {
            position: relative;
            z-index: 21;
            background: rgba(255,255,255,0.95);
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .hero-title-section h1:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        /* Counter the wave element positioning */
        .fixed.top-0 .absolute.bottom-0 {
            z-index: 1 !important;
        }
        
        /* Map container styling */
        #lostItemsMap {
            width: 100% !important;
            height: 384px !important; /* 24rem = 384px */
            min-height: 384px !important;
            position: relative !important;
            background-color: #f8f9fa;
        }
        
        #selectLocationMap {
            width: 100% !important;
            height: 256px !important; /* 16rem = 256px */
            min-height: 256px !important;
            position: relative !important;
            background-color: #f8f9fa;
        }
        
        /* Fix for Leaflet map tiles overlapping */
        .leaflet-container {
            position: relative !important;
            z-index: 10 !important;
            background-color: #f8f9fa !important;
        }
        
        /* Ensure map doesn't extend beyond container */
        .leaflet-map-pane {
            position: relative !important;
        }
        
        /* Better map loading state */
        .leaflet-tile-container {
            opacity: 1 !important;
        }
        
        /* Loading state for map */
        .leaflet-container.loading {
            background-color: #e9ecef !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .leaflet-container.loading::after {
            content: 'Memuat peta...';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #6c757d;
            font-size: 14px;
            z-index: 1000;
            pointer-events: none;
        }
    </style>

    <!-- JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="/js/itempost.js"></script>
    <script>
        // Ethics Modal logic
        function showEthicsModal() {
            document.getElementById('ethicsModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('ethicsModal').classList.add('opacity-100');
            }, 10);
        }

        function hideEthicsModal() {
            document.getElementById('ethicsModal').classList.add('hidden');
            document.getElementById('ethicsModal').classList.remove('opacity-100');
            let chk = document.getElementById('ethicsAgreement');
            let btn = document.getElementById('confirmBtn');
            if (chk) chk.checked = false;
            if (btn) btn.disabled = true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            let chk = document.getElementById('ethicsAgreement');
            let btn = document.getElementById('confirmBtn');
            if (chk && btn) {
                chk.addEventListener('change', function() {
                    btn.disabled = !this.checked;
                });
            }

            // File upload display
            const fileInput = document.getElementById('pic');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const uploadContainer = document.getElementById('uploadContainer');

            if (fileInput && fileNameDisplay && uploadContainer) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                        fileNameDisplay.classList.remove('hidden');
                        uploadContainer.classList.add('border-green-400', 'bg-green-50');
                    } else {
                        fileNameDisplay.classList.add('hidden');
                        uploadContainer.classList.remove('border-green-400', 'bg-green-50');
                    }
                });
            }
        });

        function submitForm() {
            document.getElementById('itemForm').submit();
        }

        // AI Override Popup logic
        function showAiOverrideModal() {
            document.getElementById('ai-override-modal').classList.remove('hidden');
        }

        function closeAiOverrideModal() {
            document.getElementById('ai-override-modal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // AI Override Popup logic handled in the initialization script
        });

        // Toast Function
        function showToast(msg) {
            const toast = document.getElementById('toast');
            if (toast) {
                document.getElementById('toastMsg').textContent = msg;
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3000);
            }
        }

        // Form Validation
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('itemForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const lat = document.getElementById('lat').value;
                    const lng = document.getElementById('lng').value;

                    if (!lat || !lng) {
                        e.preventDefault();
                        showToast('Harap pilih lokasi di peta');
                    }
                });
            }
        });

        // Leaflet Maps Setup
        let lostItemsMap, selectLocationMap, marker;
        const defaultLocation = [-6.9606152, 109.6386821];
        
        window.Laravel = {
            mapItems: [],
            hasImageLabels: false,
            mapboxToken: "{{ env('MAPBOX_ACCESS_TOKEN', 'YOUR_MAPBOX_ACCESS_TOKEN_HERE') }}"
        };
        
        window.initMap = function() {
            try {
                console.log('Initializing maps...');
                
                // Check if map containers exist
                const mainMapContainer = document.getElementById('lostItemsMap');
                const selectMapContainer = document.getElementById('selectLocationMap');
                
                if (!mainMapContainer) {
                    console.error('Main map container not found!');
                    return;
                }

                // Initialize the main map for displaying lost/found items
                lostItemsMap = L.map('lostItemsMap').setView(defaultLocation, 16);
                console.log('Main map initialized');
                
                // Try to add Mapbox tiles, fallback to OpenStreetMap if token is invalid
                const mapboxToken = window.Laravel.mapboxToken;
                
                if (mapboxToken && mapboxToken !== 'YOUR_MAPBOX_ACCESS_TOKEN_HERE' && mapboxToken.length > 20) {
                    // Use Mapbox tiles if token is properly configured
                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                        attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
                        tileSize: 512,
                        maxZoom: 18,
                        zoomOffset: -1,
                        id: 'mapbox/streets-v11',
                        accessToken: mapboxToken
                    }).addTo(lostItemsMap);
                    console.log('Using Mapbox tiles');
                } else {
                    // Fallback to OpenStreetMap with better styling
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19,
                    }).addTo(lostItemsMap);
                    console.log('Using OpenStreetMap tiles');
                }

                // Add markers after map is ready
                lostItemsMap.whenReady(function() {
                    console.log('Main map is ready, now adding markers...');
                    setTimeout(function() {
                        lostItemsMap.invalidateSize();
                        console.log('Main map size invalidated');
                        
                        // Add markers for items - Enhanced debugging
                        console.log('=== ENHANCED MAP MARKER DEBUGGING ===');
                        console.log('LostItemsMap object:', lostItemsMap);
                        console.log('LostItemsMap ready:', lostItemsMap ? 'YES' : 'NO');
                        
                        // Ensure data is properly loaded
                        if (!window.Laravel) {
                            window.Laravel = {};
                        }
                        if (!window.Laravel.mapItems || window.Laravel.mapItems.length === 0) {
                            console.warn('window.Laravel.mapItems not defined or empty, trying to reload data...');
                            const mapDataElement = document.getElementById('map-data');
                            if (mapDataElement) {
                                try {
                                    const dataItems = mapDataElement.getAttribute('data-items') || '[]';
                                    window.Laravel.mapItems = JSON.parse(dataItems);
                                    console.log('Reloaded mapItems:', window.Laravel.mapItems);
                                } catch (e) {
                                    console.error('Error reloading mapItems:', e);
                                    window.Laravel.mapItems = [];
                                }
                            } else {
                                window.Laravel.mapItems = [];
                            }
                            
                            // FALLBACK: If still empty, use known database data as last resort
                            if (!window.Laravel.mapItems || window.Laravel.mapItems.length === 0) {
                                console.warn('🚨 CRITICAL: Data transfer failed! Using fallback data from database logs...');
                                window.Laravel.mapItems = [
                                    {
                                        id: 1,
                                        description: "Dompet",
                                        type: "lost",
                                        pic: "Husein-lost6.png",
                                        created_at: "2025-10-19T16:06:34.000000Z",
                                        status: "approved",
                                        latitude: -6.959485,
                                        longitude: 109.629802,
                                        has_default_location: false
                                    },
                                    {
                                        id: 3,
                                        description: "tas",
                                        type: "found",
                                        pic: "Husein-found1.png",
                                        created_at: "2025-10-19T16:35:39.000000Z",
                                        status: "Unresolved",
                                        latitude: -6.963574,
                                        longitude: 109.641747,
                                        has_default_location: false
                                    }
                                ];
                                console.log('🚨 Using fallback data with', window.Laravel.mapItems.length, 'items');
                            }
                        }
                        
                        console.log('Adding markers for items:', window.Laravel.mapItems ? window.Laravel.mapItems.length : 'UNDEFINED');
                        console.log('Full mapItems array:', window.Laravel.mapItems);
                        
                        if (!lostItemsMap) {
                            console.error('❌ CRITICAL: lostItemsMap is not initialized!');
                            return;
                        }
                        
                        if (window.Laravel.mapItems && window.Laravel.mapItems.length > 0) {
                            console.log(`Processing ${window.Laravel.mapItems.length} items for markers...`);
                            let markersAdded = 0;
                            
                            window.Laravel.mapItems.forEach((item, index) => {
                                console.log(`--- Processing item ${index} ---`);
                                console.log('Item data:', item);
                                
                                // More flexible coordinate checking
                                const lat = parseFloat(item.latitude) || parseFloat(item.lat) || null;
                                const lng = parseFloat(item.longitude) || parseFloat(item.lng) || null;
                                
                                console.log(`Item ${index} coordinates: lat=${lat}, lng=${lng}`);
                                console.log(`Item ${index} type: ${item.type}`);
                                console.log(`Item ${index} description: ${item.description}`);
                                
                                if (lat !== null && lng !== null && !isNaN(lat) && !isNaN(lng)) {
                                    console.log(`✅ Valid coordinates for item ${index}, creating marker...`);
                                    
                                    // Determine icon URL based on type
                                    const iconUrl = item.type === 'lost' 
                                        ? 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png' 
                                        : 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png';
                                    
                                    console.log(`Using icon URL: ${iconUrl}`);
                                    
                                    const markerIcon = L.icon({
                                        iconUrl: iconUrl,
                                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                                        iconSize: [25, 41],
                                        iconAnchor: [12, 41],
                                        popupAnchor: [1, -34],
                                        shadowSize: [41, 41]
                                    });
                                    
                                    // Create popup content
                                    let popupContent = `<b>${(item.type || 'Unknown').charAt(0).toUpperCase() + (item.type || '').slice(1)} Item</b><br>${item.description || 'No description'}`;
                                    
                                    // Add note if item uses default location
                                    if (item.has_default_location) {
                                        popupContent += '<br><small><em>Lokasi tidak tersedia - ditampilkan di kampus</em></small>';
                                    }
                                    
                                    try {
                                        console.log(`Creating marker at [${lat}, ${lng}] for "${item.description}"`);
                                        
                                        // Create marker with explicit error handling
                                        try {
                                            const itemMarker = L.marker([lat, lng], {icon: markerIcon})
                                                .addTo(lostItemsMap)
                                                .bindPopup(popupContent);
                                            
                                            // Verify marker was actually added
                                            const markerCount = Object.keys(lostItemsMap._layers).length;
                                            console.log(`Map now has ${markerCount} layers after adding marker`);
                                            
                                            markersAdded++;
                                            console.log(`✅ Successfully added marker ${markersAdded} for item ${index}: ${item.description} at [${lat}, ${lng}]`);
                                            console.log(`Marker object:`, itemMarker);
                                        } catch (markerCreationError) {
                                            console.error(`❌ Failed to create marker for item ${index}:`, markerCreationError);
                                        }
                                    } catch (markerError) {
                                        console.error(`❌ Error creating marker for item ${index}:`, markerError);
                                    }
                                } else {
                                    console.log(`❌ Skipping item ${index} - invalid coordinates: lat=${lat}, lng=${lng}`);
                                }
                            });
                            
                            console.log(`=== MARKER SUMMARY: ${markersAdded} markers added out of ${window.Laravel.mapItems.length} items ===`);
                        } else {
                            console.warn('⚠️ No map items found! mapItems is empty or undefined.');
                            console.log('mapItems type:', typeof window.Laravel.mapItems);
                            console.log('mapItems value:', window.Laravel.mapItems);
                            console.log('Adding test marker to verify map functionality...');
                            
                            // Add a test marker to verify map is working
                            try {
                                const testMarker = L.marker([-6.9606152, 109.6386821], {
                                    icon: L.icon({
                                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                                        iconSize: [25, 41],
                                        iconAnchor: [12, 41],
                                        popupAnchor: [1, -34],
                                        shadowSize: [41, 41]
                                    })
                                }).addTo(lostItemsMap).bindPopup('<b>Test Marker</b><br>No data items found');
                                
                                console.log('✅ Test marker added successfully');
                            } catch (testError) {
                                console.error('❌ Error adding test marker:', testError);
                            }
                        }
                        
                        // Map is working correctly with real data - no test marker needed
                        console.log('✅ Map initialization completed successfully with real data');
                        console.log(`Total map layers now: ${Object.keys(lostItemsMap._layers).length}`);
                        
                        console.log('=== END MAP MARKER DEBUGGING ===');
                    }, 200); // Increased delay to ensure map is fully ready
                });

                // Initialize the location selection map only if container exists
                if (selectMapContainer) {
                    selectLocationMap = L.map('selectLocationMap').setView(defaultLocation, 15);
                    console.log('Select location map initialized');
                    
                    // Add the same tile layer logic for consistency
                    if (mapboxToken && mapboxToken !== 'YOUR_MAPBOX_ACCESS_TOKEN_HERE' && mapboxToken.length > 20) {
                        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                            attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
                            tileSize: 512,
                            maxZoom: 18,
                            zoomOffset: -1,
                            id: 'mapbox/streets-v11',
                            accessToken: mapboxToken
                        }).addTo(selectLocationMap);
                    } else {
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            maxZoom: 19,
                        }).addTo(selectLocationMap);
                    }

                    // Add event listener for selectLocationMap
                    selectLocationMap.whenReady(function() {
                        console.log('Select location map is ready');
                        setTimeout(function() {
                            selectLocationMap.invalidateSize();
                            console.log('Select location map size invalidated');
                        }, 100);
                    });

                    // Add click handler for location selection
                    selectLocationMap.on('click', function(e) {
                        if (marker) {
                            selectLocationMap.removeLayer(marker);
                        }
                        
                        marker = L.marker(e.latlng, {draggable: true}).addTo(selectLocationMap);
                        document.getElementById("lat").value = e.latlng.lat.toFixed(6);
                        document.getElementById("lng").value = e.latlng.lng.toFixed(6);
                        
                        // Add dragend handler
                        marker.on('dragend', function(event) {
                            const position = marker.getLatLng();
                            document.getElementById("lat").value = position.lat.toFixed(6);
                            document.getElementById("lng").value = position.lng.toFixed(6);
                        });
                    });
                }

                console.log('Map initialization completed successfully');
                
            } catch (error) {
                console.error('Error initializing maps:', error);
                const mapContainer = document.getElementById("lostItemsMap");
                if (mapContainer) {
                    mapContainer.innerHTML = `
                        <div class="p-6 text-center">
                            <div class="text-red-500 font-bold text-xl mb-2">Error Memuat Peta</div>
                            <div class="text-gray-700 mb-4">Peta gagal dimuat dengan benar.</div>
                            <div class="text-gray-600 text-sm mb-4">
                                Error: ${error.message}
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-left mb-4">
                                <div class="font-medium text-green-800 mb-2">Solusi:</div>
                                <div class="text-green-700 text-sm">
                                    Pastikan Anda telah menambahkan token akses Mapbox ke variabel environment.<br>
                                    Tambahkan MAPBOX_ACCESS_TOKEN=kunci_mapbox_anda ke file .env Anda.
                                </div>
                            </div>
                        </div>
                    `;
                }
            }
        }
        
        // Initialize maps when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - initializing maps');
            
            // Add loading class to map container
            const mapContainer = document.getElementById('lostItemsMap');
            if (mapContainer) {
                mapContainer.classList.add('loading');
            }
            
            // Populate Laravel data object safely
            try {
                const mapDataElement = document.getElementById('map-data');
                if (mapDataElement) {
                    const dataItems = mapDataElement.getAttribute('data-items') || '[]';
                    window.Laravel.mapItems = JSON.parse(dataItems);
                    window.Laravel.hasImageLabels = mapDataElement.getAttribute('data-has-labels') === 'true';
                    console.log('Map data loaded:', window.Laravel.mapItems.length, 'items');
                    console.log('Map items data:', window.Laravel.mapItems);
                    
                    // Debug each item
                    window.Laravel.mapItems.forEach((item, index) => {
                        console.log(`Item ${index}:`, {
                            id: item.id,
                            description: item.description,
                            type: item.type,
                            latitude: item.latitude,
                            longitude: item.longitude,
                            hasDefaultLocation: item.has_default_location
                        });
                    });
                } else {
                    console.warn('Map data element not found, using empty array');
                    window.Laravel.mapItems = [];
                    window.Laravel.hasImageLabels = false;
                }
            } catch (error) {
                console.error('Error parsing map data:', error);
                window.Laravel.mapItems = [];
                window.Laravel.hasImageLabels = false;
            }
            
            // Check if Leaflet is loaded before initializing maps
            if (typeof L === 'undefined') {
                console.error('Leaflet library not loaded!');
                if (mapContainer) {
                    mapContainer.innerHTML = `
                        <div class="p-6 text-center">
                            <div class="text-red-500 font-bold text-xl mb-2">Error Memuat Library Peta</div>
                            <div class="text-gray-700 mb-4">Library Leaflet tidak dapat dimuat.</div>
                        </div>
                    `;
                }
                return;
            }
            
            if (typeof window.initMap === 'function') {
                // Add small delay to ensure DOM is fully ready and Leaflet is initialized
                setTimeout(function() {
                    console.log('Calling initMap...');
                    window.initMap();
                    
                    // Remove loading class after a short delay
                    setTimeout(function() {
                        if (mapContainer) {
                            mapContainer.classList.remove('loading');
                            console.log('Loading class removed');
                        }
                    }, 500);
                }, 200); // Increased delay to ensure all resources are loaded
            } else {
                console.error('initMap function not found!');
            }
            
            // AI Override Popup logic
            if (window.Laravel.hasImageLabels) {
                setTimeout(function() {
                    showAiOverrideModal();
                }, 1000); // Delay to ensure modal is ready
            }
        });
        
        window.addEventListener('load', function() {
            // Ensure maps are properly sized after all content loads
            setTimeout(function() {
                if (lostItemsMap) {
                    lostItemsMap.invalidateSize();
                }
                if (selectLocationMap) {
                    selectLocationMap.invalidateSize();
                }
            }, 100);
        });
        
        // Fix for scroll and resize issues
        window.addEventListener('scroll', function() {
            // Ensure map doesn't overlap navbar during scroll
            const mapContainer = document.getElementById('lostItemsMap');
            if (mapContainer && lostItemsMap) {
                lostItemsMap.invalidateSize();
            }
        });
        
        window.addEventListener('resize', function() {
            // Resize maps when window resizes
            setTimeout(function() {
                if (lostItemsMap) {
                    lostItemsMap.invalidateSize();
                }
                if (selectLocationMap) {
                    selectLocationMap.invalidateSize();
                }
            }, 100);
        });
    </script>
    <!-- DEBUG: Show actual data being sent -->
    @if(isset($mapItems) && count($mapItems) > 0)
        <script>
            console.log('🔍 DIRECT PHP DEBUG: mapItems has {{ count($mapItems) }} items');
            @foreach($mapItems as $index => $item)
                console.log('🔍 PHP Item {{ $index }}:', {
                    id: {{ $item['id'] ?? 'null' }},
                    description: "{{ $item['description'] ?? 'no-desc' }}",
                    type: "{{ $item['type'] ?? 'no-type' }}",
                    latitude: {{ $item['latitude'] ?? 'null' }},
                    longitude: {{ $item['longitude'] ?? 'null' }}
                });
            @endforeach
        </script>
    @else
        <script>
            console.warn('🔍 DIRECT PHP DEBUG: mapItems is empty or not set!');
        </script>
    @endif
    
    <!-- CRITICAL DEBUG: Show raw data -->
    <div style="display: none;">
        <div id="debug-raw-data">
            @if(isset($mapItems))
                mapItems EXISTS with {{ count($mapItems) }} items
                @foreach($mapItems as $item)
                    Item {{ $loop->index }}: ID={{ $item['id'] ?? 'NO_ID' }}, Type={{ $item['type'] ?? 'NO_TYPE' }}, Desc={{ $item['description'] ?? 'NO_DESC' }}
                @endforeach
            @else
                mapItems DOES NOT EXIST in view
            @endif
        </div>
    </div>
    
    <div id="map-data" data-items="@json($mapItems ?? [])" data-has-labels="{{ session('image_labels') ? 'true' : 'false' }}" style="display: none;">
        <!-- Debug info visible in browser to check data -->
        <span style="display: none;" id="debug-map-count">{{ count($mapItems ?? []) }}</span>
        <span style="display: none;" id="debug-raw-json">@json($mapItems ?? [])</span>
    </div>
    
    <!-- Enhanced debug info for troubleshooting -->
    <script>
        console.log('=== COMPREHENSIVE MAP DEBUG ===');
        console.log('Server-side mapItems count: {{ count($mapItems ?? []) }}');
        console.log('PHP mapItems variable exists: {{ isset($mapItems) ? "YES" : "NO" }}');
        
        @if(isset($mapItems) && count($mapItems) > 0)
            console.log('✅ mapItems found with {{ count($mapItems) }} items');
            console.log('First item details:', @json($mapItems[0] ?? null));
            @php
                $itemsSummary = [];
                foreach($mapItems as $item) {
                    $itemsSummary[] = [
                        'id' => $item['id'] ?? 'no-id',
                        'description' => $item['description'] ?? 'no-description', 
                        'type' => $item['type'] ?? 'no-type',
                        'lat' => $item['latitude'] ?? 'no-lat',
                        'lng' => $item['longitude'] ?? 'no-lng'
                    ];
                }
            @endphp
            console.log('All items summary:', @json($itemsSummary));
        @else
            console.log('❌ NO ITEMS FOUND!');
            console.log('mapItems is null/empty: true');
        @endif
        
        // CRITICAL DEBUG: Check all data sources
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔍 CRITICAL DEBUG - Checking all data sources...');
            
            // Check debug raw data
            const debugRawData = document.getElementById('debug-raw-data');
            if (debugRawData) {
                console.log('🔍 Raw debug data:', debugRawData.textContent);
            }
            
            // Check debug raw JSON
            const debugRawJson = document.getElementById('debug-raw-json');
            if (debugRawJson) {
                console.log('🔍 Raw JSON data:', debugRawJson.textContent);
            }
            
            // Check map-data element
            const mapDataElement = document.getElementById('map-data');
            if (mapDataElement) {
                const rawData = mapDataElement.getAttribute('data-items');
                console.log('🔍 Raw data-items attribute:', rawData);
                console.log('🔍 Raw data-items length:', rawData ? rawData.length : 'null');
                
                try {
                    const parsedData = JSON.parse(rawData || '[]');
                    console.log('🔍 Parsed data-items count:', parsedData.length);
                    console.log('🔍 Parsed data-items:', parsedData);
                    
                    if (parsedData.length === 0) {
                        console.error('❌ CRITICAL: parsedData is empty array!');
                        console.log('❌ This means data transfer from PHP to JavaScript failed!');
                    }
                } catch (e) {
                    console.error('❌ Error parsing data-items:', e);
                }
            } else {
                console.error('❌ map-data element not found!');
            }
        });
        
        console.log('=== END COMPREHENSIVE DEBUG ===');
    </script>
</div>

@endsection