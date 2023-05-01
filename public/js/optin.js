// Get the form and buttons
var optInForm = document.getElementById('optin-form');
var optInBtn = document.getElementById('optin-btn');
var optOutBtn = document.getElementById('optout-btn');

// Get the modal and buttons
var confirmModal = document.getElementById('confirm-modal');
var confirmMessage = document.getElementById('confirm-message');
var confirmYesBtn = document.getElementById('confirm-yes-btn');
var confirmNoBtn = document.getElementById('confirm-no-btn');

// Add event listeners to the buttons
optInBtn.addEventListener('click', function() {
    // Show the confirm modal with the opt in message
    confirmMessage.innerHTML = 'Are you sure you want to opt in?';
    confirmModal.style.display = 'block';
});
optOutBtn.addEventListener('click', function() {
    // Show the confirm modal with the opt out message
    confirmMessage.innerHTML = 'Are you sure you want to opt out?';
    confirmModal.style.display = 'block';
});
confirmYesBtn.addEventListener('click', function() {
    // Hide the confirm modal and submit the form
    confirmModal.style.display = 'none';
    optInForm.submit();
});
confirmNoBtn.addEventListener('click', function() {
    // Hide the confirm modal
    confirmModal.style.display = 'none';
});
