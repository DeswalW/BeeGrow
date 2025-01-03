<nav class="bg-white border-b border-gray-200 px-4 md:px-10 lg:px-20 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-wrap justify-between items-center">
      <div class="flex justify-start items-center">
        <!-- Button Toggle Sidebar -->
        @if(request()->routeIs('dashboard'))
            <button
                data-drawer-target="filter"
                data-drawer-toggle="filter"
                aria-controls="filter"
                class="p-1 w-8 h-8 mr-2 text-gray-400 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >
                <i class="fa-solid fa-filter"></i>
                <span class="sr-only">Toggle sidebar</span>
            </button>
        @endif

        <!-- Logo Aplicación -->
        <x-application-logo class="hidden md:block"/>
      </div>

      <div class="flex items-center lg:order-2 gap-1 md:gap-6">
        <!-- Explore -->
        <x-nav-link :icon="html_entity_decode('<i class=\'fa-solid fa-store\'></i>')" :href="route('dashboard')"  :active="request()->routeIs('dashboard', 'home')" class="flex items-center gap-2">
            <span class="hidden md:block">
                {{ __('Explore') }}
            </span>
        </x-nav-link>

        <!-- Menu untuk Investor -->
        @if(Auth::check() && Auth::user()->hasRole('investor'))
        <x-nav-link :icon="html_entity_decode('<i class=\'fa-solid fa-wallet\'></i>')" :href="route('investor.portofolio')" :active="request()->routeIs('investor.portofolio')" class="flex items-center gap-2">
            <span class="hidden md:block">
                {{ __('Portofolio') }}
            </span>
        </x-nav-link>

        <x-nav-link :icon="html_entity_decode('<i class=\'fa-solid fa-cart-shopping\'></i>')" :href="route('investor.keranjang')" :active="request()->routeIs('investor.keranjang')" class="flex items-center gap-2 relative">
          <span class="hidden md:block">
              {{ __('Keranjang') }}
          </span>
          <div id="cart-icon" class="relative">
              <span id="cart-count" class="absolute -top-6 -right-5 bg-ungu outline outline-offset-0 outline-4 outline-[#E6E2FF] text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center">
                  {{ count(session()->get('keranjang', [])) }}
              </span>
          </div>
        </x-nav-link>
        @endif

        <!-- Menu untuk UMKM -->
        @if(Auth::check() && Auth::user()->hasRole('umkm'))
        <x-nav-link :icon="html_entity_decode('<i class=\'fa-solid fa-file-alt\'></i>')" :href="route('umkm.projects.create')" :active="request()->routeIs('umkm.projects.create')" class="flex items-center gap-2">
            <span class="hidden md:block">
                {{ __('Ajukan Pendanaan') }}
            </span>
        </x-nav-link>

        <x-nav-link :icon="html_entity_decode('<i class=\'fa-solid fa-chart-line\'></i>')" :href="route('umkm.projects.create')" :active="request()->routeIs('umkm.projects.index')" class="flex items-center gap-2">
            <span class="hidden md:block">
                {{ __('Laporan Kemajuan') }}
            </span>
        </x-nav-link>

        <x-nav-link :icon="html_entity_decode('<i class=\'fa-solid fa-plus\'></i>')" :href="route('umkm.projects.create')" :active="request()->routeIs('umkm.projects.create')" class="flex items-center gap-2">
            <span class="hidden md:block">
                {{ __('Tambah Proyek') }}
            </span>
        </x-nav-link>
        @endif

        <!-- User Menu -->
        @if (Auth::check())
        <button
          type="button"
          class="flex mx-3 text-sm bg-white px-2 py-2 border border-gray-200 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
          id="user-menu-button"
          aria-expanded="false"
          data-dropdown-toggle="dropdown"
        >
            <div class="flex items-center gap-4">
                <img
                  class="w-8 h-8 rounded-full"
                  src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                  alt="user photo"
                />
                <div class="hidden md:block">
                  <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->name }}</span>
                  <i class="fa-solid fa-chevron-down"></i>
                </div>
                <span class="sr-only">Open user menu</span>
            </div>
        </button>
        <!-- Dropdown menu -->
        <div
          class="hidden z-50 my-4 w-56 text-base list-none bg-white divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
          id="dropdown"
        >
          <div class="py-3 px-4">
            <span
              class="block text-sm font-semibold text-gray-900 dark:text-white"
              >{{ Auth::user()->name }}</span
            >
            <span
              class="block text-sm text-gray-900 truncate dark:text-white"
              >{{ Auth::user()->email }}</span
            >
          </div>
          <ul
            class="py-1 text-gray-700 dark:text-gray-300"
            aria-labelledby="dropdown"
          >
            <li>
              <form method="POST" action="{{ route('logout') }}" class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                @csrf
                <button type="submit">
                    Logout
                </button>
            </form>
            </li>
          </ul>
        </div>
      @else
        <x-primary-button class="w-20">
          <a href="{{ route('login') }}">
              {{ __('Masuk') }}
          </a>
        </x-primary-button>
    @endif
      </div>
    </div>
  </nav>