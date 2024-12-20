@props(['provinces'])

<aside
    class="absolute drawer top-0 left-0 z-40 px-6 md:pl-10 lg:pl-20 py-24 w-60 md:w-80 h-full transition-transform overflow-auto no-scrollbar bg-gray-50 -translate-x-full md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav"
    id="filter"
>
    <div class="flex flex-col">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Filter</h1>
            <button class="text-sm text-gray-500 hover:text-gray-700"><i class="fa-solid fa-xmark"></i> Reset filter</button>
        </div>
        <form method="GET" action="{{ route('dashboard') }}" class="space-y-4">
            @csrf
            <!-- Search -->
            <div>
                <div class="flex items-center mt-1 w-full px-3 bg-white ring-1 ring-gray-300 rounded-md shadow-sm focus-within:ring-ungu focus-within:border-ungu sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <button type="submit" class="border-none text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input type="text" name="search" id="search" class="border-none bg-transparent ring-0 focus:ring-0 focus:outline-none w-full text-sm" placeholder="Cari UMKM...">
                </div>
            </div>

        <!-- Rentang Dana Projek -->
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Rentang</label>
            <div class="mt-1 space-y-2 text-sm">
                <label class="flex items-center">
                    <input type="radio" name="funding_range" value=">20000000" class="form-radio text-ungu focus:ring-ungu dark:focus:ring-ungu">
                    <span class="ml-2 text-gray-700">> Rp20 juta</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="funding_range" value="20000000-50000000" class="form-radio text-ungu focus:ring-ungu dark:focus:ring-ungu">
                    <span class="ml-2 text-gray-700"> Rp20 juta - Rp50 juta</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="funding_range" value="50000000-100000000" class="form-radio text-ungu focus:ring-ungu dark:focus:ring-ungu">
                    <span class="ml-2 text-gray-700">Rp50 juta - Rp100 juta</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="funding_range" value="100000000-300000000" class="form-radio text-ungu focus:ring-ungu dark:focus:ring-ungu">
                    <span class="ml-2 text-gray-700">Rp100 juta - Rp300 juta</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="funding_range" value="<300000000" class="form-radio text-ungu focus:ring-ungu dark:focus:ring-ungu">
                    <span class="ml-2 text-gray-700"> < Rp300 juta</span>
                </label>
            </div>
        </div>

        <!-- Kategori UMKM -->
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">Kategori UMKM</label>
            <div class="space-y-2 text-sm">
                @foreach($categories as $category)
                    <label class="flex items-center">
                        <input type="checkbox" name="category[]" value="{{ $category->id }}" class="form-checkbox h-4 w-4 text-ungu focus:ring-ungu dark:focus:ring-ungu rounded-sm">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Lama UMKM Berdiri -->
        <div>
            <label for="established_years" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Lama UMKM Berdiri</label>
            <input type="number" name="established_years" id="established_years" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ungu focus:border-ungu sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Tahun">
        </div>

        <div>
            <label for="province" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Provinsi</label>
            <select name="province" id="province" class="text-gray-700 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ungu focus:border-ungu sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="">Pilih Provinsi</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label for="city" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Kota</label>
            <select name="city" id="city" class="text-gray-700 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ungu focus:border-ungu sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="">Pilih Kota</option>
            </select>
        </div>
        
        <script>
            document.getElementById('province').addEventListener('change', function() {
                var provinceId = this.value;
                var citySelect = document.getElementById('city');
                citySelect.innerHTML = '<option value="">Pilih Kota</option>'; // Reset city options
        
                if (provinceId) {
                    fetch(`/api/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(city => {
                                var option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                }
            });
        </script>
        
        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full px-4 py-2 text-sm text-white bg-ungu rounded-full shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ungu">
                Terapkan
                </button>
            </div>
        </form>
    </div>  
</aside>