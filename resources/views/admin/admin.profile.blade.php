<x-header>{{ session('admin')['name'] ?? 'Admin' }}</x-header>

<style>
    /* Navbar spacing fix */
    .clear-navbar-space {
        height: 10rem;
    }
    
    @media (min-width: 768px) {
        .clear-navbar-space {
            height: 12rem;
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

<!-- Clear div to ensure proper spacing after fixed navbar -->
<div class="clear-navbar-space"></div>

<!-- Main content container -->
<div class="pt-6">
    <x-info><x-icon></x-icon></x-info>
    
    <!-- Header -->
    <div class="bg-emerald-200 text-center py-3 mb-8 rounded-lg shadow-md">
        <h1 class="text-2xl md:text-3xl font-bold">ITS NU Pekalongan Temuan & Kehilangan - Panel Admin</h1>
    </div>

    <div class="max-w-3xl mx-auto p-4">
        <!-- Profile Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-emerald-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">{{ session('admin')['name'] ?? 'Admin' }}</h1>
            <p class="text-gray-600 mt-2">Administrator ITS NU Pekalongan</p>
        </div>

        <!-- Admin Stats -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold text-center mb-6 text-gray-800">Ringkasan Administrator</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tr class="bg-gray-50">
                        <x-row_header>Laporan Ditinjau</x-row_header>
                        <x-row_header>Barang Disetujui</x-row_header>
                        <x-row_header>Barang Diarsipkan</x-row_header>
                    </tr>
                    <tr>
                        <x-row_data class="text-center">{{ session('admin')['reviewed'] ?? 0 }}</x-row_data>
                        <x-row_data class="text-center">{{ session('admin')['approved'] ?? 0 }}</x-row_data>
                        <x-row_data class="text-center">{{ session('admin')['archived'] ?? 0 }}</x-row_data>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Update Admin Profile -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold text-center mb-6 text-gray-800">Perbarui Profil Admin</h3>
            <form action="/admin/profile/{{ session('admin')['username'] ?? 'admin' }}" method="POST" class="max-w-md mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label for="name" class="block text-gray-700 mb-3 font-medium">Nama Anda:</label>
                    <input type="text" name="name" id="name" value="{{ session('admin')['name'] ?? '' }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
                </div>
                <div class="text-center mt-8">
                    <x-button>Perbarui Profil</x-button>
                </div>
            </form>
        </div>

        <!-- Delete Admin Profile -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h3 class="text-xl font-semibold mb-6 text-gray-800">Hapus Profil Admin</h3>
            <p class="text-gray-600 mb-6">Hapus profil administrator secara permanen dan semua data terkait</p>
            <a href="/admin/profile/{{ session('admin')['username'] ?? 'admin' }}/delete" class="inline-block">
                <x-delete_button>Hapus Profil</x-delete_button>
            </a>
        </div>
    </div>
</div>
