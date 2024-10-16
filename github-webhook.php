<?php
// Get the payload from GitHub
$payload = file_get_contents('php://input');

// Decode the payload
$payloadData = json_decode($payload, true);

// Check if it's a push to the master branch
if (isset($payloadData['ref']) && $payloadData['ref'] === 'refs/heads/master') {
    // Pull the latest code and log the output
    $output = shell_exec('cd /var/www/html && git pull origin master 2>&1');

    // Log the output of the shell command for debugging
    file_put_contents('/tmp/webhook_git_log.txt', $output, FILE_APPEND);
}

// Respond with a success message
http_response_code(200);
echo 'Webhook received and processed successfully.';
?>
