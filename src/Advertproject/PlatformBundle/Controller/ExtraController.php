<?php

namespace Advertproject\PlatformBundle\Controller;

use Advertproject\PlatformBundle\Entity\Choix;
use Advertproject\PlatformBundle\Entity\Votant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class ExtraController extends Controller
{


    
    public function nakevoteAction(Request $request)
    {
        //var_dump($request);die;
        //phpinfo();  PHP Version 7.2.19-0ubuntu0.18.04.1
        //exit;

        $form = $this->createFormBuilder()
            ->add('prenom', 'text', array('required' => true))
            ->add('password', 'password', array('required' => true))

            ->getForm()
        ;

        $listVotants = array(
            "packsonxpa@hotmail.com" => "6#yhD3skA_r2!x6z",
            "gfmoukissi@gmail.com" => "Qf_h+s4uG6?nPGmw",
            #"ghislainokondza@gmail.com" => "erLkLW9&6hp3fy&u",
            "eakondzo@gmail.com" => "CM*EPrbWb#5@5@Q+",
            "marien.snov@hotmail.com" => "n%kSL+RCS4jrprN-",
            "gatienb@gmail.com" => "FD4yvV_a3M2asy4",
            #"tresor.aloula@vinci-construction.com" => "*?6!JwTW56#CEysu",
            "ndoupatrice@gmail.com" => "xjwanpJek8?zU?ye",
            "Leyono_borel@hotmail.com" => "^7Us%dVgbTKKTK@M",
            "Ossouala.mbama@gmail.com" => "G9bnPd+8tmrz_^y",
            /*"bennytouazock@gmail.com" => "=s-2Vax@s6WK5yX!",
            "Lekevlar06@gmail.com" => "97N*!pzMs8h9K3v",
            "smiakoundoba@yahoo.fr" => "+gBk%B8gpCK#W=UH",*/
            "gabrielleyaca@gmail.com" => "f9#H9&Muvg87LqwZ",
            #"ravelthombet@gmail.com" => "AG#j@%VwHq78-YW%",
            "yagnemas@gmail.com" => "-3W%Hdr*dG=uc=eM",
            "Josidney2000@gmail.com" => "as=_LDk#8q8AQ+ev",
            "Andrade19762000@yahoo.fr" => "?mL&e_45VfGB2fP!",
            "judebakoula@yahoo.fr" => "VgNCD46dF6ws=5&h",
            "dikobathartmann@gmail.com" => "^D@_D4AtFm?qFARt",
            "awakondzo@gmail.com" => "mRmZK!QKs9bRCg#B",
            #"Joebusiness2016@yahoo.com" => "^L3uFF2rq2bF9Bsp",
            "dorisseo@aol.com" => "sw8&2GwrCFb!-N5c",
            #"nchardene@gmail.com" => "e-*8y*E6czye_H%f",
            "lgmartinien@hotmail.fr" => "uX%4U#7+TNQ_q76a",
            #"Kojac571@gmail.com" => "wUF2*jyb33D?2sQW",
            "demillet2000@yahoo.fr" => "eC^pUtcLg4r?urNA",
            /*"Malongasabine1812@gmail.com" => "x2@2c8MAAhM!=j%6",
            "Neil.ndzaba@gmail.com" => "Ax+8+*_ZYUzPVd=U",*/
            "kursha59@gmail.com" => "E&3FXGyPZB7EG8L",
            /*"wilder529@gmail.com" => "45mTgZ*HtP%z4qH",
            "Ond_alex@yahoo.fr" => "d+T%3LftJr8nS^R+",
            "Harold.likibi@gmail.com" => "X8%Js@%t@ZQPw6N5",*/
            "gilden18@yahoo.fr" => "J2!DZ@ztpJV5E7Rg",
            /*"Melocool2002@yahoo.fr" => "p^ej26FdfPjPa9aT",
            "Chardene25@hotmail.com" => "D9ApQhCd?6Y6dR",
            "ghislainokondza@gmail.com" => "6vH#dV2bem22bc5M",
            "ndolonsika@yahoo.fr" => "jDbBx=b&7*Y4^%hx",
            "Celibelle80@gmail.com" => "4?TQM@M!XqKT&Kdk",*/
            "bertrandakouabossi@gmail.com" => "dAwJWAjMB=24n-H#",
        );

        $cj = array('judebakoula@yahoo.fr', 'packsonxpa@hotmail.com', 'mariens.nov@hotmail.com', 'tresor.aloula@vinci-construction.com', 'a.roland@odellya.com', 'Patrick.bassoukissa@helvetica.ma', 'Josidney2000@gmail.com', 'awakondzo@gmail.com', 'ndoupatrice@gmail.com', 'gatienb@gmail.com');

        $form->handleRequest($request);
        //dump($prenom);die;

        $password = $form->get('password')->getData();

        $prenom = $form->get('prenom')->getData();
        $session = $request->getSession();
        if (!$session->has('votant')) $session->set('votant', $prenom);
        $prenom = $session->get('votant');



        if ($form->isSubmitted() && $form->isValid()) {

            //die('après isSubmitted');

            foreach ($listVotants as $key => $value) {
                if ($key == $prenom && $password == $value) {
                    return $this->redirect($this->generateUrl('tokevote', array(
                        'votant' => $prenom,
                    )));

                } else {

                    $request->getSession()->getFlashbag()->add('notice', 'Yo nani ? Té to yébi yo té, longwa !');

                }
            }


            if (array_key_exists($prenom, $listVotants) && $password == $listVotants[$prenom]) {
                return $this->redirect($this->generateUrl('tokevote', array(
                    'votant' => $prenom,
                    'cj'     => $cj
                )));

            } else {

                $request->getSession()->getFlashbag()->add('notice', 'Yo nani ? Té to yébi yo té, longwa !');
                $session->remove('votant');

            }

        }

        //die('contournement de isSubmitted');

        return $this->render('APPlatformBundle:Extra:identification.html.twig', array(
            'form' => $form->createView()
        ));


    }

    
    public function tokevoteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createFormBuilder()
            ->add('proposition', 'entity', array(
                'class' => 'APPlatformBundle:Choix',
                'property' => 'proposition',
                'multiple'=>true,
                'expanded'=>true

            ))
            ->getForm()
        ;

        $form->handleRequest($request);


        $cj = array('judebakoula@yahoo.fr','packsonxpa@hotmail.com', 'mariensnov@hotmail.com', 'tresor.aloula@vinci-construction.com', 'a.roland@odellya.com', 'Patrick.bassoukissa@helvetica.ma', 'Josidney2000@gmail.com', 'awakondzo@gmail.com', 'ndoupatrice@gmail.com', 'gatienb@gmail.com');

        $votantOld = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('APPlatformBundle:Votant')
            ->findOneByName(array('name' => $session->get('votant')))
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($session->has('votant')) $voter = $request->getSession()->get('votant');
            
            $proposition = $form->get('proposition')->getData();
            
            $choix = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('APPlatformBundle:Choix')
                ->findOneByProposition(array('proposition' => $proposition->getProposition()))
            ;

            if ( $session->has('votant') && !is_object($votantOld)) {
                $count = $choix->getCount();
            
                $count++;
                $choix->setCount($count);
            
                $votant = new Votant();
            
                $votant->setName($session->get('votant'));
                $votant->setChoix($choix);
                $votant->setHasVoted(true);
                $em->persist($votant);
            
                    
                $em->flush();

                $request->getSession()->getFlashbag()->add('votesaved', 'Melessi, to enregistré vote na yo !');


            } else {
                $request->getSession()->getFlashbag()->add('mbalamoko', 'Mbala moko kaka, okoki kopona lisusu té ! Eh yo ! Malembé !');
            }
            
             
            
        }
        
        $listChoix = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('APPlatformBundle:Choix')
            ->findAll()
        ;
        
        $total = 0;
        foreach ($listChoix as $choix) {
            $total += $choix->getCount();
        }

        
        return $this->render('APPlatformBundle:Extra:tokevote.html.twig', array(
            'form' => $form->createView(),
            'listChoix' => $listChoix,
            'total'=> $total,
            'cj'   => $cj,
            'votantOld' => $votantOld
        ));
    }

    public function deconnexionAction(Request $request)
    {
        $session = $request->getSession();

        if ($session->has('votant')) $session->remove('votant');
    }

}


