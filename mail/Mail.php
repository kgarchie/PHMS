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
        $this->setUp();
    }

    private function setUp()
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['username'];
        $this->mailer->Password = $this->config['password'];
        $this->mailer->SMTPSecure = $this->config['secure'];
        $this->mailer->Port = $this->config['port'];
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
        $this->mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => true,
                'allow_self_signed' => false
            )
        );
        try {
            $this->mailer->setFrom($this->config['from']);
            $this->mailer->addAddress($to);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            $success = $this->mailer->send();
            if (!$success) return [false, $this->mailer->ErrorInfo];
        } catch (Exception $e) {
            return [false, $e->getMessage()];
        }

        return [true, null];
    }
}

$mail = new Mail();
