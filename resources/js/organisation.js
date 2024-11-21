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

// function closeEditModal() {
//     const editModal = document.getElementById('editOrganisationModal');
//     editModal.classList.remove('flex');
//     editModal.classList.add('hidden');
// }

function updateOrganisationUI(organisation) {
    // Update the organisation details on the page
    // For example, assuming you have an element to display the organisation name
    document.getElementById('organisationName').innerText = organisation.name;
    document.getElementById('organisationUrl').innerText = organisation.url;
    document.getElementById('organisationDescription').innerText = organisation.description;
}
console.log('organisation.js loaded');


// Attach all functions to the global `window` object
window.openModal = openModal;
window.closeModal = closeModal;
window.openNewModal = openNewModal;
window.closeNewModal = closeNewModal;
window.openEditModal = openEditModal;
window.closeEditModal = closeEditModal;
window.updateOrganisationUI = updateOrganisationUI;
