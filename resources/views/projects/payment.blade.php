<x-app-layout>
    <div class="flex flex-col px-4 lg:px-20 pt-24 space-y-6 min-h-screen">
        <a href="{{ route('investor.keranjang') }}" class="flex items-center text-gray-600 hover:text-ungu">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Kembali
        </a>
         <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Detail Pembayaran</h2>
            
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
                        <p class="text-gray-600">Biaya Admin (2,5%):</p>
                        <p class="font-semibold">Rp {{ number_format($item['admin_fee']) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Total Pembayaran:</p>
                        <p class="font-semibold">Rp {{ number_format($item['total_amount']) }}</p>
                    </div>
                </div>
            </div>
             <button id="pay-button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-ungu border border-transparent rounded-full font-medium text-sm text-white hover:bg-ungu/80 focus:bg-ungu/80 active:bg-ungu/90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Bayar Sekarang
            </button>
             <div id="snap-container"></div>
        </div>
    </div>
     <!-- Note: Ganti ke app.midtrans.com untuk Production -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    {{-- <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script> --}}
    
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                   console.log('success');
                   console.log(result);
                   window.location.href = "{{ route('investor.payment.success') }}?order_id=" + result.order_id;
               },
               onPending: function(result) {
                   console.log('pending');
                   console.log(result);
                   window.location.href = "{{ route('investor.payment.pending') }}?order_id=" + result.order_id;
               },
               onError: function(result) {
                   console.log('error');
                   console.log(result);
                   window.location.href = "{{ route('investor.payment.error') }}?order_id=" + result.order_id;
               },
               onClose: function() {
                   console.log('customer closed the popup without finishing the payment');
               }
           });
       });
    </script>
</x-app-layout>