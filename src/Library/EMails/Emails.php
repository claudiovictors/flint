<?php

declare(strict_types=1);

/**
 * Arquivo de envio de E-mails do Flint.
 *
 * Este arquivo é responsável enviar e-mails (SMTP)
 */

namespace Flint\Library\Emails;

use Exception;

class Mail {
    
    private string $to;
    private string $subject;
    private string $message;
    private array $headers = [];

    public function __construct()
    {
        $this->headers[] = "From: ". getenv('MAIL_USERNAME');
        $this->headers[] = "Reply-To: ". getenv('MAIL_USERNAME');
        $this->headers[] = "Content-Type: text/html; charset=utf8";
    }

    public function to(string $email): self {
        $this->to = $email;
        return $this;
    }

    public function subject(string $subject): self {
        $this->subject = $subject;
        return $this;
    }

    public function message(string $message): self {
        $this->message = $message;
        return $this;
    }

    public function send(): bool {
        if(empty($this->to) || empty($this->subject) || empty($this->message)):
            throw new Exception("Require all inputs");
        endif;

        $headers = implode("\r\n", $this->headers);

        return mail($this->to, $this->subject, $this->message, $headers);
    }
}