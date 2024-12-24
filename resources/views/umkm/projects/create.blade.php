<x-app-layout>
    <div class="container mx-auto px-4 py-8 pt-24">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-6">Ajukan Proyek Pendanaan</h2>

                <form action="{{ route('umkm.projects.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    
                    <div>
                        <x-input-label for="title" value="Judul Proyek" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi Proyek" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="target_pendanaan" value="Target Pendanaan (Rp)" />
                        <x-text-input id="target_pendanaan" name="target_pendanaan" type="number" min="1000000" step="100000" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('target_pendanaan')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="deadline" value="Tenggat Waktu" />
                        <x-text-input id="deadline" name="deadline" type="date" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="images" value="Foto Proyek (Maksimal 5 foto)" />
                        <input type="file" 
                               name="images[]" 
                               id="images" 
                               accept="image/*" 
                               multiple 
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-ungu file:text-white
                                      hover:file:bg-ungu/80"
                               max="5"
                        />
                        <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, PNG. Ukuran maksimal: 2MB per foto</p>
                        <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4">
                        <x-secondary-button type="button" onclick="window.history.back()">
                            Batal
                        </x-secondary-button>
                        <x-primary-button type="submit">
                            Ajukan Proyek
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
