<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 09/01/2018
 * Time: 16:17
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('senderEmail',EmailType::class, ['label' => 'Email']);
        $builder->add('subject', TextType::class, ['label' => 'Subject']);
        $builder->add('message', TextareaType::class, ['label' => 'Your message :']);
    }
}