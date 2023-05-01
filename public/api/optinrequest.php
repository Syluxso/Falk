<?php

/**
 * @var $config
 * @var $db OptInRequestRepository
 * @var $notifier Notifier
 */

use db\OptInRequestRepository;
use notification\Notifier;

require_once __DIR__ . '/../../app/bootstrap.php';

// Check if all required parameters are present
if (isset($_POST['phone'], $_POST['site_id'], $_POST['site_name'])) {

    // Generate a UUID for the OptInRequest hash
    $uuid = uniqid("", true);

    // Create an OptInRequest object with the available data
    $optInRequest = new OptInRequest(
        null,
        $_POST['site_id'],
        $_POST['site_name'],
        $_POST['phone'],
        1,
        time(),
        $uuid
    );

    // Create the OptInRequest in the database
    $optInRequest = $db->create($optInRequest);
    $sent = $notifier->sendNotification($optInRequest);

    // Return a JSON response indicating success
    header('Content-Type: application/json');
    echo json_encode(array('success' => $sent));

} else {
    // Return an error response if any required parameters are missing
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Missing required parameters'), JSON_THROW_ON_ERROR);
}