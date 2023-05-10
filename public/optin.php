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
if ($optInRequest->getStatus() == 1) {
    echo 'You have already opted in.';
    exit;
}

// Check if the OptInRequest has already been opted out
if ($optInRequest->getStatus() == 2) {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<style>
    .container{
        margin-top:25px;
    }
    .button_row{
        text-align: center;
        padding-top:15px;
    }
</style>
<body>
<div class="container">
    <div id="success-alert" class="alert alert-success" role="alert" style="display: none;"><p class="alert-text"></p></div>
    <div id="error-alert" class="alert alert-danger" role="alert" style="display: none;"><p class="alert-text"></p></div>
    <div class="row">
        <div class="col-sm-12 col-md-4 col-md-offset-4">
            <div class="well">
                <form id="optin-form">
                    <input type="hidden" name="hash" value="<?= $hash ?>">
                    <label for="optin-question">Do you want to Opt In?</label><br>
                    <div class="row button_row">
                        <div class="col-sm-6">
                            <button type="button" id="optin-btn">Opt In</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" id="optout-btn">Opt Out</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button id="modal-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to Opt <span id="optin-status"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="yes-btn">Yes</button>
                    <button type="button" id="no-btn">No</button>
                </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Opt In button clicked
    $('#optin-btn').click(function () {
        $('#optin-status').text('In');
        $('#modal').show();
    });

    $('#modal-close').click( function () {
        $('#modal').hide();
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
                    $('#success-alert .alert-text').text("You have successfully opted "+$('#optin-status').text());
                    $('#success-alert').show();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    $('#error-alert .alert-text').text("There was an error while attempting to opt "+$('#optin-status').text());
                    $('#error-alert').show();
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