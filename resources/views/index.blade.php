<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Savings') }}
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

            {{-- Display fail message --}}
            @if (session('error'))
                <div class="mb-4 text-sm font-medium text-red-600 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <button
                        class="text-green-600 hover:text-green-900 text-2xl p-4"
                        onclick="openNewModal()"
                    >
                        <i class="fa-solid fa-plus"></i> New Savings
                </button>

                <div class="grid grid-cols-1 "> {{-- Add if needed - lg:grid-cols-2 --}}

                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">Name</th>
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">Amount</th>
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">End Date</th>
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">Organisation</th>
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">Saver</th>
                                    {{-- <th class="px-4 py-2 font-semibold text-black dark:text-white">Active</th> --}}

                                    {{-- <th class="px-4 py-2 font-semibold text-black dark:text-white">Is Fixed</th> --}}
                                    {{-- <th class="px-4 py-2 font-semibold text-black dark:text-white">Interest Rate</th>--}}
                                    {{-- <th class="px-4 py-2 font-semibold text-black dark:text-white">Start Date</th>--}}
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">Account Type</th>
                                    {{-- <th class="px-4 py-2 font-semibold text-black dark:text-white">Type</th>--}}


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($savings as $saving)
                                    @if($saving->is_active == 1)
                                        <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <td class="px-4 py-2">{{ $saving->name }}</td>
                                            <td class="px-4 py-2">£{{ number_format($saving->amount, 2) }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($saving->end_date)->format('d-M-Y') }}</td>
                                            <td class="px-4 py-2">{{ $saving->organisation_name }}</td>
                                            <td class="px-4 py-2">{{ $saving->saver }}</td>
                                            {{-- <td class="px-4 py-2">{{ $saving->is_active }}</td> --}}
                                            {{-- Look up the type name from the type_id  --}}

                                            <td class="px-4 py-2">{{ $saving->type_name }}</td>
                                        </tr>
                                    @endif
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

    {{-- End of savings list table --}}

    {{-- Modals --}}

    {{-- New Saving Modal --}}
    <div id="newSavingModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Modal background -->
        <div class="absolute inset-0 bg-black bg-opacity-25 w-full h-full" onclick="closeNewModal()"></div>

        <!-- Modal content - new -->
        <div class="relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-6" onclick="event.stopPropagation()">
            <button class="absolute top-2 right-2 text-black hover:text-black text-4xl"
                onclick="closeNewModal()">
                &times;
            </button>
            <h2 class="text-2xl font-semibold text-center">New Saving</h2>
            <form
                action="{{ route('savings.store') }}"
                method="POST"
                >
                @csrf
                <!-- Hidden input for organisation ID -->
                <input type="hidden" name="id" id="SavingsId">

                {{-- Name field --}}
                <div class="mb-4">
                    <label for="SavingsName" class="block text-gray-700">Name</label>
                    <input
                        type="text"
                        id="SavingsName"
                        name="name"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="SavingsDescription" class="block text-gray-700">Description</label>
                    <textarea
                        id="SavingsDescription"
                        name="description"
                        class="w-full border rounded p-2"
                        rows="4"
                    ></textarea>
                </div>

                <!-- Amount Field -->
                <div class="mb-4">
                    <label for="SavingsAmount" class="block text-gray-700">Amount</label>
                    <input
                        type="number"
                        id="SavingsAmount"
                        name="amount"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                {{-- Fixed term checkbox - default = no--}}
                <div class="mb-4">
                    <label for="SavingsIsFixed" class="block text-gray-700">Ficed term account?</label>
                    <input
                        type="checkbox"
                        id="SavingsIsFixed"
                        name="is_fixed"
                        class="border rounded p-2"
                        unchecked

                    />
                </div>

                <!-- End Date Field -->
                <div class="mb-4">
                    <label for="SavingsEndDate" class="block text-gray-700">End Date</label>
                    <input
                        type="date"
                        id="SavingsEndDate"
                        name="end_date"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                <!-- Organisation Field -->
                <div class="mb-4">
                    <label for="SavingsOrganisation" class="block text-gray-700">Organisation</label>
                    <select
                        id="SavingsOrganisation"
                        name="organisation_id"
                        class="w-full border rounded p-2"
                        required
                    >
                        <option value="">Select Organisation</option>
                        @foreach ($organisations as $organisation)
                            <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Saver Field -->
                <div class="mb-4">
                    <label for="SavingsSaver" class="block text-gray-700">Saver</label>
                    <input
                        type="text"
                        id="SavingsSaver"
                        name="saver"
                        class="w-full border rounded p-2"
                        required
                        default="Alison"
                    />
                </div>

                <!-- Active Field -->
                <div class="mb-4">
                    <label for="SavingsActive" class="block text-gray-700">Active</label>
                    <select
                        id="SavingsActive"
                        name="is_active"
                        class="w-full border rounded p-2"
                        required
                    >
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <!-- Type Field -->
                <div class="mb-4">
                    <label for="SavingsType" class="block text-gray-700">Type</label>
                    <select
                        id="SavingsType"
                        name="type_id"
                        class="w-full border rounded p-2"
                        required
                    >
                        <option value="">Select Type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- transferred from --}}
                <div class="mb-4">
                    <label for="SavingsTransferredFrom" class="block text-gray-700">Transferred From</label>
                    <select
                        id="SavingsTransferredFrom"
                        name="transferred_from"
                        class="w-full border rounded p-2"
                        required
                    >
                        <option value="">Select Account</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
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

    <script>
        function openNewModal() {
        // Display the modal
            const editModal = document.getElementById('newSavingModal');
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        };

        function closeNewModal() {
            // Hide the modal
            const editModal = document.getElementById('newSavingModal');
            editModal.classList.remove('flex');
            editModal.classList.add('hidden');
            document.getElementById('SavingsName').value = '';
            document.getElementById('SavingsDescription').value = '';
            document.getElementById('SavingsAmount').value = '';
            document.getElementById('SavingsEndDate').value = '';

        };
    </script>


</x-app-layout>
