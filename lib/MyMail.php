<?php

namespace Lib;

use Lib\Config;
use Model\User;

/**
 * MyMail
 */
class MyMail
{
    private $from = '';
    private $sendTo = '';
    private $subject = '';
    private $fields = [
        'name' => 'Name',
        'surname' => 'Surname',
        'need' => 'Need',
        'email' => 'Email',
        'message' => 'Message'
    ];
    private $emailText = '';
    private $webUrl = '';
    private const OK_MESSAGE = 'Votre message a bien été envoyé.';
    private const ACTIVATION_MESSAGE = 'Un email d\'activation vous a été envoyé.';
    private const ERROR_MESSAGE = 'Une erreur est survenue. Veuillez réessayer plus tard.';

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $config = Config::getInstance();
        $this->sendTo = $config->get('sendTo');
        $this->from = $config->get('from');
        $this->subject = $config->get('subject');
        $this->webUrl = $config->get('webUrl');
    }

    /**
     * sendEmailToAdmin
     *
     * @param  mixed $tab
     * @return void
     */
    public function sendEmailToAdmin(array $tab)
    {
        try {
            foreach ($tab as $key => $value) {
                // If the field exists in the $fields array, include it in the email
                if (isset($this->fields[$key])) {
                    $this->emailText .= $this->fields[$key] . ": $value\n";
                }
            }
            // use wordwrap() if lines are longer than 70 characters
            $this->emailText = wordwrap($this->emailText, 70);

            // All the neccessary headers for the email.
            $headers = [
                'Content-Type: text/plain; charset="UTF-8";',
                'From: ' . $this->from,
                'Reply-To: ' . $this->from,
                'Return-Path: ' . $this->from,
            ];
            // Send email
            if (mail($this->sendTo, $this->subject, $this->emailText, implode("\n", $headers))) {
                return array('type' => 'success', 'message' => self::OK_MESSAGE);
            }
            return array('type' => 'danger', 'message' => self::ERROR_MESSAGE);
        } catch (\Exception $e) {
            return array('type' => 'danger', 'message' => self::ERROR_MESSAGE);
        }
    }

    /**
     * sendActivationEmail
     *
     * @param  mixed $user
     * @return void
     */
    public function sendActivationEmail(User $user)
    {
        try {
            $this->sendTo = $user->getEmail();
            $this->subject = 'Validation de votre compte.';

            $this->emailText = '<html> 
        <head> 
            <titleBienvenu(e) sur mon blog</title> 
        </head> 
        <body> 
            <h1>Merci de vous joindre à nous !</h1> 
            <p>Vos informations</p>
            <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
                <tr> 
                    <th>Nom :</th><td>' . $user->getName() . ' ' . $user->getFirstName() . '</td> 
                </tr> 
                <tr style="background-color: #e0e0e0;"> 
                    <th>Email:</th><td>' . $user->getEmail() . '</td> 
                </tr> 
            </table>
            <br/>
            <p>Activer votre compte</p>
            <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
                <tr style="background-color: #e0e0e0;"> 
                    <th><a href="' . $this->webUrl . '/activation/?p='
                    . $user->getPseudo() . '&v=' . $user->getValidationKey() . '">Activer votre compte</a></th> 
                </tr> 
            </table>
        </body> 
        </html>';

            // All the neccessary headers for the email.
            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset="UTF-8";',
                'From: ' . $this->from,
                'Reply-To: ' . $this->from,
                'Return-Path: ' . $this->from,
            ];
            // Send email
            if (mail($this->sendTo, $this->subject, $this->emailText, implode("\n", $headers))) {
                return array('type' => 'success', 'message' => self::ACTIVATION_MESSAGE);
            }
            return array('type' => 'danger', 'message' => self::ERROR_MESSAGE);
        } catch (\Exception $e) {
            return array('type' => 'danger', 'message' => self::ERROR_MESSAGE);
        }
    }

    /**
     * sendConnectedMail
     *
     * @param  mixed $user
     * @param  mixed $code
     * @return void
     */
    public function sendConnectedMail(User $user, $code)
    {
        try {
            $this->sendTo = $user->getEmail();
            $this->subject = 'Vous êtes déjà connecté.';

            $this->emailText = '<html> 
        <head> 
            <titleBienvenu(e) sur mon blog</title> 
        </head> 
        <body> 
            <h1>Merci de vous joindre à nous !</h1> 
            <p>Vous n\'avez pas réussi à vous connecté.</p>
            <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
                <tr> 
                    <th>Nom :</th><td>' . $user->getName() . ' ' . $user->getFirstName() . '</td> 
                </tr> 
                <tr style="background-color: #e0e0e0;"> 
                    <th>Email:</th><td>' . $user->getEmail() . '</td> 
                </tr> 
            </table>
            <br/>
            <p>Pour déboquer votre compte, cliquer sur le lien ci-dessous.</p>
            <p>Si cela n\'était pas vous, nous vous recommendons de changer votre mot de passe une fois connecté.</p>
            <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
                <tr style="background-color: #e0e0e0;"> 
                    <th><a href="' . $this->webUrl . '/code/?p='
                    . $user->getPseudo() . '&v=' . $user->getValidationKey() . '">Débloquer votre compte</a></th> 
                </tr> 
            </table>
        </body> 
        </html>';

            // All the neccessary headers for the email.
            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset="UTF-8";',
                'From: ' . $this->from,
                'Reply-To: ' . $this->from,
                'Return-Path: ' . $this->from,
            ];
            // Send email
            if (mail($this->sendTo, $this->subject, $this->emailText, implode("\n", $headers))) {
                return array('type' => 'success', 'message' => self::ACTIVATION_MESSAGE);
            }
            return array('type' => 'danger', 'message' => self::ERROR_MESSAGE);
        } catch (\Exception $e) {
            return array('type' => 'danger', 'message' => self::ERROR_MESSAGE);
        }
    }
}
