<x-app-layout>
    <div class="container mx-auto px-4 md:px-6 lg:px-8 py-4 pt-24">
        <!-- Ringkasan Investasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <!-- Total Investasi -->
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 flex items-center justify-center bg-ungu/10 rounded-full">
                        <i class="fas fa-wallet text-ungu text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 text-xs md:text-sm">Total Investasi</h3>
                        <p class="text-lg md:text-2xl font-bold text-ungu">Rp{{ number_format($totalInvested) }}</p>
                    </div>
                </div>
            </div>

            <!-- Proyeksi Keuntungan -->
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 flex items-center justify-center bg-green-100 rounded-full">
                        <i class="fas fa-chart-line text-green-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 text-xs md:text-sm">Keuntungan</h3>
                        <p class="text-lg md:text-2xl font-bold text-green-500">Rp{{ number_format($projectedReturns) }}</p>
                    </div>
                </div>
            </div>

            <!-- Jumlah Proyek Aktif -->
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm sm:col-span-2 lg:col-span-1">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 flex items-center justify-center bg-ungu/10 rounded-full">
                        <i class="fas fa-project-diagram text-ungu text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 text-xs md:text-sm">Proyek Aktif</h3>
                        <p class="text-lg md:text-2xl font-bold text-ungu">{{ $activeInvestments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Investasi Aktif -->
        <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6">
            <h2 class="text-xl font-semibold mb-4">Investasi Aktif</h2>
            
            @if($activeInvestments->count() > 0)
                <div class="space-y-4">
                    @foreach($activeInvestments as $investment)
                        <div class="border rounded-xl p-4 hover:shadow-md transition-all hover:transition-all">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                <!-- Project Info -->
                                <div class="md:col-span-5">
                                    <h3 class="font-semibold text-ungu">{{ $investment->project->title }}</h3>
                                    <div class="flex items-center gap-1 justify-start">
                                        <i class="fas fa-store text-gray-400 text-sm"></i>
                                        <p class="text-sm text-gray-500">{{ $investment->project->umkm->name }}</p>
                                    </div>
                                </div>

                                <!-- Investment Details -->
                                <div class="md:col-span-5 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs sm:text-sm text-gray-500">Jumlah Lembar</p>
                                        <p class="font-semibold">{{ $investment->quantity }} Lembar</p>
                                    </div>
                                    <div>
                                        <p class="text-xs sm text-gray-500">Total Investasi</p>
                                        <p class="font-semibold">Rp{{ number_format($investment->amount) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs sm text-gray-500">Proyeksi Return</p>
                                        <p class="font-semibold text-green-500">Rp{{ number_format($investment->projected_return) }}</p>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="md:col-span-2 flex justify-end">
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
                <div class="text-center py-8">
                    <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Belum ada investasi aktif</p>
                    <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-ungu hover:text-ungu/80">
                        Mulai Investasi Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>