<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 5/9/15
 * Time: 8:46 PM
 */

namespace Advertproject\PlatformBundle\Controller;

use Advertproject\PlatformBundle\Bigbrother\BigbrotherEvents;
use Advertproject\PlatformBundle\Bigbrother\MessagePostEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Advertproject\PlatformBundle\Entity\AdvertSkill;
use Advertproject\PlatformBundle\Entity\Category;
use Advertproject\PlatformBundle\Form\AdvertEditType;
use Advertproject\PlatformBundle\Form\AdvertType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Advertproject\PlatformBundle\Entity\Advert;
use Advertproject\PlatformBundle\Entity\Image;
use Advertproject\PlatformBundle\Entity\Application;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdvertController extends Controller
{

    public function indexAction($page)
    {
        if($page < 1)
        {
            throw new NotFoundHttpException("La page ".$page." est inexistante !");
        }

        $nbPerPage = $this->container->getParameter('nb_per_page');

        $listAdverts = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('APPlatformBundle:Advert')
            ->getAdverts($page, $nbPerPage)
        ;

        $nbPages = ceil(count($listAdverts)/$nbPerPage);

        if($page > $nbPages){
            throw new NotFoundHttpException("La page ".$page." est inexistante !");
        }

        return $this->render('APPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages'     => $nbPages,
            'page'        => $page
        ));
    }

    public function defaultAction()
    {
        //$nbPerPage = $this->container->getParameter('nb_per_page');

        /*$listAdverts = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('APPlatformBundle:Advert')
            ->getAdverts($page, $nbPerPage)
        ;

        $nbPages = ceil(count($listAdverts)/$nbPerPage);

        if($page > $nbPages){
            throw new NotFoundHttpException("La page ".$page." est inexistante !");
        }*/

        return $this->render('APPlatformBundle:Advert:index.html.twig');

    }

    public function viewAction($id)
    {

        $repository = $this->getDoctrine()->getManager()->getRepository('APPlatformBundle:Advert');

        $advert = $repository->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'identifiant ".$id." n'a pas été trouvé");
        }

        return $this->render("APPlatformBundle:Advert:view.html.twig", array(
            "advert" => $advert
        ));

        // On récupère l'EntityManager
        //$em = $this->getDoctrine()->getManager();

        // Pour récupérer une annonce unique : on utilise find()
        //$advert = $em->getRepository('APPlatformBundle:Advert')->find($id);

        // On vérifie que l'annonce avec cet id existe bien
        /*if ($advert === null) {
            throw $this->createNotFoundException("L'annonce d'id ".$id." n'existe pas.");
        }*/

        // On récupère la liste des advertSkill pour l'annonce $advert
        /*$listAdvertSkills = $em->getRepository('APPlatformBundle:AdvertSkill')->findByAdvert($advert);

        $listApplications = $em
            -> getRepository('APPlatformBundle:Application')
            -> findBy(array('advert' => $advert))
        ;*/



        // Puis modifiez la ligne du render comme ceci, pour prendre en compte les variables :
        /*return $this->render('APPlatformBundle:Advert:view.html.twig', array(
            'advert'           => $advert,
            'listAdvertSkills' => $listAdvertSkills,
            'listApplications' => $listApplications
        ));*/
    }

    public function listAction()
    {
        $listAdvert = $this
            -> getDoctrine()
            -> getManager()
            -> getRepository('APPlatformBundle:Advert')
            -> getAdvertWithApplications()
        ;

        foreach($listAdvert as $advert)
        {
            $advert->getApplications();
        }
    }


    public function addAction(Request $request)
    {
        /*if(!$this->get('security.context')->isGranted('ROLE_USER'))
        {
            throw new AccessDeniedException('Please create an account to submit an advert');
        }*/

        //On crée un objet Advert
        $advert = new Advert();

        $advert->setAuthor('Patrick Ghislain');
        $advert->setContent('Nous recherchons un développeur Symfony2.');
        $advert->setTitle('Développeur Symfony2');

        //On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        //Etape 1 : on persiste l'entité
        $em->persist($advert);

        // On "flush" tout ce qui a été persisté avant
        $em->flush();

        if ($request->isMethod('POST')) {
            $request->getSession()-> getFlashBag()->add('notice', 'L\'annonce a bien été ajoutée !');

            return $this->redirect($this->generateUrl('ap_platform_view', array('id' => $advert->getId())));
        }

        return $this->render('APPlatformBundle:Advert:add.html.twig');

        //Grâce au service 'form.factory', on crée le formBuilder
        //$form = $this->get('form.factory')-> create(new AdvertType(), $advert);
        //$form = $this->createForm(new AdvertType(), $advert);

        /*if($form->handleRequest($request)->isValid())
        {
            $antispam = $this->container->get('ap_platform.antispam');
            if ($antispam->isSpam($advert->getContent())) {
                throw new \Exception('Votre contenu est trop court !');
            }
            //$event = new MessagePostEvent($advert->getContent(), $advert->getAuthor());

            //Triggering the event
           // $this->get('event_dispatcher')->dispatch(BigbrotherEvents::onMessagePost, $event);

            /*$application1 = new Application();
            $application1->setContent('Je suis intéressé');
            $application1->setAuthor('Jacques');
            $application1->setAdvert($advert);

            $application2 = new Application();
            $application2->setContent('Moi aussi, je suis intéressé');
            $application2->setAuthor('Patrick');
            $application2->setAdvert($advert);*/

            //$em = $this->getDoctrine()->getManager();
            //$em->persist($advert);
           // $em->persist($application1);
            //$em->persist($application2);

            //$em->flush();

            /*$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée !');

            return $this->redirect($this->generateUrl('ap_platform_view', array('id' => $advert->getId())));
        }

        return $this->render('APPlatformBundle:Advert:add.html.twig', array(
           'form' => $form->createView()
        )); */

    }

    public function editAction($id, Request $request)
    {

        $advert1 = new Advert();
        $advert1->setTitle('Infographiste sur Casablanca pour un CDD');
        $advert1->setContent('Nous recherchons un infographiste pour mission de 3 mois sur Casablanca');
        $advert1->setAuthor('Ghislain');

        $em = $this->getDoctrine()->getManager();
        $advert2 = $em->getRepository('Advertproject\PlatformBundle\Entity\Advert')->find(4);

        $advert2->setDate(new \DateTime());

        $em->persist($advert1);

        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'L\'annonce a bien été ajoutée');

        return $this->redirect($this->generateUrl('ap_platform_view', array(
            'id' => $advert2->getId()
        )));

        /*$em = $this->getDoctrine()->getManager();
        $advert = $em
            ->getRepository("APPlatformBundle:Advert")
            ->find($id);

        if(null === $advert)
        {
            throw new NotFoundHttpException("L'annonce ".$id." est inexistante.");
        }

        $form = $this->createForm(new AdvertEditType(), $advert);
        if($form->handleRequest($request)->isValid()){

            // On crée l'évènement avec ses 2 arguments
            $event = new MessagePostEvent($advert->getContent(), $this->getUser());

            // On déclenche l'évènement
            $this
                ->get('event_dispatcher')
                ->dispatch(BigbrotherEvents::onMessagePost, $event)
            ;

            // On récupère ce qui a été modifié par le ou les listeners, ici le message
            $advert->setContent($event->getMessage());

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Advert updated!');
            return $this->redirect($this->generateUrl('ap_platform_view', array('id' => $advert->getId())));
        }

        return $this->render('APPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert,
            'form'   => $form->createView()
        )); */
    }

    public function menuAction()
    {
        $listAdverts = array(
            array('id'=>2, 'title'=>'Développeur Web', 'author'=>'Patrick', 'content'=>'Je cherche un développeur Web pour un projet web bien rémunéré'),
            array('id'=>7, 'title'=>'Offre de stage webdesigner', 'author'=>'Bass', 'content'=>'Je cherche un webdesigner Web pour un stage pré-embauche à Casablanca'),
            array('id'=>11, 'title'=>'Développeur Symfony2', 'author'=>'Ghis', 'content'=>'Je cherche un développeur Symfony2 pour un projet ô combien intéressant')
        );

        return $this->render('APPlatformBundle:Advert:menu.html.twig',
            array(
                'listAdverts'=>$listAdverts
            )
        );
    }

    public function editImageAaction($advertId)
    {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository("APPlatformBundle:Advert")->find($advertId);



        $em->flush();

        return new Response('OK');
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em
            -> getRepository("APPlatformBundle:Advert")
            -> find($id);

        if(null === $advert)
        {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        //On crée un formulaire vide contenant uniquement le champ CSRF afin de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();
        if($form->handleRequest($request)->isValid()){
            $em->remove($advert);
            $em ->flush();
            $request->getSession()->getFlashBag()->add('info', 'Annonce supprimée');
            return $this->redirect($this->generateUrl('ap_platform_home'));
        }

        return $this->render('APPlatformBundle:Advert:delete.html.twig', array(
           'form'    => $form->createView(),
            'advert' => $advert
        ));
    }

    public function testAction()
    {
        $forbiddenWords = array('échec', 'abandon');
        $response = implode('|',$forbiddenWords);
        return new Response($response);
        /*$advert = new Advert();
        $advert->setDate(new \DateTime());
        $advert->setTitle('abc');
        $advert->setAuthor('hbkl');

        $listErrors = $this->get('validator')->validate($advert);
        if(count($listErrors)>0){
            var_dump(print_r($listErrors));exit;
        }else{
            return new Response('Annonce valide');
        }*/

    }


    public function downloadModulesPdfAction($file)
    {

        $path = "downloads/";

        $response = new Response();
        $response->setContent(file_get_contents($path . $file));
        $response->headers->set(
            'Content-Type',
            'application/pdf'
        );
        $response->headers->set('Content-disposition', 'filename=' . $file);

        return $response;
    }
} 