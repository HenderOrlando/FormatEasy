<?php

namespace FormatEasy\PlantillasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Hoja controller.
 *
 * @Route("/")
 */
class IndexController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     * @Route("/Plantillas-Menu-Usuario/", name="plantillas_menu_de_usuario")
     * @Method("GET")
     * @Template("FormatEasyPlantillasBundle:Index:index.html.twig")
     */
    public function editPlantillasUsuarioAction(Request $request)
    {
//        if(!$request->isXmlHttpRequest()){
//            throw $this->createNotFoundException('The product does not exist');
//        }
        return array();
    }
}
