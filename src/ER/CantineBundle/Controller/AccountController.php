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
        $somme = $course->findSomme();
        $repas = $em->getRepository('ERCantineBundle:Repas');
        $count = $repas->findNbRepas();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $utilisateurs = $utilisateurRepository->findAll();
        $maj = $em->getRepository('ERCantineBundle:Miseajour');
        $lastarray = $maj->findLastUpdate();
        $lastId = $lastarray[0][1];
        $lastupd = $maj->findOneById($lastId);
        $lastupdate = $lastupd->getDatemaj()->format('Y-m-d');
        $arrayparameters = [
            'count' => $count,
            'somme' => $somme,
            'utilisateur' => $utilisateurs,
            'lastupdate' => $lastupdate
        ];
        return $arrayparameters;
    }

    public function navAction() {
        return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
    }

    public function updateAccountAction() {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('ERCantineBundle:Course');
        $somme = $course->findSomme();
        $repas = $em->getRepository('ERCantineBundle:Repas');
        $count = $repas->findNbRepas();
        $prixrepas = $somme / $count;

        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');

        $users = $utilisateurRepository->findAll();

//        foreach ($users as $user) {
//            $nbrepas = $utilisateurRepository->findNbRepasByUser();
//            $add = $prixrepas * $nbrepas;
//
//            $oldtotal = $user->getTotal();
//            $newtotal = $oldtotal + $add;
//            $user->setTotal($newtotal);
//            $em->persist($user);
//            $em->flush();
//        }


        $datemaj = new \DateTime();
        $miseajour = new Miseajour();
        $miseajour->setDatemaj($datemaj);
        $em->persist($miseajour);
        $em->flush();

        return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
    }

    public function addCourseAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('ERCantineBundle:Utilisateur');
        $requestid = (int) $request->query->get('utilisateur');
        $user = $utilisateurRepository->findOneById($requestid);

        $price = $request->request->get('addcourse');

        $datecourse = new \DateTime();
        $course = new Course();
        $course->setUtilisateur($user);
        $course->setPrix($price);
        $course->setDatecourse($datecourse);
        $em->persist($course);
        $em->flush();

        return $this->render('ERCantineBundle::comptes.html.twig', $this->parametersToArray());
    }

}
