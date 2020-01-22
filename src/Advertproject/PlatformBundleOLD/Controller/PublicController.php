<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 8/26/15
 * Time: 3:33 PM
 */

namespace Advertproject\PlatformBundle\Controller;


use Advertproject\PlatformBundle\Entity\Contact;
use Advertproject\PlatformBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{
    public function aboutAction()
    {
        return $this->render("APPlatformBundle:Public:about.html.twig");
    }

    public function contactAction(Request $request)
    {


        // Retrieving POST data
        //$postData = $request->request->get('email');


        $contact = new Contact();

        //$form = $this->createForm(new ContactType(), $contact);


        $form = $this
            ->createForm(new ContactType(), $contact)
            ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->get('ap_platform.antispam')->isSpam($contact->getMessage())) {
                throw new \Exception('The field email is either empty or its content is too short');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            //var_dump($contact->getEmail());exit;

            $request->getSession()->getFlashBag()->add('notice', 'Votre message a été envoyé !');

            $mailer = $this->get('mailer');

            $message =  \Swift_Message::newInstance()
                ->setSubject('Message venant du formulaire de contact de chyqat-formation.com')
                ->setFrom('chyqat@chyqat-formation.com')
                ->setTo('chyqat@gmail.com')
                ->setBody("Nouveau message provenant de : ".$contact->getName()."\n Adresse Email : ".$contact->getEmail()."\n\n Son message:".$contact->getMessage())
            ;

            $mailer->send($message);

            unset($contact);
            unset($form);
            $contact = new Contact();
            $form = $this->createForm(new ContactType(), $contact);
        }

        return $this->render("APPlatformBundle:Public:contact.html.twig", array(
            'form' => $form->createView()
        ));
    }
} 