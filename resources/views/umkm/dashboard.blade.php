<x-app-layout>
    <div class="container mx-auto px-4 py-8 pt-24">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Proyek Saya</h1>
            <x-primary-button onclick="window.location.href='{{ route('umkm.projects.create') }}'">
                <i class="fas fa-plus mr-2"></i>
                Tambah Proyek
            </x-primary-button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Target:</span>
                                <span class="font-semibold">Rp{{ number_format($project->fundingDetails->target_pendanaan) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Terkumpul:</span>
                                <span class="text-ungu font-semibold">Rp{{ number_format($project->fundingDetails->dana_terkumpul) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-2 py-1 rounded-full text-sm {{ $project->status === 'Sedang Berlangsung' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $project->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-folder-open text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500">Belum ada proyek yang ditambahkan</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout> 