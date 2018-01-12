<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
use AppBundle\Model\ContactSender;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\Contact;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/contact-us")
     */
    public function contactAction(Request $request, ContactSender $sender)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->add('Send', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $sender->sendContactEmail($contact);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/contact.html.twig', ['form' => $form->createView()]);
    }
}
