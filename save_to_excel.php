<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $problem = $_POST['problem'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Path to the Excel file
    $filePath = 'contact_data.csv';

    // Check if the file exists, if not create it with headers
    if (!file_exists($filePath)) {
        $file = fopen($filePath, 'w');
        fputcsv($file, ['Problem', 'Name', 'Contact', 'Email', 'Message', 'Date']);
        fclose($file);
    }

    // Append the form data to the file
    $file = fopen($filePath, 'a');
    fputcsv($file, [ $problem ,$name, $contact, $email, $message, date('Y-m-d H:i:s')]);
    fclose($file);

    // Prepare the email content
    $to = 'info.8bittech@gmail.com';  // Your email address where the enquiry will be sent
    $subject = 'New Enquiry from ' . $name;
    $body = "You have received a new enquiry.<br><br>" .
            "Problem: $problem<br>" .
            "Name: $name<br>" .
            "Contact: $contact<br>" .
            "Email: $email<br>" .
            "Message: $message<br>" .
            "Date: " . date('Y-m-d H:i:s');
    
    // Set email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: " . $email . "\r\n";  // Set sender's email as the form user's email

    // Send the email using PHP's mail() function
    if (mail($to, $subject, $body, $headers)) {
        // Redirect or show a success message
        echo "<script>alert('Thank you for contacting us!'); window.location.href = 'index.html';</script>";
    } else {
        // If email fails to send, show an error message
        echo "<script>alert('Error sending enquiry. Please try again later.'); window.location.href = 'index.html';</script>";
    }
    exit;
}
?>
