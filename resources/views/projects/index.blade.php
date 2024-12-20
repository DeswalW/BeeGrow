<x-app-layout>
    <div class="flex flex-col px-20 pt-24 space-y-6 h-max">
        <div class="text-ungu hover:text-gray-500 w-max">
            <a href="{{ route('dashboard') }}" class=" w-max">
                <i class="fa-solid fa-arrow-left mr-2 "></i>
                Kembali
            </a>
        </div>
        <div class="grid grid-flow-row-dense grid-cols-3 md:gap-16 gap-4">
            <div class="col-span-2 space-y-6">
                <div class="flex flex-col justify-center items-center overflow-hidden space-y-4">
                    <img src="{{ asset('img/umkm1.jpeg') }}" alt="" class=" rounded-2xl w-full h-72 object-cover">
                    <div class="self-stretch items-center justify-between gap-4 w-full bg-salmon-300 grid grid-cols-5">
                        <img src="{{ asset('img/umkm1.jpeg') }}" alt="" class="col-span-1 h-auto rounded-xl object-cover">
                        <img src="{{ asset('img/umkm1.jpeg') }}" alt="" class="col-span-1 h-auto rounded-xl object-cover">
                        <img src="{{ asset('img/umkm1.jpeg') }}" alt="" class="col-span-1 h-auto rounded-xl object-cover">
                        <img src="{{ asset('img/umkm1.jpeg') }}" alt="" class="col-span-1 h-auto rounded-xl object-cover">
                        <img src="{{ asset('img/umkm1.jpeg') }}" alt="" class="col-span-1 h-auto rounded-xl object-cover">
                    </div>
                </div>

                <div class="space-y-6">
                    @if($project)
                        <h1 class="text-2xl font-semibold">{{ $project->umkm->name }} - {{ $project->title }}</h1>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <div class="flex items-center gap-2 text-sm ">
                                <i class="fa-solid fa-tag text-gray-400"></i>
                                <p class="text-gray-900">{{ $project->umkm->categories->first()->name }}</p>
                            </div>
                            <div class="flex items-center gap-2 text-sm ">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                <p class="text-gray-900">{{ $project->umkm->address }}</p>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-2 text-sm ">
                                <i class="fa-solid fa-clock text-gray-400"></i>
                                <p class="text-gray-900">{{ $project->deadline->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-2 text-sm ">
                                <i class="fa-solid fa-user text-gray-400"></i>
                                <p class="text-gray-900">{{ $project->umkm->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex justify-start items-start flex-col">
                            <p class="text-sm text-gray-500 dark:text-gray-500">Target Pendanaan</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                Rp{{ number_format($project->fundingDetails->target_pendanaan) }}
                            </p>
                        </div>
                        <div class="flex justify-end items-end flex-col">
                            <p class="text-sm text-gray-500 dark:text-gray-500">Dana Terkumpul</p>
                            <p class="text-2xl  font-semibold text-ungu dark:text-white">
                                Rp{{ number_format($project->fundingDetails->dana_terkumpul) }}
                            </p>
                        </div>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                        <div class="bg-ungu h-1.5 rounded-full" style="width: {{ min(100, ($project->fundingDetails->dana_terkumpul / $project->fundingDetails->target_pendanaan) * 100) }}%"></div>
                    </div>
                    @else
                    <p>Proyek tidak ditemukan.</p>
                    @endif
                </div>
                <!-- resources/views/dashboard.blade.php -->
                <div x-data="{ activeTab: 'business' }" class="h-max flex-col justify-start items-start gap-5 inline-flex w-full pb-20">
                    <!-- Menu Tabs -->
                    <div class="self-stretch justify-start items-center inline-flex">
                        @php
                            $menus = [
                                ['label' => 'Informasi Bisnis', 'key' => 'business'],
                                ['label' => 'Finansial', 'key' => 'financial'],
                                ['label' => 'Lokasi', 'key' => 'location'],
                                ['label' => 'Update Pendanaan', 'key' => 'funding']
                            ];
                        @endphp
                        @foreach ($menus as $menu)
                            <div 
                                class="grow shrink basis-0 h-[53px] p-4 border-b-2 cursor-pointer 
                                {{ $loop->first ? 'border-[#6a57c8] text-[#6a57c8] font-semibold' : 'border-neutral-200 text-[#252733]' }} 
                                text-sm font-['Poppins'] justify-center items-center gap-2.5 flex"
                                @click="activeTab = '{{ $menu['key'] }}'"
                                :class="{ 'border-[#6a57c8] text-[#6a57c8] font-semibold': activeTab === '{{ $menu['key'] }}', 'border-neutral-200 text-[#252733] font-normal': activeTab !== '{{ $menu['key'] }}' }"
                            >
                                {{ $menu['label'] }}
                            </div>
                        @endforeach
                    </div>
                
                    <!-- Content Section -->
                    <div class="self-stretch text-gray-800 text-sm font-normal" x-show="activeTab === 'business'">
                        Maju Jaya Roti adalah usaha kecil yang bergerak di bidang produksi roti sehat dengan bahan organik. Produk unggulan kami mencakup roti gandum utuh, roti bebas gluten, dan roti rendah gula yang sesuai untuk gaya hidup sehat masyarakat perkotaan.
                    </div>
                    <div class="self-stretch text-gray-800 text-sm font-normal" x-show="activeTab === 'financial'" x-cloak>
                        Informasi finansial akan ditampilkan di sini. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis ad eligendi velit dolorum quibusdam minima quae itaque tempore blanditiis ab dolore cumque at vitae rerum ratione, laudantium accusamus iure a. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae facilis eius vitae pariatur aliquam aspernatur doloribus cupiditate quae nostrum, ipsam nemo officiis beatae ullam delectus quos adipisci, totam, earum corrupti? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis ad eligendi velit dolorum quibusdam minima quae itaque tempore blanditiis ab dolore cumque at vitae rerum ratione, laudantium accusamus iure a. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae facilis eius vitae pariatur aliquam aspernatur doloribus cupiditate quae nostrum, ipsam nemo officiis beatae ullam delectus quos adipisci, totam, earum corrupti?
                    </div>
                    <div class="self-stretch text-gray-800 text-sm font-normal" x-show="activeTab === 'location'" x-cloak>
                        Lokasi toko dan pabrik akan ditampilkan di sini.
                    </div>
                    <div class="self-stretch text-gray-800 text-sm font-normal" x-show="activeTab === 'funding'" x-cloak>
                        Informasi terbaru tentang pendanaan akan ditampilkan di sini.
                    </div>
                </div>
            </div>

            <!-- Kalkulator Investasi -->
            <div class="col-span-1 row-span-1">
                <form action="{{ route('investor.keranjang.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="w-full p-6 bg-white rounded-2xl border border-gray-200 flex-col justify-start items-start gap-6 inline-flex">
                        <div class="self-stretch justify-start items-center gap-2 inline-flex">
                            <div class="text-gray-900 text-xl font-semibold">Tanam Modal</div>
                            <div class="w-4 h-4 justify-center items-center gap-2.5 flex"></div>
                        </div>
                        <div class="self-stretch flex-col justify-start items-start gap-4 flex">
                            <div class="self-stretch flex-col justify-start items-start gap-4 flex">
                                <p class="text-gray-900 text-md font-semibold">Jumlah Lembar</p>
                                <div class="self-stretch justify-start items-center gap-2 inline-flex">
                                    <button type="button" onclick="adjustInvestment(-1)" class="w-11 h-11 p-2.5 bg-[#302e38] rounded-lg justify-center items-center gap-2.5 flex">
                                        <div class="text-white"><i class="fa-solid fa-minus"></i></div>
                                    </button>
                                    <input type="number" 
                                           name="quantity" 
                                           id="investmentAmount" 
                                           class="grow shrink h-11 px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center flex text-center" 
                                           placeholder="Jumlah Lembar" 
                                           value="0" 
                                           min="0" 
                                           oninput="updateTotalValue()">
                                    <button type="button" onclick="adjustInvestment(1)" class="w-11 h-11 bg-[#302e38] rounded-lg gap-2.5 flex text-center items-center justify-center">
                                        <div class="text-white"><i class="fa-solid fa-plus"></i></div>
                                    </button>
                                </div>
                                <div class="text-center flex justify-between items-center w-full">
                                    <p class="text-gray-900 text-md font-semibold">Jumlah Bayar</p>
                                    <span id="totalInvestment" class="text-ungu text-xl font-semibold">Rp0</span>
                                </div>
                                
                                <div class="self-stretch justify-start items-center gap-2 inline-flex">
                                    <button type="button" class="investment-option grow shrink basis-0 h-11 px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center gap-2.5 flex" onclick="setInvestmentAmount(50, this)">
                                        <div class="text-gray-900 text-sm font-normal">Rp500 rb</div>
                                    </button>
                                    <button type="button" class="investment-option grow shrink basis-0 h-11 px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center gap-2.5 flex" onclick="setInvestmentAmount(100, this)">
                                        <div class="text-gray-900 text-sm font-normal">Rp1 jt</div>
                                    </button>
                                    <button type="button" class="investment-option grow shrink basis-0 h-11 px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center gap-2.5 flex" onclick="setInvestmentAmount(200, this)">
                                        <div class="text-gray-900 text-sm font-normal">Rp2 jt</div>
                                    </button>
                                </div>
                            </div>
                            <div class="self-stretch text-center text-gray-500 text-xs font-normal">Maksimal Rp160.000.000</div>
                            <div class="self-stretch h-[87px] flex-col justify-start items-start gap-4 flex">
                                <div class="self-stretch justify-start items-center gap-2 inline-flex">
                                    <div class="text-gray-900 text-md font-semibold">Ekspektasi hasil</div>
                                    <div class="w-4 h-4 justify-center items-center gap-2.5 flex"></div>
                                </div>
                                <div class="self-stretch h-[50px] flex-col justify-start items-start gap-2 flex">
                                    <div class="self-stretch justify-between items-center inline-flex">
                                        <div class="text-[#74767f] text-sm font-normal">Proyeksi total pendapatan</div>
                                        <div id="totalIncome" class="text-gray-900 text-sm font-medium">Rp0</div>
                                    </div>
                                    <div class="self-stretch justify-between items-center inline-flex">
                                        <div class="text-[#74767f] text-sm font-normal">Pendapatan per minggu</div>
                                        <div id="weeklyIncome" class="text-gray-900 text-sm font-medium">Rp0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-primary-button type="button" onclick="processPayment()">
                            Lanjutkan
                        </x-primary-button>
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="project_name" value="{{ $project->title }}">
                            <input type="hidden" name="total_amount" id="totaAmount" value="0">
                            <x-secondary-button type="submit" onclick="return addToCart()">
                                Tambah ke Keranjang
                            </x-secondary-button>
                        </div>
                    </form>
            </div>

            <style>
                .active-option {
                    border-color: #624bd7 !important;
                    background-color: #f3f4f6 !important;
                    border-width: 2px !important;
                }

                #cart-count {
                    transition: transform 0.2s ease-in-out;
                }
                
                #cart-count.scale-125 {
                    transform: scale(1.25);
                }
            </style>

            <script>
                function adjustInvestment(amount) {
                    const input = document.getElementById('investmentAmount');
                    let currentValue = parseInt(input.value) || 0;
                    currentValue = Math.max(0, currentValue + amount);
                    input.value = currentValue;
                    updateTotalValue();
                    clearActiveOptions(); // Hapus style active ketika menggunakan tombol +/-
                }

                function setInvestmentAmount(amount, element) {
                    const input = document.getElementById('investmentAmount');
                    input.value = amount;
                    updateTotalValue();
                    clearActiveOptions();
                    element.classList.add('active-option'); // Tambah style active pada tombol yang diklik
                }

                function updateTotalValue() {
                    const input = document.getElementById('investmentAmount');
                    const totalValue = parseInt(input.value) * 10000 || 0;
                    document.getElementById('totalInvestment').innerText = `Rp${totalValue.toLocaleString()}`;
                    calculateInvestment(totalValue);
                }

                function calculateInvestment(amount) {
                    const totalIncome = amount * 1.2; // Misalnya, 20% return
                    const weeklyIncome = totalIncome / 12; // Misalnya, dibagi 12 minggu

                    document.getElementById('totalIncome').innerText = `Rp${totalIncome.toLocaleString()}`;
                    document.getElementById('weeklyIncome').innerText = `Rp${weeklyIncome.toLocaleString()}`;
                }

                function clearActiveOptions() {
                    const options = document.querySelectorAll('.investment-option');
                    options.forEach(option => option.classList.remove('active-option'));
                }
            
                // Pastikan fungsi addToCart terdefinisi di luar event listener
                function addToCart() {
                    const quantity = document.getElementById('investmentAmount').value;
                    if (parseInt(quantity) <= 0) {
                        toastr.error('Jumlah lembar harus lebih dari 0!', 'Error');
                        return false;
                    }
                    
                    toastr.success('Produk berhasil ditambahkan ke keranjang!', 'Berhasil', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-bottom-right',
                        timeOut: 3000
                    });

                    updateCartIcon();
                    return true;
                }
            
                function updateCartIcon() {
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        let currentCount = parseInt(cartCountElement.innerText) || 0;
                        cartCountElement.innerText = currentCount + 1;
                        // Tambahkan animasi sederhana
                        cartCountElement.classList.add('scale-125');
                        setTimeout(() => {
                            cartCountElement.classList.remove('scale-125');
                        }, 200);
                    } else {
                        console.log('Cart count element not found');
                    }
                }

                function processPayment() {
                    const quantity = document.getElementById('investmentAmount').value;
                    if (parseInt(quantity) <= 0) {
                        toastr.error('Jumlah lembar harus lebih dari 0!', 'Error');
                        return;
                    }
                    window.location.href = `{{ route('investor.payment.show', ['projectId' => $project->id]) }}?quantity=${quantity}`;
                }
            </script>
</x-app-layout>