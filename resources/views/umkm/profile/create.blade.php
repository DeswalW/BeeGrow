<x-app-layout>
    <div class="container mx-auto px-4 py-8 pt-24">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-6">Lengkapi Profil UMKM</h2>

                <form action="{{ route('umkm.profile.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="name" value="Nama UMKM" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi UMKM" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="contact" value="Kontak" />
                        <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="address" value="Alamat" />
                        <textarea id="address" name="address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category" value="Kategori UMKM" />
                        <select id="category" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button type="submit">
                            Simpan Profil
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 