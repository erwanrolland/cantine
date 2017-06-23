<?php

namespace ER\CantineBundle\Controller;

use ER\CantineBundle\Entity\Repas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TodayController extends Controller {

    public function parametersToArray() {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $utilisateurs = $utilisateurRepository->findAll();
        $repasRepository = $em->getRepository('ERCantineBundle:Repas');
        $countrepas = $repasRepository->findNbRepasByEtatMange();


        $arrayparameters = ['utilisateur' => $utilisateurs,
            'countrepas' => $countrepas
        ];
        return $arrayparameters;
    }

    public function navAction() {
        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

    public function addRepasAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $requestid = (int) $request->query->get('utilisateur');

        $user = $utilisateurRepository->findOneById($requestid);
        $currentDateTime = new \DateTime();
        $repas = new Repas();
        $repas->setDaterepas($currentDateTime);
        $repas->setEtat('mange');
        $repas->setUtilisateur($user);

        $em->persist($repas);
        $em->flush();
        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

    public function validRepasAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $repasRepository = $em->getRepository('ERCantineBundle:Repas');

        //$today = ['start' => $start = date('Y-m-d 00:00:00', time()), 'end' => date('+1 day', strtotime($start))];
//        $interval = [$start = date('Y-m-d 00:00:00', time()), date('+1 day', strtotime($start))];

        $requestid = (int) $request->query->get('utilisateur');
        $user = $utilisateurRepository->findOneById($requestid);
        $arrayrepas = $repasRepository->findBy(
                ['utilisateur' => $user,
                    'etat' => 'mange'
                ]
        );

        //     $test = date('Y-m-d 00:00:00', time());
        foreach ($arrayrepas as $repas) {
//            $date= $repas->getDateRepas()->format('Y-m-d H:i:s');
            $repas->setEtat('valid');
            $em->persist($repas);
            $em->flush();
        }



        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

    public function cancelRepasAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $repasRepository = $em->getRepository('ERCantineBundle:Repas');

        $requestid = (int) $request->query->get('utilisateur');
        $user = $utilisateurRepository->findOneById($requestid);
        $arrayrepas = $repasRepository->findBy(
                ['utilisateur' => $user,
                    'etat' => 'mange'
                ]
        );
        foreach ($arrayrepas as $repas) {
            $repas->setEtat('cancel');
            $em->persist($repas);
            $em->flush();
        }



        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

}
