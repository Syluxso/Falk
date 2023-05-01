<?php

// Include the bootstrap file and any other required dependencies
/**
 * @var $db \db\OptInRequestRepository
 */
require_once('app/bootstrap.php');

// Get the OptInRequest hash from the URL parameter
$hash = $_GET['hash'];

// Query the database for the OptInRequest with the given hash
$optInRequest = $db->getByHash($hash);

// Check if the OptInRequest has already been opted in
if ($optInRequest->getStatus() == 2) {
    echo 'You have already opted in.';
    exit;
}

// Check if the OptInRequest has not been opted in yet
if ($optInRequest->getStatus() == 1) {
    // Show a form asking the user whether they want to opt in or opt out
    echo '<form method="POST" id="optin-form">';
    echo '<input type="hidden" name="hash" value="' . $hash . '">';

    echo '<h2>Do you want to opt in?</h2>';

    echo '<button type="button" id="optin-btn">Opt In</button>';
    echo '<button type="button" id="optout-btn">Opt Out</button>';

    echo '</form>';

    // Show a modal window to confirm the user's choice
    echo '<div class="modal" id="confirm-modal">';
    echo '<div class="modal-content">';
    echo '<h2>Are you sure?</h2>';
    echo '<p id="confirm-message"></p>';
    echo '<button type="button" id="confirm-yes-btn">Yes</button>';
    echo '<button type="button" id="confirm-no-btn">No</button>';
    echo '</div>';
    echo '</div>';

    // Include JavaScript to handle the form submission and modal window
    echo '<script src="js/optin.js"></script>';
}
