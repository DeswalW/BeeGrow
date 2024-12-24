    <form action="{{ route('investor.keranjang.add') }}" method="POST" class="bg-white rounded-2xl border border-gray-200 p-4 md:p-6">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
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
                        <div id="totalIncome" class="text-gray-900 text-sm font-medium">Rp0</div>
                    </div>
                    <div class="self-stretch justify-between items-center inline-flex">
                        <div class="text-[#74767f] text-sm font-normal">Pendapatan per minggu</div>
                        <div id="weeklyIncome" class="text-gray-900 text-sm font-medium">Rp0</div>
                    </div>
                </div>
            </div>
        </div>

    <x-primary-button type="button" onclick="processPayment()" class="my-4">
        Lanjutkan
    </x-primary-button>
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="hidden" name="project_name" value="{{ $project->title }}">
        <input type="hidden" name="total_amount" id="totaAmount" value="0">
    <x-secondary-button type="submit" onclick="return addToCart()">
        Tambah ke Keranjang
    </x-secondary-button>
</form>