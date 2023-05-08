<?php
/**
 * @var $config
 * @var $db OptInRequestRepository
 * @var $notifier Notifier
 */

require_once __DIR__ . '/../../app/bootstrap.php';

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit();
}

// Validate the input data
if (!isset($_POST['hash']) || !is_string($_POST['hash'])) {
    http_response_code(400); // Bad Request
    exit(json_encode(['error' => 'Missing or invalid hash parameter']));
}
if (!isset($_POST['optin_status']) || (!is_bool($_POST['optin_status']) && !is_numeric($_POST['optin_status'])) ) {
    http_response_code(400); // Bad Request
    exit(json_encode(['error' => 'Missing or invalid optin_status parameter']));
}

// Load the OptInRequest by hash
$request = $db->getByHash($_POST['hash']);

if (!$request) {
    http_response_code(404); // Not Found
    exit(json_encode(['error' => 'OptInRequest not found']));
}

// Update the opt-in status
if ((bool)$_POST['optin_status']) {
    $request->setStatus(1);
} else {
    $request->setStatus(2);
}

// Save the updated OptInRequest
$db->update($request);

// Return a success response
http_response_code(200); // OK
exit(json_encode(['success' => 'OptInRequest updated']));