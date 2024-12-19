<x-app-layout>
    <div class="flex flex-col px-20 pt-24 space-y-6 min-h-screen">
        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Kembali ke Dashboard</a>
    </div>
    <div class="w-72 h-[387px] flex-col justify-start items-center gap-8 inline-flex">
        <div class="w-[222px] h-[179px] relative">
            <div class="w-[167px] h-[167px] left-[28px] top-[12px] absolute">
                <div class="w-[167px] h-[167px] left-0 top-0 absolute bg-[#4a90e2]/5 rounded-full"></div>
                <div class="w-[137px] h-[137px] left-[15px] top-[15px] absolute bg-[#4a90e2]/10 rounded-full"></div>
                <div class="w-[109px] h-[109px] left-[29px] top-[29px] absolute bg-[#4a90e2]/10 rounded-full"></div>
                <div class="w-20 h-20 left-[44px] top-[43px] absolute bg-[#4a90e2] rounded-[99px] justify-center items-center gap-2.5 inline-flex">
                    <div class="w-12 h-12 relative">
                        <div class="w-12 h-12 left-0 top-0 absolute bg-[#e0e0e0]"></div>
                    </div>
                </div>
            </div>
            <div class="w-[222px] h-[161px] left-0 top-0 absolute">
                <div class="w-1.5 h-1.5 left-[25px] top-[29px] absolute bg-[#4a90e2] rounded-full"></div>
                <div class="w-1.5 h-1.5 left-[216px] top-[89px] absolute bg-[#4a90e2] rounded-full"></div>
                <div class="w-[3px] h-[3px] left-[192px] top-[158px] absolute bg-[#4a90e2] rounded-full"></div>
                <div class="w-[3px] h-[3px] left-[204px] top-[18px] absolute bg-[#4a90e2]/40 rounded-full"></div>
                <div class="w-[3px] h-[3px] left-0 top-[155px] absolute bg-[#4a90e2]/40 rounded-full"></div>
                <div class="w-[3px] h-[3px] left-[163px] top-0 absolute bg-[#4a90e2] rounded-full"></div>
                <div class="w-[3px] h-[3px] left-[15px] top-[119px] absolute bg-[#4a90e2] rounded-full"></div>
            </div>
        </div>
        <div class="self-stretch h-[88px] flex-col justify-start items-start gap-4 flex">
            <div class="self-stretch text-[#252733] text-xl font-semibold font-['Poppins']">Yeay, Transaksimu Berhasil!</div>
            <div class="self-stretch text-center text-[#74767f] text-sm font-normal font-['Poppins']">Danamu akan segera diproses ke UMKM yang kamu pilih</div>
        </div>
        <div class="self-stretch h-14 px-4 py-2.5 bg-[#624bd7] rounded-lg justify-center items-center gap-2.5 inline-flex">
            <a href="{{ route('investor.portfolio') }}">
                <div class="text-white text-sm font-semibold font-['Poppins']">Lihat Portfolio</div>
            </a>
            <div class="w-4 h-4 py-px flex-col justify-center items-center gap-2.5 inline-flex"></div>
        </div>
    </div>
</x-app-layout>