<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Programs') }}
        </h2>
    </x-slot>

    <div x-data="programPage()" x-cloak class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 dark:text-green-900 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Button Add --}}
            <div class="mb-6">
                <button @click="openCreateModal()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Program
                </button>
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-white">
                        Daftar Programs
                    </h3>

                    <table class="table-auto w-full border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-white">
                            <tr>
                                <th class="px-4 py-2 text-center w-20">Gambar</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Icon</th>
                                <th class="px-4 py-2 text-center w-24">Pos</th>
                                <th class="px-4 py-2 text-center w-24">Status</th>
                                <th class="px-4 py-2 text-center w-40">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-800 dark:text-white">
                            @foreach($programs as $program)
                            <tr>
                                <td class="border px-4 py-2 text-center">
                                    @if($program->image)
                                        <img src="{{ asset('storage/'.$program->image) }}" class="h-12 mx-auto rounded">
                                    @else
                                        <span class="text-sm italic opacity-70">–</span>
                                    @endif
                                </td>

                                <td class="border px-4 py-2">{{ $program->title }}</td>
                                <td class="border px-4 py-2">{{ $program->icon }}</td>
                                <td class="border px-4 py-2 text-center">{{ $program->position }}</td>

                                <td class="border px-4 py-2 text-center">
                                    <span class="px-2 py-1 rounded text-white {{ $program->status ? 'bg-green-600' : 'bg-red-600' }}">
                                        {{ $program->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td class="border px-4 py-2 text-center">
                                    <button @click='openEditModal(@json($program))'
                                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.landing.programs.destroy', $program->id) }}"
                                          method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Hapus program ini?')"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>

        {{-- MODAL CREATE --}}
        <div x-show="showCreate" x-cloak
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
            x-transition>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Tambah Program</h2>

                <form method="POST" action="{{ route('admin.landing.programs.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1 dark:text-white">Title</label>
                        <input type="text" name="title"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               required>
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Description</label>
                        <textarea name="description"
                                  class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Icon</label>
                        <input type="text" name="icon"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Position</label>
                        <input type="number" name="position" value="0"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               required>
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Image</label>
                        <input type="file" name="image"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Status</label>
                        <select name="status"
                                class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showCreate=false"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Batal
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="showEdit" x-cloak
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
            x-transition>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Edit Program</h2>

                <form method="POST"
                      :action="'/admin/landing/programs/' + editData.id"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <label class="block mb-1 dark:text-white">Title</label>
                        <input type="text" name="title" x-model="editData.title"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               required>
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Description</label>
                        <textarea name="description" x-model="editData.description"
                                  class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Icon</label>
                        <input type="text" name="icon" x-model="editData.icon"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Position</label>
                        <input type="number" name="position" x-model="editData.position"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               required>
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Image (ganti jika perlu)</label>
                        <input type="file" name="image"
                               class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <template x-if="editData.image">
                            <img :src="'/storage/landing/programs/' + editData.image" class="mt-2 h-20 rounded">
                        </template>
                    </div>

                    <div>
                        <label class="block mb-1 dark:text-white">Status</label>
                        <select name="status" x-model="editData.status"
                                class="border-gray-300 rounded-md w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeEditModal()"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Batal
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    {{-- ALPINE CONTROLLER --}}
    <script>
        function programPage() {
            return {
                showCreate: false,
                showEdit: false,
                editData: {},

                openCreateModal() {
                    this.showCreate = true;
                    this.showEdit = false;
                    this.editData = {};
                },

                openEditModal(item) {
                    this.editData = {
                        id: item.id,
                        title: item.title,
                        description: item.description,
                        icon: item.icon,
                        position: item.position,
                        status: item.status,
                        image: item.image ?? ''
                    };
                    this.showEdit = true;
                    this.showCreate = false;
                },

                closeEditModal() {
                    this.showEdit = false;
                    this.editData = {};
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>