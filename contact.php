<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Function to sanitize input data
    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    // Sanitize inputs
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $countryCode = sanitizeInput($_POST['countryCode']);
    $mobile = sanitizeInput($_POST['mobile']);
    $address = sanitizeInput($_POST['address']);
    $investment = sanitizeInput($_POST['investment']);

    // Check honeypot field (must be empty if the form is genuine)
    if (!empty($_POST['honeypot'])) {
        die("Spam detected.");
    }

    // reCAPTCHA validation (Assuming you're using reCAPTCHA v2)
    $recaptchaSecret = '6LefECgqAAAAANbAb-KSugRx_qNhxz0XbIH-4bE-';
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

    $response = file_get_contents($recaptchaUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        die("Please verify that you're not a robot.");
    }

    // Proceed with form processing
    $to = "manastom670@gmail.com";
    $subject = "New Contact Form Submission";
    $message = "Name: $name\nEmail: $email\nPhone: $countryCode $mobile\nAddress: $address\nInvestment: $investment";
    $headers = "From: noreply@monginis.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you! Your submission has been received.";
    } else {
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
}
?>
