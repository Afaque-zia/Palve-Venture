<?php
/**
 * Palve Ventures - Form Handler
 * Processes form submissions and sends emails
 */

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set JSON header
header('Content-Type: application/json');

// CORS headers (if needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Response array
$response = array('success' => false, 'message' => '');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// ============================================
// EMAIL CONFIGURATION
// ============================================
// TODO: Update these settings with actual email credentials

$toEmail = 'info@palveventures.com'; // Change this to your email
$fromEmail = 'noreply@palveventures.com';
$fromName = 'Palve Ventures Website';

// For Gmail SMTP, you'll need these settings:
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'your-email@gmail.com'; // Your Gmail address
$smtpPassword = 'your-app-password'; // Gmail App Password (not regular password)

// ============================================
// FUNCTIONS
// ============================================

/**
 * Sanitize input data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate email
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Send email using PHP mail() function
 * For production, use PHPMailer or similar library
 */
function send_simple_email($to, $subject, $message, $from) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}

/**
 * Send email using Gmail SMTP (requires PHPMailer)
 * Uncomment and use this function when PHPMailer is installed
 */
/*
function send_gmail($to, $subject, $body, $smtpSettings) {
    require 'vendor/autoload.php'; // PHPMailer autoload
    
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtpSettings['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtpSettings['username'];
        $mail->Password = $smtpSettings['password'];
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpSettings['port'];
        
        // Recipients
        $mail->setFrom($smtpSettings['from'], 'Palve Ventures');
        $mail->addAddress($to);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email error: {$mail->ErrorInfo}");
        return false;
    }
}
*/

// ============================================
// FORM PROCESSING
// ============================================

try {
    // Determine form type and process accordingly
    
    // CONTACT FORM
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['message'])) {
        
        $name = sanitize_input($_POST['name']);
        $email = sanitize_input($_POST['email']);
        $phone = sanitize_input($_POST['phone']);
        $message = sanitize_input($_POST['message']);
        
        // Validation
        if (empty($name) || empty($email) || empty($phone) || empty($message)) {
            throw new Exception('All fields are required');
        }
        
        if (!validate_email($email)) {
            throw new Exception('Invalid email address');
        }
        
        if (strlen($phone) < 10) {
            throw new Exception('Invalid phone number');
        }
        
        // Prepare email
        $subject = "New Contact Form Submission - Palve Ventures";
        $emailBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #3B82F6; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; margin-top: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #3B82F6; }
                .footer { margin-top: 20px; padding: 20px; background: #f0f0f0; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>New Contact Form Submission</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='label'>Name:</span><br>
                        {$name}
                    </div>
                    <div class='field'>
                        <span class='label'>Email:</span><br>
                        {$email}
                    </div>
                    <div class='field'>
                        <span class='label'>Phone:</span><br>
                        {$phone}
                    </div>
                    <div class='field'>
                        <span class='label'>Message:</span><br>
                        {$message}
                    </div>
                </div>
                <div class='footer'>
                    <p>This email was sent from Palve Ventures contact form</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Send email
        if (send_simple_email($toEmail, $subject, $emailBody, $fromEmail)) {
            $response['success'] = true;
            $response['message'] = 'Thank you for contacting us! We will get back to you soon.';
        } else {
            throw new Exception('Failed to send email. Please try again or call us directly.');
        }
    }
    
    // BUYER QUALIFICATION FORM
    elseif (isset($_POST['propertyType']) && isset($_POST['budget']) && isset($_POST['location']) && isset($_POST['purpose'])) {
        
        $propertyType = sanitize_input($_POST['propertyType']);
        $budget = sanitize_input($_POST['budget']);
        $location = sanitize_input($_POST['location']);
        $purpose = sanitize_input($_POST['purpose']);
        
        // Prepare email
        $subject = "New Buyer Qualification - Palve Ventures";
        $emailBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #3B82F6; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; margin-top: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #3B82F6; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Buyer Qualification Form</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='label'>Property Type:</span> {$propertyType}
                    </div>
                    <div class='field'>
                        <span class='label'>Budget:</span> {$budget}
                    </div>
                    <div class='field'>
                        <span class='label'>Location:</span> {$location}
                    </div>
                    <div class='field'>
                        <span class='label'>Purpose:</span> {$purpose}
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        if (send_simple_email($toEmail, $subject, $emailBody, $fromEmail)) {
            $response['success'] = true;
            $response['message'] = 'Thank you! We are finding the best properties for you.';
        } else {
            throw new Exception('Failed to process request.');
        }
    }
    
    // FEASIBILITY REPORT FORM
    elseif (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['location'])) {
        
        $name = sanitize_input($_POST['name']);
        $email = sanitize_input($_POST['email']);
        $phone = sanitize_input($_POST['phone']);
        $location = sanitize_input($_POST['location']);
        $propertyDetails = sanitize_input($_POST['message'] ?? '');
        
        // Validation
        if (!validate_email($email)) {
            throw new Exception('Invalid email address');
        }
        
        // Prepare email
        $subject = "Feasibility Report Request - Palve Ventures";
        $emailBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #06B6D4; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; margin-top: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #06B6D4; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Feasibility Report Request</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='label'>Name:</span> {$name}
                    </div>
                    <div class='field'>
                        <span class='label'>Email:</span> {$email}
                    </div>
                    <div class='field'>
                        <span class='label'>Phone:</span> {$phone}
                    </div>
                    <div class='field'>
                        <span class='label'>Location:</span> {$location}
                    </div>
                    <div class='field'>
                        <span class='label'>Property Details:</span><br>
                        {$propertyDetails}
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        if (send_simple_email($toEmail, $subject, $emailBody, $fromEmail)) {
            $response['success'] = true;
            $response['message'] = 'Request received! Your feasibility report will be sent to your email within 24 hours.';
        } else {
            throw new Exception('Failed to process request.');
        }
    }
    
    else {
        throw new Exception('Invalid form data');
    }
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Return JSON response
echo json_encode($response);

/**
 * INSTALLATION NOTES FOR GMAIL SMTP:
 * 
 * 1. Install PHPMailer using Composer:
 *    composer require phpmailer/phpmailer
 * 
 * 2. Enable 2-Factor Authentication on your Gmail account
 * 
 * 3. Generate an App Password:
 *    - Go to Google Account Settings
 *    - Security > 2-Step Verification > App passwords
 *    - Generate a password for "Mail"
 *    - Use this password in $smtpPassword variable
 * 
 * 4. Update the configuration variables at the top of this file
 * 
 * 5. Uncomment the send_gmail() function and use it instead of send_simple_email()
 * 
 * 6. Make sure your hosting supports outgoing SMTP connections
 */
?>