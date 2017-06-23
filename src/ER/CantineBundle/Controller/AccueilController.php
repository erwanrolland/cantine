<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ER\CantineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Description of AccueilController
 *
 * @author erwan
 */
class AccueilController extends Controller {

    public function navAction() {
        return $this->render('ERCantineBundle::accueil.html.twig');
    }

}
