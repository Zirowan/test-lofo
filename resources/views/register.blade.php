<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITS NU Pekalongan Temuan & Kehilangan | Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .galaxy-bg {
            background: linear-gradient(135deg, #21335e 0%, #8a9fd7 100%);
        }
        .input-glow:focus {
            box-shadow: 0 0 0 2px rgba(96, 165, 250, 0.5);
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="galaxy-bg min-h-screen text-white font-sans">
    <header class="flex items-center justify-center space-x-4 text-center py-4 bg-white-800">
        <img src="/images/uitmlogo.png" alt="ITS NU Pekalongan Logo" class="w-36 h-32">
        <div>
            <h1 class="text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-300 to-purple-400">
                ITS NU Pekalongan Temuan & Kehilangan
            </h1>
            <p class="italic text-xl mt-2 text-blue-200">
                Pusat Mahasiswa untuk Barang Temuan & Kehilangan
            </p>
        </div>
    </header>

    <div class="max-w-md mx-auto p-8 bg-slate-800 rounded-xl shadow-2xl backdrop-blur-sm bg-opacity-80">
        <h2 class="text-2xl font-semibold mb-6 text-center">Buat Profil</h2>

        <form action="/register" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-sm font-medium text-blue-200">Nama</label>
                <input class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 input-glow transition-all focus:ring-2 focus:ring-blue-500"
                       type="text" name="name" placeholder="e.g. Ali bin Ahmad" required>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-blue-200">Email</label>
                <input class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 input-glow"
                       type="email" name="email" placeholder="e.g. ali@student.itsnupkl.ac.id" required>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-blue-200">Nama Pengguna</label>
                <input class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 input-glow"
                       type="text" name="username" placeholder="e.g. space_explorer42" required>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-blue-200">Kata Sandi</label>
                <input class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 input-glow"
                       type="password" name="password" placeholder="••••••••" required>
                <p class="text-xs text-slate-400">Gunakan 8+ karakter dengan campuran huruf & angka</p>
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg font-medium btn-hover transition-all duration-300 flex items-center justify-center gap-2">
                <span>Buat Akun</span>
                <span></span>
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-slate-300">
                Selesai Daftar?
                <a href="/" class="text-blue-400 hover:text-blue-300 underline transition-colors">Kembali ke Login</a>
            </p>
        </div>
    </div>

    <!-- Fun CS Easter Egg -->
    <div class="text-center mt-8 text-xs text-slate-500">
        <p>Tips pro: Sarapan itu penting - setidaknya yang dikatakan kepada saya</p>
        <p class="mt-1">Dibuat oleh Mahasiswa FYP ITS NU Pekalongan</p>
    </div>
</body>
</html>
