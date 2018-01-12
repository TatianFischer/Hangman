<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 09/01/2018
 * Time: 17:10
 */

namespace AppBundle\Model;


class ContactSender
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
       $this->mailer = $mailer;
    }

    public function sendContactEmail(Contact $contact)
    {
        $message = \Swift_Message::newInstance();
        $message->setSubject($contact->subject);
        $message->setTo('ble@gdshkh.fr');
        $message->setFrom($contact->senderEmail);
        $message->setBody($contact->message);

        $this->mailer->send($message);
    }
}