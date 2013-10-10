<?php

namespace FormatEasy\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class IndexController extends Controller
{
    /**
     * Index App.
     *
     * @Route("/", name="index_")
     * @Route("/{_locale}/", name="index_locale_", defaults={"_locale" = "es"})
     * @Method("GET")
     * @Template("FormatEasyCommonBundle:Index:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();
        $request->setLocale($request->getPreferredLanguage());
        
        $this->get('session')->set('_locale',$request->getLocale());
        
        return array();
    }
}
