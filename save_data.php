<?php
header('Content-Type: application/json');

// यह स्क्रिप्ट contact form से data को save_data.csv file में store करती है।

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $service = $_POST['service'] ?? '';
    $description = $_POST['description'] ?? '';

    // Define the CSV file path
    $file = 'save_data.csv';

    // Check if the file exists and if it is writable
    if (is_writable($file) || !file_exists($file)) {
        // Open the file in append mode ('a')
        $handle = fopen($file, 'a');

        if ($handle) {
            // Check if the file is empty and add headers if it is
            if (filesize($file) == 0) {
                fputcsv($handle, ['First Name', 'Last Name', 'Email', 'Mobile', 'Service', 'Description']);
            }

            // Add the new data to the file
            fputcsv($handle, [$firstName, $lastName, $email, $mobile, $service, $description]);

            // Close the file
            fclose($handle);

            // Send a JSON success message back to the client
            echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully. Your data is saved in ' . basename($file) . '.']);
        } else {
            // Handle file open errors
            echo json_encode(['success' => false, 'message' => 'Error: The file could not be opened for writing.']);
        }
    } else {
        // Handle file write errors
        echo json_encode(['success' => false, 'message' => 'Error: The file does not have write permissions.']);
    }
} else {
    // Handle non-POST requests
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
