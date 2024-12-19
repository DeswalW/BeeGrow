<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Keranjang Anda</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(count($keranjang) > 0)
            <table class="w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Proyek</th>
                        <th class="py-2 px-4 border-b">Jumlah Lembar</th>
                        <th class="py-2 px-4 border-b">Total Bayar</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang as $projectId => $item)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $item['project_name'] ?? 'Proyek tidak ditemukan' }}</td>
                            <td class="py-2 px-4 border-b">{{ $item['quantity'] }}</td>
                            <td class="py-2 px-4 border-b">Rp{{ number_format($item['total_amount']) }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('investor.payment.show', ['projectId' => $projectId]) }}" 
                                    class="bg-ungu hover:bg-purple-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                     <i class="fa-solid fa-credit-card mr-2"></i>
                                     Bayar
                                 </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-700">Keranjang Anda kosong.</p>
        @endif
    </div>
    
</x-app-layout>