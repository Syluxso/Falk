<?php

// Include the bootstrap file and any other required dependencies
/**
 * @var $db \db\OptInRequestRepository
 */
require_once(__DIR__.'/../app/bootstrap.php');

// Get the OptInRequest hash from the URL parameter
if(!isset($_GET['hash'])){
    echo 'No identifier detected!';
    exit;
}

$hash = $_GET['hash'];

// Query the database for the OptInRequest with the given hash
$optInRequest = $db->getByHash($hash);

// Check if object exists
if (!$optInRequest) {
    echo "Error: Object not found.";
    exit;
}

// Check if the OptInRequest has already been opted in
if ($optInRequest->getStatus() == 2) {
    echo 'You have already opted in.';
    exit;
}

// Check if the OptInRequest has already been opted out
if ($optInRequest->getStatus() == 3) {
    echo 'You have already opted out.';
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Opt In Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<form id="optin-form">
    <input type="hidden" name="hash" value="<?= $hash ?>">
    <label for="optin-question">Do you want to Opt In?</label><br>
    <button type="button" id="optin-btn">Opt In</button>
    <button type="button" id="optout-btn">Opt Out</button>
</form>

<!-- Modal -->
<div id="modal" style="display: none;">
    <p>Are you sure you want to Opt <span id="optin-status"></span>?</p>
    <button type="button" id="yes-btn">Yes</button>
    <button type="button" id="no-btn">No</button>
</div>

<script>
$(document).ready(function () {
    // Opt In button clicked
    $('#optin-btn').click(function () {
        $('#optin-status').text('In');
        $('#modal').show();
    });

    // Opt Out button clicked
    $('#optout-btn').click(function () {
        $('#optin-status').text('Out');
        $('#modal').show();
    });

    // Yes button clicked
    $('#yes-btn').click(function () {
        var formData = $('#optin-form').serialize();
        formData += '&optin_status=' + ($('#optin-status').text() === "In" ? 1 : 0);

        $.ajax({
                url: 'api/optin.php',
                type: 'POST',
                data: formData,
                success: function (response) {
            console.log(response);
            // Do something with the response
        },
                error: function (xhr, status, error) {
            console.log(xhr.responseText);
            // Handle errors
        }
            });

            $('#modal').hide();
        });

    // No button clicked
    $('#no-btn').click(function () {
        $('#modal').hide();
    });
});
</script>
</body>
</html>