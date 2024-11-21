<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Types of Savings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Display success message --}}
            @if (session('success'))
                <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif


            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <button
                        class="text-green-600 hover:text-green-900 text-2xl p-4"
                        onclick="openNewModal()"
                    >
                        <i class="fa-solid fa-plus"></i> New type
                    </button>
                <div class="grid grid-cols-1 "> {{-- Add if needed - lg:grid-cols-2 --}}

                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                    <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2">{{ $type->name }}</td>
                                        <td class="px-4 py-2">
                                            {{-- <a href="{{ route('type.show', $type->id) }}" class="text-blue-600 hover:text-blue-900" target="_blank">View</a> --}}
                                            <button class="text-blue-600 hover:text-blue-900 mr-4" onclick="openModal({{ $type->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button
                                                class="text-green-600 hover:text-green-900 mr-4"
                                                onclick="openEditModal({{ $type->id }})"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <form
                                                action="{{ route('type.destroy', $type->id) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this type?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex justify-center p-6">
                    <p> <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Dashboard</a></p>
                </div>
            </div>
        </div>
    </div>

    {{-- End of type list table --}}

    {{-- Modal for org show data --}}
    <div id="typeModal" class="fixed inset-0 z-50 hidden items-center justify-center ">
        {{-- Modal background --}}
        <div class="absolute inset-0 bg-black bg-opacity-25 w-full h-full m-0" onclick="closeModal()"></div>
        {{-- Modal content --}}
        <div class="modalContent relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-4">
            <button
                class="absolute top-1 right-2 text-black hover:text-black text-4xl"
                onclick="closeModal()"
            >
                &times;
            </button>
            <h2 class="text-xl font-bold mb-4" id="typeName">Type</h2>

        </div>
    </div>

    {{-- Modal for org create --}}
    <div id="newTypeModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Modal background -->
        <div class="absolute inset-0 bg-black bg-opacity-25 w-full h-full" onclick="closeNewModal()"></div>

        <!-- Modal content - new -->
        <div class="relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-6" onclick="event.stopPropagation()">
            <button class="absolute top-2 right-2 text-black hover:text-black text-4xl"
                onclick="closeNewModal()">
                &times;
            </button>

            <h2 class="text-xl font-bold mb-4">Create an type</h2>
            <form id="newtypeForm"
                method="POST"
                action="{{ route('type.store') }}"
                {{-- onsubmit="submitForm(event)" --}}
                >
                @csrf
                {{-- @method('PUT') --}}

                <!-- Hidden input for type ID -->
                <input type="hidden" name="id" id="typeId">
                {{-- <input type="hidden" name="_method" value="PUT"> --}}

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="typeName" class="block text-gray-700">Name</label>
                    <input
                        type="text"
                        id="typeName"
                        name="name"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-800"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal for org edit --}}
    <div id="editTypeModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Modal background -->
        <div
            class="absolute inset-0 bg-black bg-opacity-25 w-full h-full"
            onclick="closeEditModal()"
        ></div>

        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-6" onclick="event.stopPropagation()">
            <button class="absolute top-2 right-2 text-black hover:text-black text-3xl" onclick="closeEditModal()">
                &times;
            </button>
            <h2 class="text-xl font-bold mb-4">Edit type</h2>
            <form id="editTypeForm"
                method="POST"
                action="{{ route('type.update', $type->id) }}"
                >

                @csrf
                @method('PUT')

                <!-- Hidden input for type ID -->
                <input name="id" type="hidden" id="editTypeId">

                <input type="hidden" name="_method" value="PUT">

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="editTypeName" class="block text-gray-700">Name</label>
                    <input
                        type="text"
                        id="editTypeName"
                        name="name"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-800">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>
{{-- button to go to dashboard   --}}


    {{-- <script src="{{ asset('js/type.js') }}"></script> --}}
    @vite('resources/js/type.js')

</x-app-layout>
