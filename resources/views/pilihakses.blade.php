<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Hak Akses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white flex flex-col items-center">

    {{-- HEADER --}}
    <div class="w-full bg-[#1a3a5c] flex flex-col items-center py-12 px-6">
        <div class="w-20 h-20 rounded-full bg-[#2e5f8a] mb-5"></div>
        <h1 class="text-white text-2xl font-semibold">PD. Lancar Jaya Ciwidey</h1>
        <p class="text-blue-300 text-sm mt-1">Pilih hak akses untuk melanjutkan</p>
    </div>

    {{-- KONTEN --}}
    <div class="w-full max-w-sm px-6 mt-10 flex flex-col space-y-4">
        <p class="text-gray-600 text-sm mb-2">Silakan pilih hak akses sesuai dengan peran Anda</p>

        {{-- PETUGAS --}}
        <a href="{{ route('akses', 'petugas') }}" class="flex items-center space-x-4 p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
            <div class="w-12 h-12 bg-blue-100 rounded-md shrink-0"></div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Petugas</p>
                <p class="text-gray-400 text-xs mt-0.5">Kelola transaksi, petani, dan data sayuran</p>
            </div>
        </a>

        {{-- PEMILIK --}}
        <a href="{{ route('akses', 'pemilik') }}" class="flex items-center space-x-4 p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
            <div class="w-12 h-12 bg-green-100 rounded-md shrink-0"></div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Pemilik</p>
                <p class="text-gray-400 text-xs mt-0.5">Akses laporan, stok, petugas, dan chatbot</p>
            </div>
        </a>
    </div>

</body>
</html>
