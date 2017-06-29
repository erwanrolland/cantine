<?php

namespace ER\CantineBundle\Controller;

use ER\CantineBundle\Entity\Repas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TodayController extends Controller {

    public function parametersToArray() {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $utilisateurs = $utilisateurRepository->findBy(['actif' => true]);

        $repasRepository = $em->getRepository('ERCantineBundle:Repas');
        $datetoday = date('Y-m-d');
        $date1 = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00', strtotime($date1 . '+1day'));

        $arrayrepastoday = $repasRepository->findRepasBydate($date1, $date2);
        $countrepas = $repasRepository->findNbRepasByEtatAndDate($date1, $date2, 'mange');

        $arrayparameters = ['utilisateur' => $utilisateurs,
            'countrepas' => $countrepas,
            'datetoday' => $datetoday,
            'arrayrepas' => $arrayrepastoday
        ];
        return $arrayparameters;
    }

    public function navAction() {
        $this->addFlash('notice', "S'inscrire");
        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

    public function addRepasAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $userid = (int) $request->query->get('utilisateur');
        $repasRepository = $em->getRepository('ERCantineBundle:Repas');
        $user = $utilisateurRepository->findOneById($userid);
        $currentDateTime = new \DateTime();
        $date1 = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00', strtotime($date1 . '+1day'));
        $repastodayuser = $repasRepository->findRepasBydateAndUtilisateur($date1, $date2, $userid);

        if (empty($repastodayuser)) {
            $newrepas = new Repas();
            $newrepas->setDaterepas($currentDateTime);
            $newrepas->setEtat('mange');
            $newrepas->setUtilisateur($user);
            $em->persist($newrepas);
            $this->addFlash('notice', 'Ajout  nouveau repas!', $user->getNom());
        }

        foreach ($repastodayuser as $repas) {
            if ($repas->getEtat() == 'mange') {
                $this->addFlash('notice', "Repas déjà ajouté pour : " . $user->getNom());
            } elseif ($repas->getEtat() == 'cancel') {
                $repas->setEtat('mange');
                $em->persist($repas);
                $this->addFlash('notice', "Passage de annulé à mange pour : " . $user->getNom());
            } else {
                $this->addFlash('notice', "Repas validé pour : " . $user->getNom());
            }
        }
        $em->flush();

        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

    public function cancelRepasAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $repasRepository = $em->getRepository('ERCantineBundle:Repas');
        $userid = (int) $request->query->get('utilisateur');
        $user = $utilisateurRepository->findOneById($userid);
        $date1 = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00', strtotime($date1 . '+1day'));
        $repastodayuser = $repasRepository->findRepasBydateAndUtilisateur($date1, $date2, $userid);
        foreach ($repastodayuser as $repas) {

            if ($repas->getEtat() == 'valid') {
                $this->addFlash('notice', 'Repas validé impossible d\'annuler pour : ' . $user->getNom());
            } elseif ($repas->getEtat() == 'mange') {
                $repas->setEtat('cancel');
                $em->persist($repas);
                $em->flush();
                $this->addFlash('notice', 'Repas annulé pour : ' . $user->getNom());
            } else {
                $this->addFlash('notice', 'Repas déjà annulé pour : ' . $user->getNom());
            }
        }
        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

    public function validRepasAction() {
        $em = $this->getDoctrine()->getManager();
        $repasRepository = $em->getRepository('ERCantineBundle:Repas');
        $date1 = date('Y-m-d 00:00:00');
        $date2 = date('Y-m-d 00:00:00', strtotime($date1 . '+1day'));
        $repastodayuser = $repasRepository->findRepasBydate($date1, $date2);

        foreach ($repastodayuser as $repas) {
            if ($repas->getEtat() == 'mange') {
                $repas->setEtat('valid');
                $em->persist($repas);
            }
            if ($repas->getEtat() == 'cancel') {
                $repas->setEtat('cancelvalid');
                $em->persist($repas);
            }
        }$this->addFlash('notice', "Repas validé pour tous les utilisateurs ayant mangé");
        $em->flush();
        return $this->render('ERCantineBundle::aujourdhui.html.twig', $this->parametersToArray());
    }

}
