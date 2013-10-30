<?php

namespace FormatEasy\CommonBundle\Controller;

use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;

class IndexController extends Controller implements PaginatorAwareInterface
{
    protected $em_, $request_, $formFactory_, $paginator_, $router_;
    public function __construct($em = null, $formFactory = null, $router = null, $request = null, $paginator = null) {
//        if(!is_null($em))
            $this->em_ = $em;
//        if(!is_null($request))
            $this->request_ = $request;
//        if(!is_null($formFactory))
            $this->formFactory_ = $formFactory;
//        if(!is_null($paginator))
            $this->paginator_ = $paginator;
//        if(!is_null($router))
            $this->router_ = $router;
    }
    public function setRequest(Request $request = null)
    {
        $this->request_ = $request;
        return $this;
    }
    public function getRequest_()
    {
        return $this->request_;
    }
    public function setEntityManager(EntityManager $em = null)
    {
        $this->em_ = $em;
        return $this;
    }
    public function getEntityManager_()
    {
        return $this->em_;
    }
    public function setPaginator(\Knp\Component\Pager\Paginator $paginator) {
        $this->paginator_ = $paginator;
        return $this;
    }
    public function getPaginator_()
    {
        return $this->paginator_;
    }
    public function setRouter(Router $paginator) {
        $this->paginator_ = $paginator;
        return $this;
    }
    public function getRouter_()
    {
        return $this->paginator_;
    }
    public function setFormFactory(FormFactory $em = null)
    {
        $this->em_ = $em;
        return $this;
    }
    public function getFormFactory_()
    {
        return $this->em_;
    }
    /**
     * Generates a URL from the given parameters.
     *
     * @param string         $route         The name of the route
     * @param mixed          $parameters    An array of parameters
     * @param Boolean|string $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    public function generateUrl_($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->router_->generate($route, $parameters, $referenceType);
    }
    /**
     * Creates and returns a form builder instance
     *
     * @param mixed $data    The initial data for the form
     * @param array $options Options for the form
     *
     * @return FormBuilder
     */
    public function createFormBuilder_($data = null, array $options = array())
    {
        return $this->formFactory_->createBuilder('form', $data, $options);
    }
    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string|FormTypeInterface $type    The built type of the form
     * @param mixed                    $data    The initial data for the form
     * @param array                    $options Options for the form
     *
     * @return Form
     */
    public function createForm_($type = 'form', $data = null, array $options = array())
    {
        return $this->formFactory_->create($type, $data, $options);
    }
    
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
        
        $this->get('session')->set('_locale',$locale);
        
        return array();
    }
    
    /**
     * get paginacion
     * 
     * Crea la paginación y un formulario de búsqueda.
     *
     * @param   String      $entity     Nombre de la Entidad a manejar
     * @param   String      $bundle     Nombre del bundle donde está la entity
     * @param   String      $route      Ruta para el formulario de búsqueda
     * @param   Integer     $limit      Máximo de items por página
     * @param   Doctrine    $em         Entity Manager
     * @param   Request     $request    Entity Manager
     *
     * @return  array   Arreglo con 2 variables, la paginación "pag", y el formulario "form_filter"
     */
    public function getPaginacion($entity, $bundle, $route, $limit, $em = null, $request = null){
        if(is_null($em))
            $em = $this->em_;
        if(is_null($request))
            $request = $this->request_;
        $data = array();
        $defaultData = array();
        if(!is_null($this->router_))
            $r = $this->generateUrl_($route);
        else
            $r = $this->generateUrl($route);
        if(!is_null($this->formFactory_))
            $form = $this->createFormBuilder_(
                $defaultData,
                array('attr' => array('id' => 'fitro', 'role' => 'form', 'class' => 'form-inline form-buscar'))
                );
        else
        $form = $this->createFormBuilder(//createFormBuilder
                $defaultData,
                array('attr' => array('id' => 'fitro', 'role' => 'form', 'class' => 'form-inline form-buscar'))
                );
        $form = $form
            ->setAction($r)
            ->setMethod('POST')
            ->add('filtro', 'text', 
                    array(
                        'required' => false, 
                        'label' =>false,
                        'attr' => array('class' => 'form-control input-lg'),
                    )
                )
            ->add('Buscar', 'submit',
                    array(
                        'attr' => array('class' => 'btn btn-success btn-lg input-group-addon')
                    )
                )
            ->getForm();
         $form->handleRequest($request);

         if ($form->isValid()) {
            $data = $form->getData();
         }
         $qb = $em->createQueryBuilder();
         $qb->select('a');
         $qb->from('FormatEasy'.$bundle.'Bundle:'.$entity, 'a');

         if (array_key_exists("filtro", $data))
         {
             $data['filtro'] = trim($data['filtro']);
             if (strlen($data['filtro'])>0)
             {
                 $qb
                    ->orWhere($qb->expr()->like("a.nombre", "?1"))
                    ->orWhere($qb->expr()->like("a.canonical", "?1"))
                    ->orWhere($qb->expr()->like("a.descripcion", "?1"))
                    ->setParameter(1,"%".$data['filtro']."%");
             }
         }

         $q = $qb->getQuery();
         
        if(!is_null($this->paginator_))
            $paginator  = $this->paginator_;
        else
            $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $q,
            $request->query->get('pagina', 1),
            $limit
        );
        $pagination->setUsedRoute($route);
        return array(
            'pag'           => $pagination,
            'form_filter'   => $form
        );
    }
}
