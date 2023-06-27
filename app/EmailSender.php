<?php

namespace PageMaker;

class EmailSender
{
    private $from;
    private $recipient;
    private $subject;
    private $message;
    private $attachmentFilePath;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function send() {
        if ($this->attachmentFilePath) {
            $this->sendEmailWithAttachment();
        } elseif (preg_match('/<\w/', $this->message)) {
            $this->sendHTMLEmail();
        } else {
            $this->sendPlainTextEmail();
        }
    }

    /**
     * Function to send an email with an attachment
     *
     * @return array - An array with success or error message
     */
    protected function sendEmailWithAttachment()
    {
        // Generate a unique separator for multipart content
        $separator = md5(microtime(true) . mt_rand());

        // Define carriage return type (according to RFC standard)
        $eol = "\r\n";

        // Construct the main headers (multipart is required for attachments)
        $headers = 'From: ' . $this->from . $eol;
        $headers .= 'MIME-Version: 1.0' . $eol;
        $headers .= 'Content-Type: multipart/mixed; boundary="' . $separator . '"' . $eol;

        // Prepare the message body
        $body = '--' . $separator . $eol;
        $body .= 'Content-Type: text/plain; charset="UTF-8"' . $eol;
        $body .= 'Content-Transfer-Encoding: base64' . $eol;
        $body .= chunk_split(base64_encode($this->message)) . $eol;

        // Read and encode the attachment
        $encodedAttachment = chunk_split(base64_encode(file_get_contents($this->attachmentFilePath)));

        // Add attachment to the body
        $body .= '--' . $separator . $eol;
        $body .= 'Content-Type: application/octet-stream; name="' . basename($this->attachmentFilePath) . '"' . $eol;
        $body .= 'Content-Transfer-Encoding: base64' . $eol;
        $body .= 'Content-Disposition: attachment; filename="' . basename($this->attachmentFilePath) . '"' . $eol . $eol;
        $body .= $encodedAttachment . $eol;
        $body .= '--' . $separator . '--';

        // Send the email and return success or error message
        if (mail($this->recipient, $this->subject, $body, $headers)) {
            return array('success' => true);
        } else {
            return array('error' => error_get_last());
        }
    }

   /**
     * Function to send a plain text email with no attachment
     *
     * @return array - An array with success or error message
     */
    protected function sendPlainTextEmail()
    {
        $headers = 'From: ' . $this->from . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

        // Send the email and return success or error message
        if (mail($this->recipient, $this->subject, $this->message, $headers)) {
            return array('success' => true);
        } else {
            return array('error' => error_get_last());
        }
    }

    /**
     * Function to send an HTML email with no attachment
     *
     * @return array - An array with success or error message
     */
    protected function sendHTMLEmail()
    {
        $headers = 'From: ' . $this->from . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";

        // Send the email and return success or error message
        if (mail($this->recipient, $this->subject, $this->message, $headers)) {
            return array('success' => true);
        } else {
            return array('error' => error_get_last());
        }
    }
}

