<?php

namespace AppBundle\Controller;

use AppBundle\Contact\ContactRequestType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/contact-us")
     *
     * @var Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactRequestType::class);
        $form->add('Send', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $message = $form->getData()->toSwiftMessage($this->getParameter('contact_recipient'));
            $this->get('mailer')->send($message);
            $this->addFlash('notice', 'contact.email_sent');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/contact.html.twig', ['form' => $form->createView()]);
    }
}
