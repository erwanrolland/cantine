<?php

namespace ER\CantineBundle\Controller;

use ER\CantineBundle\Entity\Miseajour;
use ER\CantineBundle\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller {

    public function parametersToArray() {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('ERCantineBundle:Course');
        $repas = $em->getRepository('ERCantineBundle:Repas');
        $date1 = date('Y-m-d H:i:s');
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $utilisateurs = $utilisateurRepository->findBy(['actif' => true]);
        $maj = $em->getRepository('ERCantineBundle:Miseajour');
        $lastupdate=$maj->findLastUpdate();
        $somme = $course->findSommeBetweenTwoDate($lastupdate, $date1);
        $count = $repas->findNbRepasByEtatAndDate($lastupdate, $date1, 'valid');
        if ($count == 0) {
            $prixrepas = $somme;
        } else {
            $prixrepas = $somme / $count;
        }
        $arraynbrepasbyuser = [];

        foreach ($utilisateurs as $user) {
            $arraynbrepasbyuser[] = $repas->findNbRepasByUser($lastupdate, $date1, $user->getId());
        }
        $arrayparameters = [
            'count' => $count,
            'somme' => $somme,
            'utilisateur' => $utilisateurs,
            'lastupdate' => $lastupdate,
            'prixrepas' => $prixrepas,
            'arraynbrepasbyuser' => $arraynbrepasbyuser
        ];
        return $arrayparameters;
    }

    public function navAction() {
        $em = $this->getDoctrine()->getManager();
        $maj = $em->getRepository('ERCantineBundle:Miseajour');
        $lastupdate=$maj->findLastUpdate();
      
        if (empty($lastupdate)) {
            $datemaj = new \DateTime('2017-07-03 00:00:00');
            $lastupdate = new Miseajour();
            $lastupdate->setDatemaj($datemaj);
            $em->persist($lastupdate);
            $em->flush();
        }

        return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
    }

    public function updateAccountAction() {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $utilisateurs = $utilisateurRepository->findBy(['actif' => true]);
        $course = $em->getRepository('ERCantineBundle:Course');
        $repas = $em->getRepository('ERCantineBundle:Repas');
        $maj = $em->getRepository('ERCantineBundle:Miseajour');
        $date1 = date('Y-m-d H:i:s');
        $lastupdate= $maj->findLastUpdate();
        $somme = $course->findSommeBetweenTwoDate($lastupdate, $date1);
        $count = $repas->findNbRepasByEtatAndDate($lastupdate, $date1, 'valid');

        if ($count == 0) {
            $this->addFlash('count', 'Aucun repas validé depuis la dernière mise à jour');
            return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
        }
        $unitprice = $somme / $count;
        foreach ($utilisateurs as $user) {
            $userid = $user->getId();
            $count = $repas->findNbRepasByUser($lastupdate, $date1, $userid);
            $oldtotal = $user->getTotal();
            $newtotal = ($count * $unitprice) + $oldtotal;

            $user->setTotal($newtotal);
            $em->persist($user);
        }

        $datemaj = new \DateTime();
        $miseajour = new Miseajour();
        $miseajour->setDatemaj($datemaj);
        $em->persist($miseajour);
        $em->flush();
        $this->addFlash('count', 'mise à jour');
        return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
    }

    public function addCourseAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $requestid = (int) $request->query->get('utilisateur');
        $user = $utilisateurRepository->findOneById($requestid);
        $price = $request->request->get('addcourse');
        if ($price == 0) {
            return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
        }
        $datecourse = new \DateTime();
        $course = new Course();
        $course->setUtilisateur($user);
        $course->setPrix($price);
        $course->setDatecourse($datecourse);
        $total = $user->getTotal();
        $newtotal = $total - $price;
        $user->setTotal($newtotal);
        $em->persist($user);
        $em->persist($course);
        $em->flush();

        return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
    }

    public function paymentAccountAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $requestpayment = $request->request->get('paymentaccount');
        if ($requestpayment == 0) {
            return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
        }
        $requestid = (int) $request->query->get('utilisateur');
        $user = $utilisateurRepository->findOneById($requestid);
        $oldtotal = $user->getTotal();
        $newtotal = $oldtotal - $requestpayment;
        $user->setTotal($newtotal);
        $em->persist($user);
        $em->flush();

        return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
    }

}
