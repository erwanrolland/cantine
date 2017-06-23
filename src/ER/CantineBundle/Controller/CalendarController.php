<?php

namespace ER\CantineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller {

    public function navAction(){
        return $this->render('ERCantineBundle::semaine.html.twig');
    }
    
}