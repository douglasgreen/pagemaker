<?php

namespace PageMaker\Email;

use Exception;

/**
 * @class Email sender
 *
 * @todo Fix return values.
 *
 * 1. Use tables for structure
 * 2. 600px maximum width
 * 3. Keep css simple and inline
 * 4. Avoid JavaScript
 */
class EmailSender
{
    // Define carriage return type (according to RFC standard)
    protected const EOL = "\r\n";

    protected $attachment;
    protected $charset = 'UTF-8';
    protected $headers = [
        'From' => null,
        'Bcc' => [],
        'Cc' => [],
        'MIME-Version' => '1.0',
        'Return-Path' => null,
        'X-Mailer' => 'PHP/' . phpversion(),
        'X-Priority' => '1',
        'X-Sender' => null
    ];
    protected $sections = [];
    protected $subject;
    protected $to;
    protected $useHtml = false;

    public function addBcc(string $bcc): void
    {
        $this->headers['Bcc'][] = trim($bcc);
    }

    public function addCc(string $cc): void
    {
        $this->headers['Cc'][] = trim($cc);
    }

    public function addSection(string $section): void
    {
        if (preg_match('/<\w/', $section)) {
            $this->useHtml = true;
        }
        $this->sections[] = trim($section);
    }

    /**
     * Send the message.
     */
    public function send()
    {
        if ($this->attachment) {
            $this->sendEmailWithAttachment();
        } elseif ($this->useHtml) {
            $this->sendHTMLEmail();
        } else {
            $this->sendPlainTextEmail();
        }
    }

    /**
     * Set attachment file path.
     */
    public function setAttachment(string $attachment): void
    {
        $this->attachment = $attachment;
    }

    public function setCharset(string $charset): void
    {
        $this->charset = $charset;
    }

    public function setFrom(string $from): void
    {
        $this->headers['From'] = $from;
    }

    public function setHeader(string $name, string $value): void
    {
        if (!isset($this->headers[$name])) {
            throw new Exception("Unrecognized header");
        }
        $this->headers[$name] = $value;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * Function to send an email with an attachment
     *
     * @return array An array with success or error message
     */
    protected function sendEmailWithAttachment()
    {
        // Generate a unique separator for multipart content
        $separator = md5(microtime(true) . mt_rand());

        // Construct the main headers (multipart is required for attachments)
        $headers = ['Content-Type' => 'Content-Type: multipart/mixed; boundary="' . $separator . '"'];
        $headers = array_merge($this->getHeaders(), $headers);

        // Prepare the message body
        $body = '--' . $separator . self::EOL;
        if ($this->useHtml) {
            $body .= 'Content-Type: text/html; charset="' . $this->charset . '"' . self::EOL;
            $body .= 'Content-Transfer-Encoding: base64' . self::EOL;
            $message = $this->getHtmlMessage();
            $body .= chunk_split(base64_encode($message)) . self::EOL;
        } else {
            $body .= 'Content-Type: text/plain; charset="' . $this->charset . '"' . self::EOL;
            $body .= 'Content-Transfer-Encoding: base64' . self::EOL;
            $message = $this->getTextMessage();
            $body .= chunk_split(base64_encode($message)) . self::EOL;
        }

        // Read and encode the attachment
        $encodedAttachment = chunk_split(base64_encode(file_get_contents($this->attachment)));

        // Add attachment to the body
        $body .= '--' . $separator . self::EOL;
        $body .= 'Content-Type: application/octet-stream; name="' . basename($this->attachment) . '"' . self::EOL;
        $body .= 'Content-Transfer-Encoding: base64' . self::EOL;
        $body .= 'Content-Disposition: attachment; filename="' . basename($this->attachment) . '"' . self::EOL . self::EOL;
        $body .= $encodedAttachment . self::EOL;
        $body .= '--' . $separator . '--';

        // Send the email and return success or error message
        if (mail($this->to, $this->subject, $body, $headers)) {
            return ['success' => true];
        } else {
            return ['error' => error_get_last()];
        }
    }

   /**
     * Function to send a plain text email with no attachment
     *
     * @return array - An array with success or error message
     */
    protected function sendPlainTextEmail()
    {
        $headers = ['Content-Type' => 'text/plain; charset="' . $this->charset . '"'];
        $headers = array_merge($this->getHeaders(), $headers);

        $message = $this->getTextMessage();

        // Send the email and return success or error message
        if (mail($this->to, $this->subject, $message, $headers)) {
            return ['success' => true];
        } else {
            return ['error' => error_get_last()];
        }
    }

    /**
     * Function to send an HTML email with no attachment
     *
     * @return array - An array with success or error message
     */
    protected function sendHTMLEmail()
    {
        $headers = ['Content-Type' => 'text/html; charset="' . $this->charset . '"'];
        $headers = array_merge($this->getHeaders(), $headers);

        $message = $this->getHtmlMessage();

        // Send the email and return success or error message
        if (mail($this->to, $this->subject, $message, $headers)) {
            return ['success' => true];
        } else {
            return ['error' => error_get_last()];
        }
    }

    protected function getHeaders(): array
    {
        $headers = [];
        foreach ($this->headers as $name => $value) {
            if (!$value) {
                continue;
            }
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $headers[$name] = $value;
        }
        return $headers;
    }

    protected function getHtmlMessage(): string
    {
        // Use a centered table layout of fluid width up to 600px standard.
        $message = <<<HTML
            <center>
                <table style="width: 100%; max-width: 600px; margin: 0 auto;" cellpadding="0" cellspacing="0" border="0">
            HTML;
        foreach ($this->sections as $section) {
            $message .= <<<HTML
                <tr>
                    <td style="text-align:left;">
                        $section
                    </td>
                </tr>
                HTML;
        }
        $message .= <<<HTML
                </table>
            </center>
            HTML;
        return $message;
    }

    protected function getTextMessage(): string
    {
        $message = '';
        foreach ($this->sections as $i => $section) {
            if ($i > 0) {
                $message .= "\n\n";
            }
            $message .= wordwrap($section, 70, self::EOL);
        }
        return $message;
    }
}
