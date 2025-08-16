<?php
require __DIR__.'/_config.php';
require_admin();
csrf_check();

$id      = (int)($_POST['id'] ?? 0);
$to      = trim($_POST['to'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$body    = trim($_POST['body'] ?? '');

if (!$id) { http_response_code(400); exit('Invalid message id'); }
if (!filter_var($to, FILTER_VALIDATE_EMAIL)) { http_response_code(400); exit('Invalid email'); }
if ($subject === '' || $body === '') { http_response_code(400); exit('Subject/body required'); }

// load Composer autoload from Laravel root
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

try {
    // ---- Configure SMTP (mirror your Laravel .env mail settings) ----
    $mail->isSMTP();
    $mail->Host       = 'smtp.yourhost.com';   // e.g. smtp.gmail.com
    $mail->SMTPAuth   = true;
    $mail->Username   = 'no-reply@yourdomain.com';
    $mail->Password   = 'your-app-password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // or PHPMailer::ENCRYPTION_SMTPS
    $mail->Port       = 587;                   // 465 if SMTPS

    $mail->setFrom('no-reply@yourdomain.com', 'EventEase Support');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();

    // optional: log that we replied (no schema change needed)
    // $pdo->prepare("UPDATE contacts SET updated_at = NOW() WHERE id=?")->execute([$id]);

    header('Location: /admin/message_view.php?id='.$id.'&sent=1');
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Mailer error: ' . htmlspecialchars($e->getMessage());
}
