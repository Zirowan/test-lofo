<x-header>Detail Item</x-header>

<style>
    /* Navbar spacing fix */
    .clear-navbar-space {
        height: 14rem; /* Increased spacing to prevent wave overlap */
    }
    
    @media (min-width: 768px) {
        .clear-navbar-space {
            height: 12rem; /* Even more spacing on larger screens */
        }
    }
    
    /* Ensure navbar doesn't overlap content */
    .fixed.top-0 {
        z-index: 1000 !important;
    }
    
    /* Fix for info component navbar */
    .z-50 {
        z-index: 1000 !important;
    }
</style>

<div class="min-h-screen bg-gray-50">
    <x-info><x-icon></x-icon></x-info>
    
    <!-- Clear navbar space -->
    <div class="clear-navbar-space"></div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Item Detail Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 bg-indigo-700 text-white">
                <h1 class="text-2xl font-bold">Detail Item</h1>
                <p class="opacity-90">Informasi lengkap tentang item</p>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Image Section -->
                    <div class="flex justify-center">
                        @php
                            $imagePath = 'images/' . session('pic')->pic;
                            $fullImagePath = public_path($imagePath);
                            $imageExists = file_exists($fullImagePath);
                        @endphp
                        
                        @if($imageExists)
                            <img class="w-full max-w-md h-80 object-cover rounded-lg border shadow-md hover:shadow-lg transition-shadow" 
                                 src="{{ asset($imagePath) }}" 
                                 alt="{{ session('pic')->description }}">
                        @else
                            <div class="w-full max-w-md h-80 bg-gray-200 border-2 border-dashed border-gray-400 rounded-lg flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm">Gambar tidak tersedia</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Details Section -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                                {{ session('pic')->description }}
                            </h2>
                            <div class="flex items-center space-x-2 mb-4">
                                @if(session('pic')->type === 'lost')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                        🔴 Barang Hilang
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        🟢 Barang Temuan
                                    </span>
                                @endif
                                
                                @if(session('pic')->status === 'Unresolved')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                        Menunggu
                                    </span>
                                @elseif(session('pic')->status === 'Pending')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        Diklaim
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                        {{ session('pic')->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Pelapor</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">
                                                {{ \App\Models\Student::where('email', session('pic')->from)->first()->name ?? 'Unknown' }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ session('pic')->from }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Item</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Dilaporkan:</span>
                                        <span class="font-medium">{{ session('pic')->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    @if(session('pic')->latitude && session('pic')->longitude)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Lokasi:</span>
                                        <span class="font-medium text-sm">{{ number_format(session('pic')->latitude, 4) }}, {{ number_format(session('pic')->longitude, 4) }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Section -->
        <div class="mt-8 text-center">
            <div class="flex justify-center space-x-4">
                @if(isset(session('student')['email']) && \App\Models\Claim::where("claimed_by", session('student')['email'])->where("pic", session('pic')->pic)->count() > 0)
                    {{-- User sudah pernah claim item ini --}}
                    <a href="{{ "/claim/pic/".session('pic')->pic }}" class="inline-flex items-center px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        Status Klaim
                    </a>
                @elseif(session('student')['email'] == session('pic')->from)
                    {{-- User adalah pemilik item, tampilkan tombol delete --}}
                    <a href="{{ "/picview/delete/".session('pic')->pic }}" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')"
                       class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Hapus Item
                    </a>
                @else
                    {{-- User bukan pemilik, tampilkan tombol claim --}}
                    <a href="{{ "/claim/pic/".session('pic')->pic }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Klaim Item Ini
                    </a>
                @endif
                
                <!-- Back Button -->
                <a href="{{ '/home/' . session('student')['username'] }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
