<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your form processing logic

    // Verify reCAPTCHA response
    $recaptcha_secret_key = '6Lfnu0YpAAAAAEi-Ir4o2yJr9qAXPsmRu6oa1dCy'; // Replace with your actual reCAPTCHA secret key
    $recaptcha_response = $_POST['g-recaptcha-response']; // Assuming you're using POST method

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = [
        'secret'   => $recaptcha_secret_key,
        'response' => $recaptcha_response,
    ];

    $options = [
        'http' => [
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'method'  => 'POST',
            'content' => http_build_query($recaptcha_data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($recaptcha_url, false, $context);
    $result = json_decode($result, true);

    if ($result['success']) {
        // reCAPTCHA verification passed, process the form data
        // Your form processing logic here

        // Example: Print submitted data
        echo "Form submitted successfully!\n";
        echo "Name: " . $_POST['name'] . "\n";
        echo "Email: " . $_POST['email'] . "\n";
        // Add more fields as needed
    } else {
        // reCAPTCHA verification failed, handle accordingly
        echo 'reCAPTCHA verification failed.';
    }
} else {
    // Handle non-POST requests
    echo 'Invalid request method.';
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['First-Name'];
    $lastName = $_POST['Last-Name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['Phone-Number'];
    $company = $_POST['Company'];
    $message = $_POST['field'];

    // You can process or store the data as needed
    // For example, save it to a text file or a database

    // Example: Save data to a text file
    $data = "First Name: $firstName\n";
    $data .= "Last Name: $lastName\n";
    $data .= "Email: $email\n";
    $data .= "Phone Number: $phoneNumber\n";
    $data .= "Company: $company\n";
    $data .= "Message: $message\n";

    file_put_contents('form_data.txt', $data, FILE_APPEND | LOCK_EX);

    // Redirect to a thank-you page
    header('Location: /thank-you');
    exit();
} else {
    // Handle non-POST requests
    echo 'Invalid request method.';
}
?>
