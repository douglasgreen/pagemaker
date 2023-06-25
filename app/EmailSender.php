<?php

namespace PageMaker;

class EmailSender
{
/**
 * Function to send an email with an attachment
 *
 * @param string $from - The email address sending the email
 * @param string $recipient - The recipient of the email
 * @param string $subject - The subject of the email
 * @param string $message - The main message of the email
 * @param string $attachmentFilePath - The file path to the attachment
 * @return array - An array with success or error message
 */
    function sendEmailWithAttachment($from, $recipient, $subject, $message, $attachmentFilePath)
    {
        // Generate a unique separator for multipart content
        $separator = md5(microtime(true) . mt_rand());

        // Define carriage return type (according to RFC standard)
        $eol = "\r\n";

        // Construct the main headers (multipart is required for attachments)
        $headers = 'From: ' . $from . $eol;
        $headers .= 'MIME-Version: 1.0' . $eol;
        $headers .= 'Content-Type: multipart/mixed; boundary="' . $separator . '"' . $eol;

        // Prepare the message body
        $body = '--' . $separator . $eol;
        $body .= 'Content-Type: text/plain; charset="UTF-8"' . $eol;
        $body .= 'Content-Transfer-Encoding: base64' . $eol;
        $body .= chunk_split(base64_encode($message)) . $eol;

        // Read and encode the attachment
        $encodedAttachment = chunk_split(base64_encode(file_get_contents($attachmentFilePath)));

        // Add attachment to the body
        $body .= '--' . $separator . $eol;
        $body .= 'Content-Type: application/octet-stream; name="' . basename($attachmentFilePath) . '"' . $eol;
        $body .= 'Content-Transfer-Encoding: base64' . $eol;
        $body .= 'Content-Disposition: attachment; filename="' . basename($attachmentFilePath) . '"' . $eol . $eol;
        $body .= $encodedAttachment . $eol;
        $body .= '--' . $separator . '--';

        // Send the email and return success or error message
        if (mail($recipient, $subject, $body, $headers)) {
            return array('success' => true);
        } else {
            return array('error' => error_get_last());
        }
    }
}
