// Show details of an type
function openModal(typeId) {
    console.log('Opening modal for type:', typeId);
    // Show the modal
    document.getElementById('typeModal').classList.remove('hidden');
    document.getElementById('typeModal').classList.add('flex');

    // Clear existing content
    document.getElementById('typeName').innerText = 'Type Details';


    // Fetch type details via AJAX
    fetch(`/type/${typeId}`)
        .then(response => response.json())
        .then(data => {
            // Populate modal content
            document.getElementById('typeName').innerText = data.name;

        })
        .catch(error => {
            document.getElementById('typeName').innerText = 'Failed to load type.';
            console.error('Error fetching type details:', error);
        });
}

function closeModal() {
    document.getElementById('typeModal').classList.remove('flex');
    document.getElementById('typeModal').classList.add('hidden');

    // Depopulate modal content
    document.getElementById('typeName').innerText = "";

}

function openNewModal() {
// Display the modal
        const editModal = document.getElementById('newTypeModal');
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
};

function closeNewModal() {
    document.getElementById('newTypeModal').classList.remove('flex');
    document.getElementById('newTypeModal').classList.add('hidden');
    // Depopulate modal content
    document.getElementById('typeName').innerText = "";

}

function openEditModal(typeId) {
// Fetch the type details
fetch(`/type/${typeId}?json=true`)
    .then(response => response.json())
    .then(data => {
        // Populate modal fields with type data
        document.getElementById('editTypeName').value = data.name;


        // Dynamically set the form's action URL
        document.getElementById('editTypeForm').action = `/type/${data.id}`;

        // Display the modal
        const editModal = document.getElementById('editTypeModal');
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    });
}

function closeEditModal() {
    // Hide the modal
    const editModal = document.getElementById('editTypeModal');
    editModal.classList.remove('flex');
    editModal.classList.add('hidden');

    // Clear the form fields (optional)
    document.getElementById('editTypeForm').reset();
}

// function closeEditModal() {
//     const editModal = document.getElementById('editTypeModal');
//     editModal.classList.remove('flex');
//     editModal.classList.add('hidden');
// }

function updateTypeUI(type) {
    // Update the type details on the page
    // For example, assuming you have an element to display the type name
    document.getElementById('typeName').innerText = type.name;

}

// Attach all functions to the global `window` object
window.openModal = openModal;
window.closeModal = closeModal;
window.openNewModal = openNewModal;
window.closeNewModal = closeNewModal;
window.openEditModal = openEditModal;
window.closeEditModal = closeEditModal;
window.updateOrganisationUI = updateTypeUI;

// console.log('type.js loaded');
