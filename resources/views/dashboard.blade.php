<x-app-layout>
    <div class="antialiased bg-[#FAFAFA] dark:bg-gray-900">
    @include('layouts.navigation')

    <!-- Sidebar -->
    @include('components.filter-side')

    <main class="md:ml-80 h-auto pt-24 pr-20">
      <x-projects-umkm :provinces="$provinces" :projects="$projects" />
    </main>
  </div>
</x-app-layout>