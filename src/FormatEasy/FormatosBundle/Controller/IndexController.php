<?php

namespace FormatEasy\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class IndexController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     * @Route("/Formatos-Menu-Usuario/", name="formatos_menu_de_usuario")
     * @Method("GET")
     * @Template("FormatEasyFormatosBundle:Index:index.html.twig")
     */
    public function editPlantillasUsuarioAction(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createNotFoundException('The product does not exist');
        }
        return array();
    }
}
