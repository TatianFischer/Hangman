<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 09/01/2018
 * Time: 16:17
 */

namespace AppBundle\Contact;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('senderEmail',
                EmailType::class,
                ['label' => 'Email'])
            ->add('subject',
                TextType::class,
                ['label' => 'Subject'])
            ->add('message',
                TextareaType::class,
                ['label' => 'Your message :',
                    'attr' => [
                        'rows' => 15,
                        'cols' => 20
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactRequest::class,
            'empty_data' => function (FormInterface $form) {
                return new ContactRequest(
                    $form->get('senderEmail')->getData(),
                    $form->get('subject')->getData(),
                    $form->get('message')->getData()
                );
            },
        ]);
    }
}