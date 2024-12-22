<x-app-layout>
    <div class="container mx-auto px-4 py-4 pt-24">
        <!-- Ringkasan Investasi -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-gray-600 text-sm mb-2">Total Investasi</h3>
                <p class="text-2xl font-bold text-ungu">Rp{{ number_format($totalInvested) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-gray-600 text-sm mb-2">Proyeksi Keuntungan</h3>
                <p class="text-2xl font-bold text-green-500">Rp{{ number_format($projectedReturns) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-gray-600 text-sm mb-2">Jumlah Proyek Aktif</h3>
                <p class="text-2xl font-bold text-ungu">{{ $activeInvestments->count() }}</p>
            </div>
        </div>

        <!-- Daftar Investasi Aktif -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4">Investasi Aktif</h2>
            
            @if($activeInvestments->count() > 0)
                <div class="grid gap-4">
                    @foreach($activeInvestments as $investment)
                        <div class="border rounded-2xl p-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('img/umkm1.jpeg') }}" class="w-24 h-24 object-cover rounded-xl">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">{{ $investment->project->title }}</h3>
                                    <p class="text-gray-600">{{ $investment->project->umkm->name }}</p>
                                    <div class="mt-2 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Jumlah Investasi</p>
                                            <p class="font-semibold">Rp{{ number_format($investment->amount) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Proyeksi Return</p>
                                            <p class="font-semibold text-green-500">Rp{{ number_format($investment->projected_return) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-sm 
                                        {{ $investment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($investment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-chart-line text-4xl mb-4"></i>
                    <p>Belum ada investasi aktif</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>