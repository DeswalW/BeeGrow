<x-app-layout>
    <div class="flex flex-col px-20 pt-24 space-y-6 min-h-screen">
        <a href="{{ route('investor.keranjang') }}" class="flex items-center text-gray-600 hover:text-gray-800">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Kembali
        </a>
         <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-6">Detail Pembayaran</h2>
            
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Proyek:</p>
                        <p class="font-semibold">{{ $project->title }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Jumlah Lembar:</p>
                        <p class="font-semibold">{{ $item['quantity'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Total Pembayaran:</p>
                        <p class="font-semibold">Rp {{ number_format($item['total_amount']) }}</p>
                    </div>
                </div>
            </div>
             <button id="pay-button" class="bg-ungu hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Bayar Sekarang
            </button>
             <div id="snap-container"></div>
        </div>
    </div>
     <!-- Note: Ganti ke app.midtrans.com untuk Production -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('investor.payment.success') }}?order_id=" + result.order_id;
                },
                onPending: function(result) {
                    window.location.href = "{{ route('investor.payment.pending') }}?order_id=" + result.order_id;
                },
                onError: function(result) {
                    window.location.href = "{{ route('investor.payment.error') }}?order_id=" + result.order_id;
                },
                onClose: function() {
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
</x-app-layout>