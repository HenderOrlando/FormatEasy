<?php

namespace FormatEasy\FosUsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FormatEasyFosUsuariosBundle:Default:index.html.twig', array('name' => $name));
    }
}
