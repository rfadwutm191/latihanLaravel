<x-app-layout>
    <div x-data="{ open:false, setting:null }">

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Landing Page Settings
            </h2>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if (session('success'))
                    <div class="mb-4 p-4 rounded bg-green-200 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 rounded bg-red-200 text-red-800">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg">Landing Settings</h3>

                            <button
                                @click="setting={key:'',value:'',type:'text',status:1}; open=true"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                            >
                                + Tambah Setting
                            </button>
                        </div>

                        <table class="table-auto w-full border">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-3 py-2">Key</th>
                                    <th class="px-3 py-2">Value</th>
                                    <th class="px-3 py-2 w-24">Type</th>
                                    <th class="px-3 py-2 w-24">Status</th>
                                    <th class="px-3 py-2 w-24 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $setting)
                                <tr class="border-t">
                                    <td class="px-3 py-2 font-medium">{{ $setting->key }}</td>

                                    <td class="px-3 py-2">
                                        @if($setting->type === 'image' && is_string($setting->value) && $setting->value)
                                           <img src="{{ asset('storage/' . $setting->value) }}" class="h-16 rounded shadow">
                                        @elseif($setting->type === 'image')
                                            <div class="text-red-500 text-xs">No image uploaded</div>
                                        @elseif($setting->type === 'json')
                                            <pre class="bg-gray-100 p-2 rounded text-xs">
                                            {{ json_encode(json_decode($setting->value, true), JSON_PRETTY_PRINT) }}
                                            </pre>
                                        @else
                                            {{ Str::limit($setting->value, 60) }}
                                        @endif
                                    </td>

                                    <td class="px-3 py-2 capitalize">{{ $setting->type }}</td>

                                    <td class="px-3 py-2">
                                        <span class="{{ $setting->status ? 'text-green-600' : 'text-gray-500' }}">
                                            {{ $setting->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td class="px-3 py-2 text-center">
                                        <button
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                                            @click="open=true; setting={{ Js::from($setting) }}"
                                        >
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

       {{-- MODAL --}}
        <div
            x-show="open"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
            x-transition
        >
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-xl shadow-2xl mx-4"
            @click.away="open=false">

            <h2 class="text-xl font-semibold mb-4"
                x-text="setting && setting.id ? 'Edit Setting' : 'Tambah Setting'"></h2>

            <form method="POST"
                :action="setting && setting.id ? '{{ url('admin/landing/settings') }}/' + setting.id : '{{ route('admin.landing.settings.store') }}'"
                enctype="multipart/form-data">
                @csrf

                <template x-if="setting && setting.id">
                    @method('PUT')
                </template>
                <div class="mb-4">
                            <label class="block font-medium mb-1">Key</label>
                            <input type="text" name="key"
                                class="w-full border rounded px-3 py-2"
                                x-model="setting.key">
                        </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">Type</label>
                    <select name="type" class="w-full border rounded px-3 py-2" x-model="setting.type">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="image">Image</option>
                        <option value="json">JSON</option>
                    </select>
                </div>

                    {{-- FIELD UNTUK IMAGE --}}
                    <template x-if="setting && setting.type === 'image'">
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Upload Image</label>
                            <input type="file" name="image" class="w-full border rounded px-3 py-2" accept="image/*">
                            
                            {{-- Tampilkan gambar current --}}
                            <template x-if="setting && setting.value">
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600">Current Image:</p>
                                    <img :src="'{{ asset('storage') }}/' + setting.value" class="h-24 rounded shadow mt-2">
                                    <p class="text-xs text-gray-500 mt-1" x-text="setting.value"></p>
                                </div>
                            </template>
                        </div>
                    </template>

                    {{-- FIELD UNTUK NON-IMAGE --}}
                    <template x-if="setting && setting.type !== 'image'">
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Value</label>
                            
                            {{-- Textarea untuk type textarea dan json --}}
                            <template x-if="setting.type === 'textarea' || setting.type === 'json'">
                                <textarea name="value" rows="5"
                                        class="w-full border rounded px-3 py-2 font-mono"
                                        x-model="setting.value"></textarea>
                            </template>
                            
                            {{-- Input text untuk type text --}}
                            <template x-if="setting.type === 'text'">
                                <input type="text" name="value"
                                    class="w-full border rounded px-3 py-2"
                                    x-model="setting.value">
                            </template>
                        </div>
                    </template>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="status" value="1" class="rounded" 
                                :checked="setting ? setting.status : true">
                            <span class="ml-2">Active</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 mt-5">
                        <button type="button" @click="open=false"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Cancel
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            <span x-text="setting && setting.id ? 'Update' : 'Save'"></span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</x-app-layout>