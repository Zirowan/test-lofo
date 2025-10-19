<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portal Admin - ITS NU Pekalongan Temuan & Kehilangan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .logo-container {
            aspect-ratio: 1/1;
            object-fit: contain;
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
        }
        .title-text {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            color: #ffffff !important;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-emerald-900 to-green-900 min-h-screen flex items-center justify-center">
    <!-- Animated background pattern -->
    <div class="absolute inset-0 z-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width='52' height='26' viewBox='0 0 52 26' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.4'%3E%3Cpath d='M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <!-- Login Container -->
    <div class="relative z-10 glass-effect p-8 rounded-3xl shadow-2xl w-full max-w-md transform transition-all hover:shadow-emerald-500/30 hover:border-emerald-500/60 animate-float">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="flex flex-col items-center mb-6">
                <div class="relative mb-4">
                    <div class="absolute inset-0 bg-emerald-500/20 rounded-full blur-xl"></div>
                    <div class="relative bg-white/10 backdrop-blur-sm rounded-full p-4 border border-emerald-500/20 w-20 h-20 flex items-center justify-center">
                        <img src="\images\uitmlogo.png" alt="ITS NU Pekalongan Logo" class="logo-container w-full h-full">
                    </div>
                </div>
                <h1 class="text-4xl font-bold title-text drop-shadow-lg">
                    Portal Admin
                </h1>
            </div>
            <div class="space-y-1">
                <p class="text-gray-300 font-medium">Akses aman ke Dashboard Manajemen</p>
                <p class="text-gray-400 text-sm">untuk Sistem Temuan & Kehilangan</p>
            </div>
        </div>

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 p-3 rounded-lg mb-6 flex items-center gap-2">
            <i class='bx bx-error-circle text-red-400'></i>
            <span class="text-red-300 text-sm">{{ session('error') }}</span>
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-300 uppercase tracking-wide">Email Admin</label>
                <div class="flex items-center bg-gray-700/50 border border-gray-600/30 rounded-lg px-3 transition focus-within:border-emerald-500/70 focus-within:shadow-emerald-500/20">
                    <i class='bx bx-envelope text-gray-400 mr-2'></i>
                    <input type="email" name="email" id="email" required placeholder="admin@itsnupkl.ac.id"
                           class="w-full py-3 bg-transparent text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-0">
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-300 uppercase tracking-wide">Kata Sandi</label>
                <div class="flex items-center bg-gray-700/50 border border-gray-600/30 rounded-lg px-3 transition focus-within:border-emerald-500/70 focus-within:shadow-emerald-500/20">
                    <i class='bx bx-lock-alt text-gray-400 mr-2'></i>
                    <input type="password" name="password" id="password" required placeholder="Masukkan kata sandi"
                           class="w-full py-3 bg-transparent text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-0">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-emerald-600 to-green-500 hover:from-emerald-500 hover:to-green-400 text-white font-semibold py-3 px-4 rounded-lg transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2 shadow-lg hover:shadow-emerald-500/25">
                <i class='bx bx-log-in-circle'></i>
                Akses Dashboard
            </button>
        </form>

            <!-- System Info Footer -->
            <div class="mt-6 text-center text-xs text-gray-500">
                <p>&copy; 2025 Sistem Temuan & Kehilangan ITS NU Pekalongan</p>
                <p class="mt-1">v1.0 | Akses Admin Aman</p>
            </div>
        </div>
    </div>

    <!-- Animated Background Circles -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-green-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-400/5 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>
</body>
</html>
