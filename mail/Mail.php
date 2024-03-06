<?php

namespace PHPMailer\PHPMailer;
require "mail/Exception.php";
require "mail/PHPMailer.php";
require "mail/SMTP.php";

class Mail
{
    private $mailer;
    private $config;

    public function __construct()
    {
        $this->mailer = new PHPMailer();
        $this->config = [
            'host' => 'smtp.gmail.com',
            'username' => 'trollyusertroller@gmail.com',
            'password' => 'ablx oyki yecj dllw',
            'secure' => 'tls',
            'port' => 587,
            'from' => 'trollyusertroller@gmail.com'
        ];
    }

    public function send($to, $subject, $body): bool
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['username'];
        $this->mailer->Password = $this->config['password'];
        $this->mailer->SMTPSecure = $this->config['secure'];
        $this->mailer->Port = $this->config['port'];

        $this->mailer->setFrom($this->config['from']);
        $this->mailer->addAddress($to);

        $this->mailer->isHTML(true);
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;

        return $this->mailer->send();
    }
}

$mail = new Mail();
