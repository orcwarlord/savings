View:

{{-- Modal for org edit --}}
    <div
    id="editOrganisationModal"
    class="fixed inset-0 z-50 hidden items-center justify-center"
>
    <!-- Modal background -->
    <div
        class="absolute inset-0 bg-black bg-opacity-25 w-full h-full"
        onclick="closeEditModal()"
    ></div>

    <!-- Modal content -->
    <div
        class="relative bg-white rounded-lg shadow-lg w-5/6 md:w-1/2 p-6"
        onclick="event.stopPropagation()"
    >
        <button
            class="absolute top-2 right-2 text-black hover:text-black text-3xl"
            onclick="closeEditModal()"
        >
            &times;
        </button>
        <h2 class="text-xl font-bold mb-4">Edit Organisation</h2>
        <form id="editOrganisationForm"
            method="POST"
            action="{{ route('organisation.update', $organisation->id) }}"
            onsubmit="submitForm(event)"
            >
            @csrf
            @method('PUT')

            <!-- Hidden input for organisation ID -->
            <input type="hidden" name="id" id="editOrganisationId">
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
                <button
                    type="submit"
                    class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-800"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    Controller

    try {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'nullable|string',
        ]);

        // Find the organisation or fail
        $organisation = Organisation::findOrFail($id);

        // Update the organisation with validated data
        $organisation->update($validated);

        // Return a JSON response with the updated data
        return response()->json([
            'success' => true,
            'organisation' => $organisation,
        ]);
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        Log::error('Error updating organisation: ' . $e->getMessage());

        // Return a JSON error response
        return response()->json([
            'success' => false,
            'message' => 'There was an error updating the organisation.',
            'error' => $e->getMessage(),
        ], 500);
    }

Route

Route::get('/organisation/{id}', function ($id) {
    $organisation = Organisation::findOrFail($id);
    return response()->json($organisation);
});
