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
        //dump($request);die;

        $form = $this->createFormBuilder()
            ->add('prenom', 'text', array('required' => true))
            ->add('password', 'password', array('required' => true))

            ->getForm()
        ;

        $listVotants = [
            "Chrisbel" => "6#yhD3skA_r2!x6z",
            "Guy" => "Qf_h+s4uG6?nPGmw",
            "Quelfred" => "erLkLW9&6hp3fy&u",
            "Packo" => "CM*EPrbWb#5@5@Q+",
            "Patrice" => "n%kSL+RCS4jrprN-",
            "Sidney" => "FD4yvV_a3M2asy4",
            "Marien" => "*?6!JwTW56#CEysu",
            "Wilder" => "xjwanpJek8?zU?ye",
            "Karl" => "^7Us%dVgbTKKTK@M",
            "Vianney" => "G9bnPd+8tmrz_^y",
            "Armel" => "=s-2Vax@s6WK5yX!",
            "Gatien" => "97N*!pzMs8h9K3v",
            "Elitch" => "+gBk%B8gpCK#W=UH",
            "Davy" => "f9#H9&Muvg87LqwZ",
            "Yann" => "AG#j@%VwHq78-YW%",
            "Destin" => "-3W%Hdr*dG=uc=eM",
            "Borefe" => "as=_LDk#8q8AQ+ev",
            "Michael" => "?mL&e_45VfGB2fP!",
            "Mhaco" => "tAwQWAjMA=24n-H#",
            "Innocent" => "VgNCD46dF6ws=5&h",
            "Séverin" => "^D@_D4AtFm?qFARt",
            "Modeste" => "mRmZK!QKs9bRCg#B",
            "Fustel" => "^L3uFF2rq2bF9Bsp",
            "Tresor" => "sw8&2GwrCFb!-N5c",
            "Borel" => "e-*8y*E6czye_H%f",
            "Mbama" => "uX%4U#7+TNQ_q76a",
            "Bertrand" => "wUF2*jyb33D?2sQW",
            "Lebreche" => "eC^pUtcLg4r?urNA",
            "Dikobat" => "x2@2c8MAAhM!=j%6",
            "Harold" => "Ax+8+*_ZYUzPVd=U",
            "Gildas" => "E&3FXGyPZB7EG8L",
            "Jude" => "45mTgZ*HtP%z4qH",
            "Christel" => "d+T%3LftJr8nS^R+",
            "Wilson" => "X8%Js@%t@ZQPw6N5",
            "Alain" => "J2!DZ@ztpJV5E7Rg",
            "Steph" => "p^ej26FdfPjPa9aT",
            "Verlain" => "D9ApQhCd?6Y6dR",
            "Franck Matete" => "6vH#dV2bem22bc5M",
            "Paracle" => "jDbBx=b&7*Y4^%hx",
            "Behn" => "4?TQM@M!XqKT&Kdk",
            "Ghislain" => "!HGaVKE55C2Ya!89",
            "Kojac" => "hdw9?KH9pN-Az"
        ];

        $form->handleRequest($request);
        //dump($prenom);die;

        $password = $form->get('password')->getData();

        $prenom = $form->get('prenom')->getData();
        $request->getSession()->set('votant', $prenom);

        if ($form->isSubmitted() && $form->isValid()) {

            /*foreach ($listVotants as $key => $value) {
                if ($key == $prenom && $password == $value) {
                    return $this->redirect($this->generateUrl('tokevote', array(
                        'votant' => $prenom,
                    )));

                } else {

                    $request->getSession()->getFlashbag()->add('notice', 'Yo nani ? Té to yébi yo té, longwa !');

                }
            }*/

            if (array_key_exists($prenom, $listVotants) && $password == $listVotants[$prenom]) {
                return $this->redirect($this->generateUrl('tokevote', array(
                    'votant' => $prenom,
                )));

            } else {

                $request->getSession()->getFlashbag()->add('notice', 'Yo nani ? Té to yébi yo té, longwa !');

            }

        }



        return $this->render('APPlatformBundle:Extra:identification.html.twig', array(
            'form' => $form->createView()
        ));


    }

    
    public function tokevoteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
            ->add('proposition', 'entity', array(
                'class' => 'APPlatformBundle:Choix',
                'property' => 'proposition',
                'multiple'=>false,
                'expanded'=>true

            ))
            ->getForm()
        ;

        $form->handleRequest($request);

        


        if ($form->isSubmitted() && $form->isValid()) {
            /*$voter = $request->getSession()->get('votant');
            
            $proposition = $form->get('proposition')->getData();
            
            $choix = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('APPlatformBundle:Choix')
                ->findOneByProposition(array('proposition' => $proposition->getProposition()))
            ;
            
            $haveVoted = [];
            foreach ($choix->getVotants() as $v) {
                $haveVoted[] = $v->getName();    
            }
            
            if (!in_array($voter, $haveVoted)) {
                $count = $choix->getCount();
            
                $count++;
                $choix->setCount($count);
            
                $votant = new Votant();
            
                $votant->setName($voter);
                $votant->setChoix($choix);
                $em->persist($votant);
            
            
                    
                $em->flush();        
            } else {
                $request->getSession()->getFlashbag()->add('mbalamoko', 'Mbala moko kaka, okoki kopona lisusu té !');
            }*/
            
             
            
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
            'total'=> $total
        ));
    }

}


