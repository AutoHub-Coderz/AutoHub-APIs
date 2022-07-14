<?php

namespace App\Core;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail extends PHPMailer
{

    public static function sendMail($array_data)
    {


        // from_email, from_name

        if (empty($array_data['recipient'])) {
            response()->json(array("status" => 0, "message" => "No recipient/s."));
        }

        if (empty($array_data['subject'])) {
            response()->json(array("status" => 0, "message" => "Subject is required."));
        }

        if (empty($array_data['message'])) {
            response()->json(array("status" => 0, "message" => "Message is required."));
        }


        //clean from
        if (isset($array_data['from'])) {
            if (!isset($array_data['from']['email'])) {
                $array_data['from'] = [];
            } else {
                if (!isset($array_data['from']['name'])) {
                    $array_data['from']['name'] = "";
                }
            }
        } else {
            $array_data['from'] = [];
        }

        //clean reply to
        if (isset($array_data['reply_to'])) {
            if (!isset($array_data['reply_to']['email'])) {
                $array_data['reply_to'] = [];
            } else {
                if (!isset($array_data['reply_to']['name'])) {
                    $array_data['reply_to']['name'] = "";
                }
            }
        } else {
            $array_data['reply_to'] = [];
        }

        //clean recipient/s
        foreach ($array_data['recipient']  as $key => $value) {
            if (!isset($value['email'])) {
                unset($array_data['recipient'][$key]);
                $array_data['recipient'] = array_values($array_data['recipient']);
            }
        }
        //clean recipient/s name
        foreach ($array_data['recipient']  as $key => $value) {
            if (!isset($value['name'])) {
                $array_data['recipient'][$key]['name'] = "";
            }
        }




        // // print_r(json_encode($array_data));
        // print_r($array_data);
        // exit;

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output DEBUG_OFF
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = env('MAIL_HOST');                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = env('MAIL_USERNAME');                   //SMTP username
            $mail->Password   = env('MAIL_PASSWORD');                   //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = env('MAIL_PORT');;                      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            if (!empty($array_data['from'])) {
                $mail->setFrom($array_data['from']['email'], $array_data['from']['name']);
            }
            foreach ($array_data['recipient']  as $recipient) {
                $mail->addAddress($recipient['email'], $recipient['name']);     //Add a recipient
                // $mail->addAddress('ellen@example.com');               //Name is optional
            }

            if (!empty($array_data['reply_to'])) {
                $mail->addReplyTo($array_data['reply_to']['email'], $array_data['reply_to']['name']);
            }
            if (!empty($array_data['cc'])) {
                foreach ($array_data['cc']  as $cc) {
                    $mail->addCC($cc);
                }
            }
            if (!empty($array_data['bcc'])) {
                foreach ($array_data['bcc']  as $bcc) {
                    $mail->addBCC($bcc);
                }
            }

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $array_data['subject'];
            $mail->Body    = $array_data['message'];
            $mail->AltBody = $array_data['message'];

            $mail->send();
            response()->json(array("status" => 1, "message" => "Message has been sent"));
        } catch (Exception $e) {
            response()->json(array("status" => 0, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
        }
    }
}
