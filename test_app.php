<?php
// Test the application by simulating a request
define('PREVENT_DIRECT_ACCESS', TRUE);

// Simulate the request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['HTTP_HOST'] = 'localhost';

// Include the main application
try {
    ob_start();
    include 'index.php';
    $output = ob_get_clean();
    
    if (strlen($output) > 0) {
        echo "Application loaded successfully!\n";
        echo "Output length: " . strlen($output) . " characters\n";
        echo "First 200 characters:\n";
        echo substr($output, 0, 200) . "\n";
    } else {
        echo "No output generated\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>