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

                                            <td class="px-4 py-2">{{ $saving->end_date ? \Carbon\Carbon::parse($saving->end_date)->format('d-M-Y') : '' }}
                                            </td>
                                            <td class="px-4 py-2">{{ $saving->organisation_name }}</td>
                                            <td class="px-4 py-2">{{ $saving->saver }}</td>
                                            <td class="px-4 py-2">{{ $saving->type_name }}</td>
                                            <td class="px-4 py-2">
                                                {{-- <a href="{{ route('organisation.show', $organisation->id) }}" class="text-blue-600 hover:text-blue-900" target="_blank">View</a> --}}
                                                <button class="text-blue-600 hover:text-blue-900 mr-4" onclick="openModal({{ $saving->id }})">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button
                                                    class="text-green-600 hover:text-green-900 mr-4"
                                                    onclick="openEditModal({{ $saving }})"
                                                >
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <form
                                                    action="{{ route('savings.destroy', $saving->id) }}"
                                                    method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this organisation?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>

                                            </td>
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
    <div id="newSavingModal" class="fixed inset-0 z-50 hidden items-center justify-center h-full">
        <!-- Modal background -->
        <div class="absolute inset-0 bg-black bg-opacity-25 w-full h-full" onclick="closeNewModal()"></div>

        <!-- Modal content - new -->
        <div class="relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-6 max-h-full overflow-auto" onclick="event.stopPropagation()">
            <button class="absolute top-2 right-2 text-black hover:text-black text-4xl"
                onclick="closeNewModal()">
                &times;
            </button>
            <h2 class="text-2xl font-semibold text-center">New Saving</h2>
            <form
                action="{{ route('savings.store') }}"
                method="POST"
                id="savingForm"
                >
                @csrf
                <!-- Hidden input for savings ID -->
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
                <div class="mb-4" >
                    <label for="SavingsIsFixed" class="block text-gray-700">Fixed term account?</label>
                    <input type="hidden" name="is_fixed" value="0">
                    <input
                        type="checkbox"
                        id="SavingsIsFixed"
                        name="is_fixed"
                        class="border rounded p-2"
                        unchecked
                        value="1"
                        onchange="toggleEndDateField()"
                    />
                </div>

                <!-- End Date Field -->
                <div class="mb-4 hidden" id="endDateField">
                    <label for="SavingsEndDate" class="block text-gray-700">End Date</label>
                    <input
                        type="date"
                        id="SavingsEndDate"
                        name="end_date"
                        class="w-full border rounded p-2"
                    />
                </div>

                <!-- Organisation Field -->
                <div class="mb-4" >
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

                {{-- Saver Field --}}
                <div class="mb-4">
                    <label for="SavingsSaver" class="block text-gray-700">Saver</label>
                    <select
                        id="SavingsSaver"
                        name="saver"
                        class="w-full border rounded p-2"
                        required
                    >
                        <option value="">Select Saver</option>
                            <option value="Alison">
                                Alison
                            </option>
                            <option value="Martin">
                                Martin
                            </option>
                            <option value="Michael">
                                Michael
                            </option>
                            <option value="Ben">
                                Ben
                            </option>
                            <option value="Joint">
                                Joint
                            </option>
                    </select>
                </div>

                <!-- Active Field check box-->
                <div class="mb-4">
                    <label for="SavingsActive" class="block text-gray-700">Active</label>
                    {{-- checkbox --}}
                    <input type="hidden" name="is_active" value="0">
                    <input
                        type="checkbox"
                        id="SavingsActive"
                        name="is_active"
                        class="border rounded p-2"
                        checked
                        value="1"
                    />
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
                        name="transfer_id"
                        class="w-full border rounded p-2"
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
        </div>
    </div>

    {{-- Modal for savings show data --}}
    <div id="savingsModal" class="fixed inset-0 z-50 hidden items-center justify-center h-full">
        {{-- Modal background --}}
        <div class="absolute inset-0 bg-black bg-opacity-25 w-full h-full m-0" onclick="closeShowModal()"></div>
        {{-- Modal content --}}
        <div class="modalContent relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-4">
            <button
                class="absolute top-1 right-2 text-black hover:text-black text-4xl"
                onclick="closeShowModal()"
            >
                &times;
            </button>
            <h2 class="text-xl font-bold mb-4">Savings Details</h2>
            <table class="w-full border-collapse border border-gray-300">
                <tbody>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700 w-1/3">Name</td>
                        <td id="savingsName" class="p-2 text-gray-800">Loading...</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">Description</td>
                        <td id="savingsDescription" class="p-2 text-gray-800">Loading...</td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">Amount</td>
                        <td id="savingsAmount" class="p-2 text-gray-800"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">Fixed Term</td>
                        <td id="savingsIsFixed" class="p-2 text-gray-800"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">End Date</td>
                        <td id="savingsEndDate" class="p-2 text-gray-800"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">Organisation</td>
                        <td id="savingsOrganisation" class="p-2 text-gray-800"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">Saver</td>
                        <td id="savingsSaver" class="p-2 text-gray-800"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">Active</td>
                        <td id="savingsActive" class="p-2 text-gray-800"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="text-left p-2 font-medium text-gray-700">Type</td>
                        <td id="savingsType" class="p-2 text-gray-800"></td>
                    </tr>
                    <tr>
                        <td class="text-left p-2 font-medium text-gray-700">Transferred From</td>
                        <td id="savingsTransferredFrom" class="p-2 text-gray-800"></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>



    <script>

        const savingsData = @json($savings);

        function openModal(savingsId) {
            console.log('Opening modal for savings:', savingsId);

            const saving = savingsData.find(item => item.id === savingsId);

            console.log(saving);
            // Show the modal
            document.getElementById('savingsModal').classList.remove('hidden');
            document.getElementById('savingsModal').classList.add('flex');

            // Clear existing content
            document.getElementById("savingsName").innerText = '';
            document.getElementById("savingsDescription").innerText = '';
            document.getElementById("savingsAmount").innerText = '';
            document.getElementById("savingsIsFixed").innerText = '';
            document.getElementById("savingsEndDate").innerText = '';
            document.getElementById("savingsOrganisation").innerText = '';
            document.getElementById("savingsSaver").innerText = '';
            document.getElementById("savingsActive").innerText = '';
            document.getElementById("savingsType").innerText = '';
            document.getElementById("savingsTransferredFrom").innerText = '';

            // Populate fields with saving data
            if (saving) {
                // Populate modal fields with saving data
                document.getElementById("savingsName").innerText = saving.name;
                document.getElementById("savingsDescription").innerText = saving.description;
                document.getElementById("savingsAmount").innerText = saving.amount;
                document.getElementById("savingsIsFixed").innerText = saving.is_fixed ? "Yes" : "No";
                if(saving.is_fixed) {
                    document.getElementById("savingsEndDate").innerText = saving.end_date;
                } else {
                    document.getElementById("savingsEndDate").innerText = '';
                }
                document.getElementById("savingsEndDate").innerText = saving.end_date || '';
                document.getElementById("savingsOrganisation").innerText = saving.organisation_name;
                document.getElementById("savingsSaver").innerText = saving.saver;
                document.getElementById("savingsActive").innerText = saving.is_active ? "Active" : "Inactive";
                document.getElementById("savingsType").innerText = saving.type_name;
                document.getElementById("savingsTransferredFrom").innerText = saving.transfer_id || 'N/A';


            } else {
                console.error("Saving not found for ID:", savingsId);
            }
        }

        function openNewModal() {

            const modal = document.getElementById("newSavingModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");

            const form = document.getElementById("savingForm");
            // Set up modal for "New Saving"
            document.getElementById("newSavingModal").classList.remove("hidden");
            document.getElementById("newSavingModal").classList.add("flex");

            // modalTitle = "New Saving";
            form.action = "{{ route('savings.store') }}";
            form.method = "POST";

            // Remove any existing _method input to avoid conflicts
            let existingMethodInput = form.querySelector('input[name="_method"]');
            console.log("Existing method input:", existingMethodInput);
            if (existingMethodInput) {
                existingMethodInput.remove();
                console.log("Removed existing _method input from the edit form");
            }

             // Remove the hidden ID input if it exists
            const idInput = document.getElementById("SavingsId");
            if (idInput) {
                idInput.remove();
                console.log("Removed existing ID input from the form");
            }


            modal.classList.remove("hidden");
        }



        function openEditModal(saving) {
            // Set up modal for "Edit Saving"
            const modal = document.getElementById("newSavingModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");

            const form = document.getElementById("savingForm"); // Target the edit form explicitly

            // Set form action and method for editing
            form.action = `{{ route('savings.update', ':id') }}`.replace(':id', saving.id);
            form.method = "POST";

            // Remove any existing _method input to avoid conflicts
            let existingMethodInput = form.querySelector('input[name="_method"]');
            if (existingMethodInput) {
                existingMethodInput.remove();
                console.log("Removed existing _method input from the edit form");
            }

            // Add a new _method input with value "PUT"
            const newMethodInput = document.createElement("input");
            newMethodInput.type = "hidden";
            newMethodInput.name = "_method";
            newMethodInput.value = "PUT";
            form.appendChild(newMethodInput);
            console.log("Added new _method input with value PUT to the edit form");

            const idInput = document.createElement("input");
            idInput.type = "hidden";
            idInput.name = "id";
            idInput.value = saving.id;
            form.insertBefore(idInput, form.firstChild);

            // Populate fields with saving data
            document.getElementById("SavingsId").value = saving.id;
            document.getElementById("SavingsName").value = saving.name;
            document.getElementById("SavingsDescription").value = saving.description;
            document.getElementById("SavingsAmount").value = saving.amount;
            document.getElementById("SavingsIsFixed").checked = saving.is_fixed;
            document.getElementById("SavingsEndDate").value = saving.end_date || '';
            document.getElementById("SavingsOrganisation").value = saving.organisation_id;
            document.getElementById("SavingsSaver").value = saving.saver;
            document.getElementById("SavingsActive").value = saving.is_active;
            document.getElementById("SavingsType").value = saving.type_id;
            document.getElementById("SavingsTransferredFrom").value = saving.transfer_id || '';

            // Show the modal
            modal.classList.remove("hidden");
        }


        function closeNewModal() {
            // Hide the modal
            const editModal = document.getElementById('newSavingModal');
            editModal.classList.remove('flex');
            editModal.classList.add('hidden');
            document.getElementById('SavingsName').value = '';
            document.getElementById('SavingsDescription').value = '';
            document.getElementById('SavingsAmount').value = '';
            document.getElementById('SavingsEndDate').value = '';
            document.getElementById('SavingsOrganisation').value = '';
            document.getElementById('SavingsSaver').value = '';
            document.getElementById('SavingsActive').value = '';
            document.getElementById('SavingsType').value = '';
            document.getElementById('SavingsTransferredFrom').value = '';
        };

        function closeShowModal() {
            // Hide the modal
            const editModal = document.getElementById('savingsModal');

            document.getElementById('savingsName').innerText = '';
            document.getElementById('savingsDescription').innerText = '';
            document.getElementById('savingsAmount').innerText = '';
            document.getElementById('savingsEndDate').innerText = '';
            document.getElementById('savingsOrganisation').innerText = '';
            document.getElementById('savingsSaver').innerText = '';
            document.getElementById('savingsActive').innerText = '';
            document.getElementById('savingsType').innerText = '';
            document.getElementById('savingsTransferredFrom').innerText = '';
            editModal.classList.remove('flex');
            editModal.classList.add('hidden');
        };


        // Ensure the end date field is displayed based on initial checkbox state
        document.addEventListener('DOMContentLoaded', function() {
            toggleEndDateField();
        });

        function toggleEndDateField() {
            const checkbox = document.getElementById('SavingsIsFixed');
            const endDateField = document.getElementById('endDateField');

            // Toggle visibility using Tailwind classes
            if (checkbox.checked) {
                endDateField.classList.remove('hidden');  // Show the End Date field
            } else {
                endDateField.classList.add('hidden');     // Hide the End Date field
                document.getElementById('SavingsEndDate').value = ''; // Reset the value
            }
        }

    </script>


</x-app-layout>
