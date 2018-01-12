<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 09/01/2018
 * Time: 16:08
 */

namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as A;


class Contact
{
    /**
     * @A\Email()
     */
    public $senderEmail;

    /**
     * @A\NotBlank()
     * @A\Length(max=20)
     */
    public $subject;

    /**
     * @A\NotBlank()
     */
    public $message;
}