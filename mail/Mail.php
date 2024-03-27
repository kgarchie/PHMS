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

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @param bool $debug
     * @return array{bool|null, string|null}
     */
    public function send($to, $subject, $body): array
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['username'];
        $this->mailer->Password = $this->config['password'];
        $this->mailer->SMTPSecure = $this->config['secure'];
        $this->mailer->Port = $this->config['port'];

        try {
            $this->mailer->setFrom($this->config['from']);
            $this->mailer->addAddress($to);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            $this->mailer->send();
        } catch (Exception $e) {
            return [false, $e->getMessage()];
        }

        return [true, null];
    }
}

$mail = new Mail();
