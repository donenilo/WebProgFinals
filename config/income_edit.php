<?php
// config/income_edit.php

include 'db_connection.php'; // Ensure you have your DB connection included

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (is_array($data)) {
    $success = true; // Flag to track success of all updates

    foreach ($data as $item) {
        if (isset($item['incomeId'], $item['field'], $item['value'])) {
            $incomeId = $item['incomeId'];
            $field = $item['field'];
            $value = mysqli_real_escape_string($conn, $item['value']); // Sanitize input

            // Prepare the SQL update statement
            $sql = "UPDATE Income SET $field = '$value' WHERE income_id = $incomeId";

            if (!mysqli_query($conn, $sql)) {
                $success = false; // If any update fails, set success to false
                break; // Exit the loop on first failure
            }
        }
    }

    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

mysqli_close($conn);
?>