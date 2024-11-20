<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Organisations') }}
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

            {{-- Button to go to route orgranisat create --}}
            {{-- <a href="{{ route('organisation.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Organisation</a> --}}

            {{-- Display success message --}}

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <button
                        class="text-green-600 hover:text-green-900 text-4xl p-4"
                        onclick="openNewModal()"
                    >
                        <i class="fa-solid fa-plus"></i> New Organisation
                    </button>
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">Name</th>
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white">URL</th>
                                    <th class="px-4 py-2 font-semibold text-black dark:text-white"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($organisations as $organisation)
                                    <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2">{{ $organisation->name }}</td>
                                        <td class="px-4 py-2"><a href="{{ Str::startsWith($organisation->url, ['http://', 'https://']) ? $organisation->url : 'https://' . $organisation->url }}" target="_blank">Link</a></td>
                                        <td class="px-4 py-2">
                                            {{-- <a href="{{ route('organisation.show', $organisation->id) }}" class="text-blue-600 hover:text-blue-900" target="_blank">View</a> --}}
                                            <button class="text-blue-600 hover:text-blue-900" onclick="openModal({{ $organisation->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button
                                                class="text-green-600 hover:text-green-900"
                                                onclick="openEditModal({{ $organisation->id }})"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <form
                                                action="{{ route('organisation.destroy', $organisation->id) }}"
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- End of organisation list table --}}

    {{-- Modal for org show data --}}
    <div id="organisationModal" class="fixed inset-0 z-50 hidden items-center justify-center ">
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
            <h2 class="text-xl font-bold mb-4" id="organisationName">Organisation Details</h2>
            <div id="organisationDetails" class="text-gray-700">
                <!-- Organisation details will be dynamically injected here -->
                Loading...
            </div>
        </div>
    </div>

    {{-- Modal for org create --}}
    <div id="newOrganisationModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Modal background -->
        <div class="absolute inset-0 bg-black bg-opacity-25 w-full h-full" onclick="closeNewModal()"></div>

        <!-- Modal content - new -->
        <div class="relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-6" onclick="event.stopPropagation()">
            <button class="absolute top-2 right-2 text-black hover:text-black text-4xl"
                onclick="closeNewModal()">
                &times;
            </button>

            <h2 class="text-xl font-bold mb-4">Create an Organisation</h2>
            <form id="newOrganisationForm"
                method="POST"
                action="{{ route('organisation.store') }}"
                {{-- onsubmit="submitForm(event)" --}}
                >
                @csrf
                {{-- @method('PUT') --}}

                <!-- Hidden input for organisation ID -->
                <input type="hidden" name="id" id="OrganisationId">
                {{-- <input type="hidden" name="_method" value="PUT"> --}}

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="OrganisationName" class="block text-gray-700">Name</label>
                    <input
                        type="text"
                        id="OrganisationName"
                        name="name"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                <!-- URL Field -->
                <div class="mb-4">
                    <label for="OrganisationUrl" class="block text-gray-700">URL</label>
                    <input
                        type="url"
                        id="OrganisationUrl"
                        name="url"
                        class="w-full border rounded p-2"
                    />
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="OrganisationDescription" class="block text-gray-700">Description</label>
                    <textarea
                        id="OrganisationDescription"
                        name="description"
                        class="w-full border rounded p-2"
                        rows="4"
                    ></textarea>
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
    <div id="editOrganisationModal" class="fixed inset-0 z-50 hidden items-center justify-center">
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
            <h2 class="text-xl font-bold mb-4">Edit Organisation</h2>
            <form id="editOrganisationForm"
                method="POST"
                action="{{ route('organisation.update', $organisation->id) }}"
                {{-- onsubmit="submitForm(event)" --}}
                >

                @csrf
                @method('PUT')

                <!-- Hidden input for organisation ID -->
                <input name="id" type="hidden" id="editOrganisationId">

                <input type="hidden" name="_method" value="PUT">

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="editOrganisationName" class="block text-gray-700">Name</label>
                    <input
                        type="text"
                        id="editOrganisationName"
                        name="name"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                <!-- URL Field -->
                <div class="mb-4">
                    <label for="editOrganisationUrl" class="block text-gray-700">URL</label>
                    <input
                        type="url"
                        id="editOrganisationUrl"
                        name="url"
                        class="w-full border rounded p-2"
                        required
                    />
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="editOrganisationDescription" class="block text-gray-700">Description</label>
                    <textarea
                        id="editOrganisationDescription"
                        name="description"
                        class="w-full border rounded p-2"
                        rows="4"
                        required
                    ></textarea>
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





    <script>
        fetch('/organisation/1')
            .then(response => {
                console.log(response); // Inspect the raw response
                return response.text(); // Read the response as plain text to check if it's valid JSON
            })
            .then(data => {
                console.log('Raw Response:', data); // Output the raw response to the console
                try {
                    const jsonData = JSON.parse(data); // Try parsing the JSON
                    console.log('Parsed Data:', jsonData);
                } catch (err) {
                    console.error('Failed to parse JSON:', data);
                }
            })
            .catch(error => console.error('Fetch Error:', error));

        // Show details of an organisation
        function openModal(organisationId) {
            console.log('Opening modal for organisation:', organisationId);
            // Show the modal
            document.getElementById('organisationModal').classList.remove('hidden');
            document.getElementById('organisationModal').classList.add('flex');

            // Clear existing content
            document.getElementById('organisationName').innerText = 'Organisation Details';
            document.getElementById('organisationDetails').innerHTML = 'Loading...';

            // Fetch organisation details via AJAX
            fetch(`/organisation/${organisationId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate modal content
                    document.getElementById('organisationName').innerText = data.name;
                    document.getElementById('organisationDetails').innerHTML = `
                        <p><strong>URL:</strong> <a href="${data.url.startsWith('http') ? data.url : `${data.url}`}" target="_blank" class="text-green-600">${data.url}</a></p>
                        <p><strong>Description:</strong> ${data.description}</p>
                    `;
                })
                .catch(error => {
                    document.getElementById('organisationDetails').innerHTML = 'Failed to load details.';
                    console.error('Error fetching organisation details:', error);
                });
        }

        function closeModal() {
            document.getElementById('organisationModal').classList.remove('flex');
            document.getElementById('organisationModal').classList.add('hidden');
            // Depopulate modal content
            document.getElementById('organisationName').innerText = "";
            document.getElementById('organisationDetails').innerHTML = ``;
        }



        function openNewModal() {
        // Display the modal
                const editModal = document.getElementById('newOrganisationModal');
                editModal.classList.remove('hidden');
                editModal.classList.add('flex');
        };

        function closeNewModal() {
            document.getElementById('newOrganisationModal').classList.remove('flex');
            document.getElementById('newOrganisationModal').classList.add('hidden');
            // Depopulate modal content
            document.getElementById('OrganisationName').innerText = "";
            document.getElementById('OrganisationUrl').innerText = "";
            document.getElementById('OrganisationDescription').innerText = ``;
        }

        // Function to open the modal to edit a specific organisation
        // function openEditModal(organisationId) {
        //     // Fetch the organisation details (you might use AJAX here)
        //     fetch(`/organisation/${organisationId}?json=true`)
        //         .then(response => response.json())
        //         .then(data => {
        //             // Populate modal fields with organisation data
        //             document.getElementById('editOrganisationId').value = data.id;
        //             document.getElementById('editOrganisationName').value = data.name;
        //             document.getElementById('editOrganisationUrl').value = data.url;
        //             document.getElementById('editOrganisationDescription').value = data.description;

        //             // Display the modal
        //             const editModal = document.getElementById('editOrganisationModal');
        //             editModal.classList.remove('hidden');
        //             editModal.classList.add('flex');
        //         });
        // }

        function openEditModal(organisationId) {
        // Fetch the organisation details
        fetch(`/organisation/${organisationId}?json=true`)
            .then(response => response.json())
            .then(data => {
                // Populate modal fields with organisation data
                document.getElementById('editOrganisationName').value = data.name;
                document.getElementById('editOrganisationUrl').value = data.url;
                document.getElementById('editOrganisationDescription').value = data.description;

                // Dynamically set the form's action URL
                document.getElementById('editOrganisationForm').action = `/organisation/${data.id}`;

                // Display the modal
                const editModal = document.getElementById('editOrganisationModal');
                editModal.classList.remove('hidden');
                editModal.classList.add('flex');
            });
        }

        function closeEditModal() {
            // Hide the modal
            const editModal = document.getElementById('editOrganisationModal');
            editModal.classList.remove('flex');
            editModal.classList.add('hidden');

            // Clear the form fields (optional)
            document.getElementById('editOrganisationForm').reset();
        }

        // function submitForm(event) {
        //     event.preventDefault();  // Prevent the default form submission

        //     const form = document.getElementById('editOrganisationForm');

        //     // Create a FormData object to easily send form data
        //     const formData = new FormData(form);

        //     // Send the data using Fetch API
        //     fetch(form.action, {
        //         method: 'POST',
        //         body: formData,
        //     })
        //     .then(response => response.json())  // Expecting JSON response from the backend
        //     .then(data => {
        //         if (data.success) {
        //             // Close the modal after success
        //             closeEditModal();

        //             // Optionally, update the UI with the updated data
        //             // For example, you can update the organisation name and details on the page
        //             updateOrganisationUI(data.organisation);
        //         } else {
        //             // Handle any validation errors or other issues
        //             alert('There was an issue saving the data');
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error submitting form:', error);
        //         alert('There was an error submitting the form.');
        //     });
        // }

        // function submitForm(event) {
        //     event.preventDefault();  // Prevent the default form submission

        //     const form = document.getElementById('editOrganisationForm');

        //     // Create a FormData object to easily send form data
        //     const formData = new FormData(form);

        //     // Get the CSRF token from the meta tag
        //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //     fetch(form.action, {
        //         method: 'POST',  // Use POST for the form submission
        //         headers: {
        //             'X-CSRF-TOKEN': csrfToken,  // CSRF token for security
        //             'X-HTTP-Method-Override': 'PUT',  // Override method to PUT
        //         },
        //         body: formData,  // Send form data
        //     })
        //     .then(response => {
        //         if (!response.ok) {
        //             throw new Error('Network response was not ok');
        //         }
        //         return response.json();  // Expect JSON response
        //     })
        //     .then(data => {
        //         if (data.success) {
        //             // Handle success (e.g., close modal, update UI)
        //             closeModal();
        //             alert('Organisation updated successfully!');
        //         } else {
        //             alert('There was an error updating the organisation.');
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error:', error);
        //         alert('Error submitting form');
        //     });
        // }

        function closeEditModal() {
            const editModal = document.getElementById('editOrganisationModal');
            editModal.classList.remove('flex');
            editModal.classList.add('hidden');
        }

        function updateOrganisationUI(organisation) {
            // Update the organisation details on the page
            // For example, assuming you have an element to display the organisation name
            document.getElementById('organisationName').innerText = organisation.name;
            document.getElementById('organisationUrl').innerText = organisation.url;
            document.getElementById('organisationDescription').innerText = organisation.description;
        }
    </script>
</x-app-layout>
