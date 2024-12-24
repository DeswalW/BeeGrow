<section class="antialiased dark:bg-gray-900">
    <div class="mx-auto w-max-screen-xl 2xl:pl-6">
      <!-- Heading & Filters -->
      <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-4">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Proyek UMKM</h2>
      </div>
      <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($projects as $project)
            <div class="rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 overflow-hidden hover:shadow-lg transition-all duration-300 hover:scale-105">
                <a href="{{ route('project', ['project_id' => $project->id]) }}" class="block cursor-auto">
                    <div class="h-32 w-full relative">
                        <a href="{{ route('project', ['project_id' => $project->id]) }}">
                            <img class="object-cover mx-auto h-32 w-full dark:hidden" src="{{ Storage::url($project->images->first()->image_path) }}" alt="{{ $project->title }}" />
                            <img class="object-cover mx-auto hidden h-32 w-full dark:block" src="{{ Storage::url($project->images->first()->image_path) }}" alt="{{ $project->title }}" />
                        </a>
                        <span class="absolute top-2 right-3 px-2 py-1 text-xs text-white dark:text-primary-300 backdrop-blur-[2px] rounded-full
                        {{ $project->status === 'Sedang Berlangsung' ? 'bg-ungu bg-opacity-50' : 'bg-kuning bg-opacity-50' }}">
                            {{ $project->status }}
                        </span>
                    </div>
                    <div class="py-4 px-4 flex flex-col h-full">
                        <a href="{{ route('project', ['project_id' => $project->id]) }}" class="h-6 md:h-14 mb-4 block line-clamp-2 text-md font-semibold leading-tight text-gray-900 dark:text-white">
                            {{ $project->title }}
                        </a>
                        <div class="flex flex-col space-y-2 h-full">
                            <div class="flex justify-between items-center">
                                <div class="flex justify-start items-start flex-col">
                                    <p class="text-xs text-gray-500 dark:text-gray-500">Target Pendanaan</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        Rp{{ number_format($project->fundingDetails->target_pendanaan) }}
                                    </p>
                                </div>
                                <div class="flex justify-end items-end flex-col">
                                    <p class="text-xs text-gray-500 dark:text-gray-500">Dana Terkumpul</p>
                                    <p class="text-sm font-semibold text-ungu dark:text-white">
                                        Rp{{ number_format($project->fundingDetails->dana_terkumpul) }}
                                    </p>
                                </div>
                            </div>
    
                            <div class="w-full bg-gray-200 rounded-full h-1 dark:bg-gray-700">
                                <div class="bg-ungu h-1 rounded-full" style="width: {{ min(100, ($project->fundingDetails->dana_terkumpul / $project->fundingDetails->target_pendanaan) * 100) }}%"></div>
                            </div>
    
                            <div class="flex justify-between items-center">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $project->deadline->diffForHumans(null, true, false, 1) . ' lagi'}}
                                </p>
            
                                <div class="flex items-center justify-between text-ungu">
                                    <a href="{{ route('project', ['project_id' => $project->id]) }}" class="flex items-center">
                                        <p class="text-xs font-medium dark:text-gray-400">Lihat Detail</p>
                                        <i class="ml-2 fa-solid fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
      </div>
      <div class="w-full text-center">
        <button type="button" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 mb-10">Show more</button>
      </div>
    </div>
</section>