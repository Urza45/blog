<?php

namespace Lib;

use \Lib\Config;

class MyMail 
{
    private $from = '';
    private $sendTo = '';
    private $subject = '';
    private $fields = ['name' => 'Name', 'surname' => 'Surname', 'need' => 'Need', 'email' => 'Email', 'message' => 'Message'];
    private $emailText = '';
    const OK_MESSAGE = 'Votre message a bien été envoyé.';
    const ERROR_MESSAGE = 'Une erreur est survenue. Veuillez réessayer plus tard.';

    public function __construct()
    {
        $config = Config::getInstance();
        $this->sendTo = $config->get('sendTo');
        $this->from = $config->get('from');
        $this->subject = $config->get('subject');
    }

    public function sendEmailToAdmin(array $tab)
    {
        try
        {   
        
            foreach ($tab as $key => $value) {
                // If the field exists in the $fields array, include it in the email 
                if (isset($this->fields[$key])) {
                    $this->emailText .= $this->fields[$key]. ": $value\n";
                }
            }
            // use wordwrap() if lines are longer than 70 characters
            $this->emailText = wordwrap($this->emailText,70);

            // All the neccessary headers for the email.
            $headers = array('Content-Type: text/plain; charset="UTF-8";',
                'From: ' . $this->from,
                'Reply-To: ' . $this->from,
                'Return-Path: ' . $this->from,
            );
            // Send email

            mail($this->sendTo, $this->subject, $this->emailText, implode("\n", $headers));
            return array('type' => 'success', 'message' => self::OK_MESSAGE);
        }
        catch (\Exception $e)
        {
            return array('type' => 'danger', 'message' => self::ERROR_MESSAGE);
        }
    }
}