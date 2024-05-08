<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class Mailer
{
  private $mail;

  public function __construct()
  {
    $this->mail = new PHPMailer(true);
    $this->setup();
  }

  private function setup()
  {
    $this->mail->isSMTP();
    $this->mail->Host       = 'smtp.gmail.com';
    $this->mail->SMTPAuth   = true;
    $this->mail->Username   = 'qcucooperatives@gmail.com';
    $this->mail->Password   = 'vdhj rgtb wjaz vnfa';
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port       = 587;

    $this->mail->setFrom('qcucooperatives@gmail.com', 'Drivesation');
    $this->mail->isHTML(true);
  }

  public function sendEmail($to, $name, $subject, $body, $altBody = '')
  {
    try {
      $this->mail->addAddress($to, $name);

      $this->mail->Subject = $subject;
      $this->mail->Body    = $body;
      $this->mail->AltBody = $altBody ?: strip_tags($body);

      $this->mail->send();
      return 'Email sent successfully!';
    } catch (Exception $e) {
      return "Email could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    } finally {
      $this->mail->clearAddresses();
    }
  }
}
