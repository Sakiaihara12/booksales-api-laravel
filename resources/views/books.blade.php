<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Bookstore</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Koleksi Buku</h1>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200 text-left text-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase">
                    <tr>
                        <th class="border border-gray-200 px-4 py-2">#</th>
                        <th class="border border-gray-200 px-4 py-2">Judul Buku</th>
                        <th class="border border-gray-200 px-4 py-2">Genre</th>
                        <th class="border border-gray-200 px-4 py-2">Penulis</th>
                        <th class="border border-gray-200 px-4 py-2">Tahun Terbit</th>
                        <th class="border border-gray-200 px-4 py-2">Harga</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($books as $index => $book)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-gray-200 px-4 py-2 font-medium text-gray-900">{{ $book->judul_buku }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $book->genre->nama_genre ?? '-' }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $book->author->nama_author ?? '-' }}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">{{ $book->tahun_terbit }}</td>
                        <td class="border border-gray-200 px-4 py-2">Rp {{ number_format($book->harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>oke udh