<x-app-layout>
    <div class="container mx-auto px-4 py-4 pt-20 md:pt-24">
         @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
         <!-- Header Tabel -->
        @if(count($keranjang) > 0)
        <div class="flex flex-col space-y-4">
            <div class="hidden md:grid grid-cols-12 p-4 text-gray-600 bg-white rounded-2xl">
                <div class="col-span-4">Produk</div>
                <div class="col-span-2 text-center">Satu Lembar</div>
                <div class="col-span-2 text-center">Jumlah Lembar</div>
                <div class="col-span-2 text-center">Total Investasi</div>
                <div class="col-span-2 text-center">Aksi</div>
            </div>
                @foreach($keranjang as $projectId => $item)
                    <!-- Nama Toko -->
                    <div class="p-4 bg-white rounded-2xl">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-store text-ungu"></i>
                            <span class="font-semibold text-ungu">{{ $item['umkm'] ?? 'UMKM' }}</span>
                        </div>
                         <!-- Item Produk -->
                        <div class="flex flex-col md:grid md:grid-cols-12 gap-4 md:gap-0 md:items-center">
                            <div class="md:col-span-4 flex gap-4">
                                <img src="{{ asset('img/umkm1.jpeg') }}" class="w-48 h-20 object-cover rounded-2xl">
                                <div>
                                    <p class="line-clamp-2">{{ $item['project_name'] }}</p>
                                </div>
                            </div>
                            
                            <!-- Harga Satuan - Mobile -->
                            <div class="md:hidden flex justify-between items-center text-sm">
                                <span class="text-gray-600">Satu lembar:</span>
                                <span class="font-semibold">Rp{{ number_format($item['price'] ?? 0) }}</span>
                            </div>
                            
                            <!-- Harga Satuan - Desktop -->
                            <div class="hidden md:block md:col-span-2 text-center text-sm">
                                <span class="font-semibold">Rp{{ number_format($item['price'] ?? 0) }}</span>
                            </div>
                             <!-- Kuantitas -->
                            <div class="md:col-span-2 flex justify-between md:justify-center items-center text-sm">
                                <span class="md:hidden text-gray-600">Jumlah Lembar:</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold">{{ number_format($item['quantity']) }}</span>
                                </div>
                            </div>
                             <!-- Total Harga -->
                             <div class="md:col-span-2 flex justify-between md:justify-center items-center text-sm">
                                 <span class="md:hidden text-gray-600">Total:</span>
                                 <span class="text-red-500 font-semibold">Rp{{ number_format($item['subtotal']) }}</span>
                            </div>
                             <!-- Aksi -->
                             <div class="md:col-span-2 flex justify-end md:justify-center flex-col space-y-2">
                                <a href="{{ route('investor.payment.show', ['projectId' => $projectId]) }}" 
                                    class="self-center w-full md:w-32 inline-flex justify-center items-center px-4 py-2 bg-ungu border border-transparent rounded-full font-medium text-sm text-white hover:bg-ungu/80 focus:bg-ungu/80 active:bg-ungu/90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                     <i class="fa-solid fa-credit-card mr-2"></i>
                                     Proses
                                 </a>
                                <button onclick="hapusProduk('{{ $projectId }}')" class="self-center w-full md:w-32 inline-flex justify-center items-center px-4 py-2 bg-white border-2 border-red-500 rounded-full font-medium text-sm text-red-500 hover:bg-red-500 hover:text-white focus:bg-red-500/80 active:bg-red-500/90 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                     <i class="fas fa-trash mr-2"></i>
                                     <span class="">Hapus</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>Keranjang Anda kosong</p>
                </div>
            @endif
        </div>
    </div>
    <script>
    function hapusProduk(projectId) {
        if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
            fetch(`/investor/keranjang/${projectId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Tampilkan pesan sukses
                alert(data.message);
                // Reload halaman untuk memperbarui tampilan
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus produk');
            });
        }
    }
    </script>
</x-app-layout>