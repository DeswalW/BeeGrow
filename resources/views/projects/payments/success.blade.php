<x-app-layout>
    <div class="flex flex-col px-20 pt-24 space-y-6 min-h-screen">
        <div class="text-ungu hover:text-gray-500 w-max">
            <a href="{{ route('dashboard') }}" class=" w-max">
                <i class="fa-solid fa-arrow-left mr-2 "></i>
                Kembali
            </a>
        </div>
        <div class="w-full flex justify-center items-center">
            <div class="w-96 h-max flex-col gap-8 flex justify-center items-center p-4">
                <div class="w-[222px] h-[179px] relative">
                    <div class="w-[167px] h-[167px] left-[28px] top-[12px] absolute animate-[pulse_2s_ease-in-out]">
                        <div class="w-[167px] h-[167px] left-0 top-0 absolute bg-ungu/10 rounded-full animate-[ping_1s_ease-in-out]"></div>
                        <div class="w-[137px] h-[137px] left-[15px] top-[15px] absolute bg-ungu/10 rounded-full animate-[ping_1.5s_ease-in-out]"></div>
                        <div class="w-[109px] h-[109px] left-[29px] top-[29px] absolute bg-ungu/10 rounded-full animate-[ping_2s_ease-in-out]"></div>
                        <div class="w-20 h-20 left-[44px] top-[43px] absolute bg-ungu rounded-[99px] justify-center items-center gap-2.5 inline-flex animate-[zoom_0.5s_ease-in-out]">
                            <div class="w-12 h-12 relative flex justify-center items-center">
                                <i class="fa-solid fa-check text-white text-4xl animate-[zoom_0.5s_ease-in-out]"></i>
                            </div>
                        </div>
                    </div>
                    <div class="w-[222px] h-[161px] left-0 top-0 absolute">
                        <div class="w-1.5 h-1.5 left-[25px] top-[29px] absolute bg-ungu rounded-full animate-[softPing_2s_ease-in-out_infinite]"></div>
                        <div class="w-1.5 h-1.5 left-[216px] top-[89px] absolute bg-ungu rounded-full animate-[softPing_2.5s_ease-in-out_infinite]"></div>
                        <div class="w-[3px] h-[3px] left-[192px] top-[158px] absolute bg-ungu rounded-full animate-[softPing_2s_ease-in-out_infinite]"></div>
                        <div class="w-[3px] h-[3px] left-[204px] top-[18px] absolute bg-ungu/40 rounded-full animate-[softPing_2.5s_ease-in-out_infinite]"></div>
                        <div class="w-[3px] h-[3px] left-0 top-[155px] absolute bg-ungu/40 rounded-full animate-[softPing_3s_ease-in-out_infinite]"></div>
                        <div class="w-[3px] h-[3px] left-[163px] top-0 absolute bg-ungu rounded-full animate-[softPing_3.5s_ease-in-out_infinite]"></div>
                        <div class="w-[3px] h-[3px] left-[15px] top-[119px] absolute bg-ungu rounded-full animate-[softPing_4s_ease-in-out_infinite]"></div>
                    </div>
                </div>
                <div class="self-stretch h-[88px] flex-col justify-center items-center gap-4 flex">
                    <div class="self-stretch text-[#252733] text-xl font-semibold w-full text-center">Yeay, Transaksimu Berhasil!</div>
                    <div class="self-stretch text-center text-[#74767f] text-sm font-normal">Danamu akan segera diproses ke UMKM yang kamu pilih</div>
                </div>
                <x-primary-button>
                    <a href="{{ route('investor.portofolio') }}">
                        <div class="text-white text-sm font-semibold font-['Poppins']">Lihat Portfolio</div>
                    </a>
                </x-primary-button>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    @keyframes zoom {
        0% {
            transform: scale(0);
        }
        100% {
            transform: scale(1);
        }
    }
    
    @keyframes ping {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    @keyframes softPing {
        0%, 100% {
            transform: scale(1);
            opacity: 0.5;
        }
        50% {
            transform: scale(1.5);
            opacity: 1;
        }
    }
</style>