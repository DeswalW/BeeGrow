<x-app-layout>
    <div class="flex flex-col px-20 pt-24 space-y-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Pembayaran Berhasil</h1>
        <p class="text-gray-700">Terima kasih, pembayaran Anda telah berhasil diproses.</p>
        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Kembali ke Dashboard</a>
    </div>
</x-app-layout>