<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 14/01/2018
 * Time: 17:00
 */

namespace AppBundle\Contact;


use Symfony\Component\Validator\Constraints as Assert;

class ContactRequest
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $senderEmail;
    
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=100)
     */
    private $subject;
    
    /**
     * @Assert\NotBlank
     */
    private $message;
    
    public function __construct($senderEmail, $subject, $message)
    {
        $this->senderEmail  =   $senderEmail;
        $this->subject      =   $subject;
        $this->message      =   $message;
    }

    /**
     * @return mixed
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    public function toSwiftMessage($recipient)
    {
        $email = \Swift_Message::newInstance()
            ->setFrom($this->senderEmail)
            ->setTo($recipient)
            ->setSubject($this->subject)
            ->setBody($this->message)
        ;

        return $email;
    }
}