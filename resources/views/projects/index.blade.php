<x-app-layout>
    <div class="flex flex-col px-4 md:px-8 lg:px-20 pt-24 space-y-6 h-max">
        <div class="text-ungu hover:text-gray-500 w-full flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="w-max">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
        <div class="fixed bottom-0 left-0 right-0 w-full py-6 z-50 justify-center items-center px-6 bg-white border-t border-gray-200 shadow-lg">
            <p class="text-gray-500 text-xs text-center pb-2">Pilih jumlah lembar yang ingin anda investasikan</p>
            <button 
                class="lg:hidden bg-ungu text-white text-sm w-full px-4 py-2 rounded-full shadow-md hover:bg-ungu/90"
                onclick="toggleCalculator()"
            >
                <i class="fa-solid fa-calculator mr-2"></i>
                Tanam Modal
            </button>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-16">
            <div class="lg:col-span-2 space-y-6">
                <div class="image-gallery mb-6">
                    <!-- Main Image -->
                    <div class="main-image mb-2 ">
                        @if($project->images->isNotEmpty())
                            <img src="{{ Storage::url($project->images->first()->image_path) }}"
                                 alt="Foto Utama {{ $project->title }}"
                                 class="w-full h-[200px] object-cover rounded-2xl">
                        @else
                            <div class="w-full h-[400px] bg-gray-100 rounded-lg flex items-center justify-center">
                                <p class="text-gray-500">Belum ada foto proyek</p>
                            </div>
                        @endif
                    </div>
                    <!-- Thumbnail Images -->
                    @if($project->images->count() > 1)
                        <div class="thumbnails grid grid-cols-6 gap-2">
                            @foreach($project->images as $key => $image)
                                <div class="thumbnail-wrapper aspect-w-16 aspect-h-9 {{ $key === 0 ? 'active' : '' }}"
                                     onclick="changeMainImage('{{ Storage::url($image->image_path) }}', this)">
                                    <img src="{{ Storage::url($image->image_path) }}"
                                         alt="Thumbnail {{ $key + 1 }}"
                                         class="w-full h-full object-cover rounded-md cursor-pointer hover:opacity-75 transition-opacity">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    @if($project)
                        <h1 class="text-xl md:text-2xl font-semibold">{{ $project->umkm->name }} - {{ $project->title }}</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-tag text-gray-400"></i>
                                <p class="text-gray-900">
                                    {{ $project->umkm->category ? $project->umkm->category->name : 'Kategori belum ditentukan' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                <p class="text-gray-900">{{ $project->umkm->address }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-clock text-gray-400"></i>
                                <p class="text-gray-900">{{ $project->deadline->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-user text-gray-400"></i>
                                <p class="text-gray-900">{{ $project->umkm->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-start md:items-center gap-4">
                            <div>
                                <p class="text-xs md:text-sm text-gray-500">Target Pendanaan</p>
                                <p class="text-lg md:text-2xl font-semibold text-gray-900">
                                    Rp{{ number_format($project->fundingDetails->target_pendanaan) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm text-gray-500">Dana Terkumpul</p>
                                <p class="text-lg md:text-2xl font-semibold text-ungu">
                                    Rp{{ number_format($project->fundingDetails->dana_terkumpul) }}
                                </p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-ungu h-1.5 rounded-full" style="width: {{ min(100, ($project->fundingDetails->dana_terkumpul / $project->fundingDetails->target_pendanaan) * 100) }}%"></div>
                        </div>
                    </div>
                    @else
                    <p>Proyek tidak ditemukan.</p>
                    @endif
                </div>
                <!-- resources/views/dashboard.blade.php -->
                <div x-data="{ activeTab: 'business' }" class="h-max flex-col justify-start items-start gap-5 inline-flex w-full pb-20">
                    <!-- Menu Tabs - Scrollable on Mobile -->
                    <div class="overflow-x-auto no-scrollbar self-stretch justify-start items-center inline-flex">
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
                            text-xs md:text-sm justify-center items-center gap-2.5 flex"
                            @click="activeTab = '{{ $menu['key'] }}'"
                            :class="{ 'border-[#6a57c8] text-[#6a57c8] font-semibold': activeTab === '{{ $menu['key'] }}', 'border-neutral-200 text-[#252733] font-normal': activeTab !== '{{ $menu['key'] }}' }"
                        >
                            {{ $menu['label'] }}
                        </div>
                        @endforeach
                    </div>

                    <!-- Tab Contents -->
                    <div class="text-sm text-gray-800">
                        <div x-show="activeTab === 'business'">
                            Maju Jaya Roti adalah usaha kecil yang bergerak di bidang produksi roti sehat dengan bahan organik. Produk unggulan kami mencakup roti gandum utuh, roti bebas gluten, dan roti rendah gula yang sesuai untuk gaya hidup sehat masyarakat perkotaan.
                        </div>
                        <div x-show="activeTab === 'financial'" x-cloak>
                            <!-- Financial Content -->
                        </div>
                        <div x-show="activeTab === 'location'" x-cloak>
                            <!-- Location Content -->
                        </div>
                        <div x-show="activeTab === 'funding'" x-cloak>
                            <!-- Funding Content -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Investment Calculator -->
            <div class="hidden lg:block lg:sticky lg:top-24">
                @include('components.investment-calculator')
            </div>
        </div>
    </div>

    <!-- Mobile Calculator Popup -->
    <div id="calculatorPopup" 
         class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden"
         onclick="if(event.target === this) toggleCalculator()">
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl transform transition-transform duration-300 translate-y-full" 
             id="calculatorContent">
            <!-- Calculator Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Tanam Modal</h3>
                <button onclick="toggleCalculator()" class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Calculator Content - Sama persis dengan form desktop -->
            <div class="p-4 overflow-y-auto max-h-[80vh]">
                <form action="{{ route('investor.keranjang.add') }}" method="POST" class="bg-white rounded-2xl md:p-6">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    
                    <div class="self-stretch flex-col justify-start items-start gap-4 flex">
                        <div class="self-stretch flex-col justify-start items-start gap-4 flex">
                            <p class="text-gray-900 text-md font-semibold">Jumlah Lembar</p>
                            <div class="self-stretch justify-between items-center gap-2 inline-flex w-full">
                                <button type="button" onclick="adjustInvestment(-1, 'mobile')" class="w-11 h-11 py-2.5 px-3 bg-[#302e38] rounded-lg justify-center items-center gap-2.5 flex">
                                    <div class="text-white"><i class="fa-solid fa-minus"></i></div>
                                </button>
                                <input type="number" 
                                       name="quantity" 
                                       id="mobileInvestmentAmount" 
                                       class="h-11 w-full px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center flex text-center" 
                                       placeholder="Jumlah Lembar" 
                                       value="0" 
                                       min="0" 
                                       oninput="updateTotalValue('mobile')">
                                <button type="button" onclick="adjustInvestment(1, 'mobile')" class="w-11 h-11 bg-[#302e38] rounded-lg py-2.5 px-3 flex text-center items-center justify-center">
                                    <div class="text-white"><i class="fa-solid fa-plus"></i></div>
                                </button>
                            </div>
                            <div class="text-center flex justify-between items-center w-full">
                                <p class="text-gray-900 text-md font-semibold">Jumlah Bayar</p>
                                <span id="mobileTotalInvestment" class="text-ungu text-xl font-semibold">Rp0</span>
                            </div>
                            
                            <div class="self-stretch justify-start items-center gap-2 inline-flex">
                                <button type="button" class="investment-option grow shrink basis-0 h-11 px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center gap-2.5 flex" onclick="setInvestmentAmount(50, this, 'mobile')">
                                    <div class="text-gray-900 text-sm font-normal">Rp500 rb</div>
                                </button>
                                <button type="button" class="investment-option grow shrink basis-0 h-11 px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center gap-2.5 flex" onclick="setInvestmentAmount(100, this, 'mobile')">
                                    <div class="text-gray-900 text-sm font-normal">Rp1 jt</div>
                                </button>
                                <button type="button" class="investment-option grow shrink basis-0 h-11 px-2.5 rounded-lg border border-[#e9e9eb] justify-center items-center gap-2.5 flex" onclick="setInvestmentAmount(200, this, 'mobile')">
                                    <div class="text-gray-900 text-sm font-normal">Rp2 jt</div>
                                </button>
                            </div>
                        </div>
                        <div class="self-stretch text-center text-gray-500 text-xs font-normal">
                            @if($project->isFullyFunded())
                                <span class="text-green-500">Pendanaan telah terpenuhi</span>
                            @else
                                Maksimal {{ number_format($project->max_remaining_shares) }} lembar (Rp{{ number_format($project->remaining_funding) }})
                            @endif
                        </div>
                        <div class="self-stretch h-[87px] flex-col justify-start items-start gap-4 flex">
                            <div class="self-stretch justify-start items-center gap-2 inline-flex">
                                <div class="text-gray-900 text-md font-semibold">Ekspektasi hasil</div>
                                <div class="w-4 h-4 justify-center items-center gap-2.5 flex"></div>
                            </div>
                            <div class="self-stretch h-[50px] flex-col justify-start items-start gap-2 flex">
                                <div class="self-stretch justify-between items-center inline-flex">
                                    <div class="text-[#74767f] text-sm font-normal">Proyeksi total pendapatan</div>
                                    <div id="mobileTotalIncome" class="text-gray-900 text-sm font-medium">Rp0</div>
                                </div>
                                <div class="self-stretch justify-between items-center inline-flex">
                                    <div class="text-[#74767f] text-sm font-normal">Pendapatan per minggu</div>
                                    <div id="mobileWeeklyIncome" class="text-gray-900 text-sm font-medium">Rp0</div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                <x-primary-button type="button" onclick="processPayment('mobile')" class="my-4">
                    Lanjutkan
                </x-primary-button>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="project_name" value="{{ $project->title }}">
                    <input type="hidden" name="total_amount" id="totaAmount" value="0">
                <x-secondary-button type="submit" onclick="return addToCart('mobile')">
                    Tambah ke Keranjang
                </x-secondary-button>
            </form>
            </div>
        </div>
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

        .thumbnail-wrapper.active img {
            border: 2px solid #7C3AED; /* warna ungu */
            opacity: 0.8;
        }
    </style>

    <script>
        function toggleCalculator() {
            const popup = document.getElementById('calculatorPopup');
            const content = document.getElementById('calculatorContent');
            
            if (popup.classList.contains('hidden')) {
                // Show popup
                popup.classList.remove('hidden');
                setTimeout(() => {
                    content.classList.remove('translate-y-full');
                }, 10);
            } else {
                // Hide popup
                content.classList.add('translate-y-full');
                setTimeout(() => {
                    popup.classList.add('hidden');
                }, 300);
            }
        }
        function adjustInvestment(amount, version = 'desktop') {
            const inputId = version === 'mobile' ? 'mobileInvestmentAmount' : 'investmentAmount';
            const input = document.getElementById(inputId);
            let currentValue = parseInt(input.value) || 0;
            currentValue = Math.max(0, currentValue + amount);
            input.value = currentValue;
            updateTotalValue(version);
            clearActiveOptions(version);
        }

        function setInvestmentAmount(amount, element, version = 'desktop') {
            const inputId = version === 'mobile' ? 'mobileInvestmentAmount' : 'investmentAmount';
            const input = document.getElementById(inputId);
            input.value = amount;
            updateTotalValue(version);
            clearActiveOptions(version);
            element.classList.add('active-option');
        }

        function updateTotalValue(version = 'desktop') {
            const inputId = version === 'mobile' ? 'mobileInvestmentAmount' : 'investmentAmount';
            const totalInvestmentId = version === 'mobile' ? 'mobileTotalInvestment' : 'totalInvestment';
            const totalIncomeId = version === 'mobile' ? 'mobileTotalIncome' : 'totalIncome';
            const weeklyIncomeId = version === 'mobile' ? 'mobileWeeklyIncome' : 'weeklyIncome';

            const input = document.getElementById(inputId);
            const maxShares = {{ $project->max_remaining_shares }};
            
            if (parseInt(input.value) > maxShares) {
                input.value = maxShares;
            }
            
            const totalValue = parseInt(input.value) * 10000 || 0;
            document.getElementById(totalInvestmentId).innerText = `Rp${totalValue.toLocaleString()}`;
            calculateInvestment(totalValue, version);
        }

        function calculateInvestment(amount, version = 'desktop') {
            const totalIncomeId = version === 'mobile' ? 'mobileTotalIncome' : 'totalIncome';
            const weeklyIncomeId = version === 'mobile' ? 'mobileWeeklyIncome' : 'weeklyIncome';

            const totalIncome = amount * 1.2;
            const weeklyIncome = totalIncome / 12;

            document.getElementById(totalIncomeId).innerText = `Rp${totalIncome.toLocaleString()}`;
            document.getElementById(weeklyIncomeId).innerText = `Rp${weeklyIncome.toLocaleString()}`;
        }

        function clearActiveOptions(version = 'desktop') {
            const container = version === 'mobile' ? 
                document.getElementById('calculatorPopup') : 
                document.querySelector('.lg\\:sticky');
            const options = container.querySelectorAll('.investment-option');
            options.forEach(option => option.classList.remove('active-option'));
        }
    
        function addToCart(version = 'desktop') {
            const inputId = version === 'mobile' ? 'mobileInvestmentAmount' : 'investmentAmount';
            const quantity = document.getElementById(inputId).value;
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

        function processPayment(version = 'desktop') {
            const inputId = version === 'mobile' ? 'mobileInvestmentAmount' : 'investmentAmount';
            const quantity = document.getElementById(inputId).value;
            if (parseInt(quantity) <= 0) {
                toastr.error('Jumlah lembar harus lebih dari 0!', 'Error');
                return;
            }
            window.location.href = `{{ route('investor.payment.show', ['projectId' => $project->id]) }}?quantity=${quantity}`;
        }

        function changeMainImage(imageSrc, thumbnail) {
            // Update main image
            document.querySelector('.main-image img').src = imageSrc;
            
            // Update active state
            document.querySelectorAll('.thumbnail-wrapper').forEach(el => {
                el.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
    </script>
</x-app-layout>