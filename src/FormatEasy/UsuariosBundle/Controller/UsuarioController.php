<?php

namespace FormatEasy\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FormatEasy\CommonBundle\Controller\IndexController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\UsuariosBundle\Entity\Usuario;
use FormatEasy\UsuariosBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 * @Route("/Usuario")
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     * @Route("/Editar-Cuenta/", name="usuario_edit_datos_de_usuario")
     * @Method("GET")
     * @Template("FormatEasyUsuariosBundle:Usuario:editCuenta.html.twig")
     */
    public function editCuentaUsuarioAction(Request $request)
    {
//        if(!$request->isXmlHttpRequest() || !$this->getUser()){
//            throw $this->createNotFoundException('The product does not exist');
//        }
        if(is_null($this->getUser()->getUsuario())){
            return array('new' => true);
        }
        if($request->isXmlHttpRequest())
            return $this->render ('FormatEasyUsuariosBundle:Usuario:editCuenta.html.twig', array('new' => false));
        return array('new' => false);
    }

    /**
     * Lists all Usuario entities.
     *
     * @Route("/Asignar-Formato/", name="usuario_menu_de_usuario")
     * @Template()
     */
    public function menuUsuarioAction(Request $request)
    {
        $title = 'Usuarios';
        $entity = 'Usuario';
        $bundle = 'Usuarios';
        $route = strtolower($entity).'_';
        $limit = 10;
        $feu = $this->getFormatEasyUtils();
        
        $form = $feu->getFormFilter(array(), $route);
        
        $data = array();
        if ($form->isValid()) {
           $data = $form->getData();
        }
        
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('a')
           ->from('FormatEasy'.$bundle.'Bundle:'.$entity, 'a');
        if (array_key_exists("filtro", $data)){
            $data['filtro'] = trim($data['filtro']);
            if (strlen($data['filtro'])>0){
                   $qb
                      ->orWhere($qb->expr()->like("a.nombre", "?1"))
                      ->orWhere($qb->expr()->like("a.docId", "?1"))
                      ->setParameter(1,"%".$data['filtro']."%");      
            }
        }
        $qb = $qb->getQuery();
        $paginacion = $feu->getPaginacion($entity, $bundle, $limit, $route, $qb);
        $paginacion['form_filter'] = $form;
        $botones = array(
            array(
                'url'   => $this->generateUrl('usuario__new'),
                'type'  => 'primary',
                'label' => '<span class="glyphicon glyphicon-plus" ></span> Agregar',
                'class' => 'link-modal',
            ),
        );
        $head = array(
            'fil'=>array(
                array(
                    'col'=>array(
                        array(
                            'dato'    =>   'Nombre',
                        ),
                        array(
                            'dato'    =>   'Doc Id',
                        ),
                    )
                ),
            )
        );
        $datos_usuarios = array(
            'paginas'       =>  $paginacion['pag'],
            'form_filtro'   =>  $paginacion['form_filter']->createView(),
            'title'         =>  $title,
            'head'          =>  $head,
            'botones'       =>  $botones,
        );
        
        $datos = array(
            'usuarios'  => $datos_usuarios,
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false)){
            return $this->render("FormatEasyUsuariosBundle:Usuario:_menuUsuario.html.twig", $datos);
        }
        return $datos;
    }
    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario_")
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $title = 'Usuarios';
        $entity = 'Usuario';
        $bundle = 'Usuarios';
        $route = strtolower($entity).'_';
        $limit = 10;
        $feu = $this->getFormatEasyUtils();
        
//        $form = $feu->getFormFilter(array(), $route);
//        
//        $data = array();
//        if ($form->isValid()) {
//           $data = $form->getData();
//        }
//        
        $qb = null;
//        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
//        $qb->select('a')
//           ->from('FormatEasy'.$bundle.'Bundle:'.$entity, 'a');
//        if (array_key_exists("filtro", $data)){
//            $data['filtro'] = trim($data['filtro']);
//            if (strlen($data['filtro'])>0){
//                   $qb
//                      ->orWhere($qb->expr()->like("a.widget", "?1"))
//                      ->orWhere($qb->expr()->like("a.fechaCreado", "?1"))
//                      ->setParameter(1,"%".$data['filtro']."%");      
//            }
//        }
//        $qb = $qb->getQuery();
        $paginacion = $feu->getPaginacion($entity, $bundle, $limit, $route, $qb);
//        $paginacion['form_filter'] = $form;
        $botones = array(
            array(
                'url'   => $this->generateUrl('usuario__new'),
                'type'  => 'primary',
                'label' => '<span class="glyphicon glyphicon-plus" ></span> Agregar',
            ),
        );
        $head = array(
            'fil'=>array(
                array(
                    'col'=>array(
                        array(
                            'dato'    =>   'Nombre',
                        ),
                        array(
                            'dato'    =>   'Descripcion',
                        ),
                        array(
                            'dato'    =>   'Doc Id',
                        ),
                        array(
                            'dato'    =>   'Tipo Doc Id',
                        ),
                        array(
                            'dato'    =>   'Acciones',
                            'acciones'=>    array(
                                array(
                                    'url'   => 'usuario__edit',
                                    'data_url'=> array('id'),
                                    'type'  => 'default',
                                    'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                                ),
                                array(
                                    'url'   => 'usuario__delete',
                                    'data_url'=> array('id'),
                                    'type'  => 'danger',
                                    'label' => '<span class="glyphicon glyphicon-trash" ></span> Borrar',
                                ),
                            )
                        ),
                    )
                ),
            )
        );
        $datos = array(
            'paginas'       =>  $paginacion['pag'],
            'form_filtro'   =>  $paginacion['form_filter']->createView(),
            'title'         =>  $title,
            'head'          =>  $head,
            'botones'       =>  $botones,
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false)){
            return $this->render('FormatEasyCommonBundle:Index:_menu.html.twig', $datos);
        }
        return $datos;
    }
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/Crear/{id}", name="usuario__create_")
     * @Route("/Crear/", name="usuario__create")
     * @Template("FormatEasyUsuariosBundle:Usuario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $data = array('id' => $request->get('id', -1));
        $form = $this->createCreateForm($entity, $data);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            if($request->get('id', -1) == $this->getUser()->getId()){
                $this->getUser()->setUsuario($entity);
                $em->persist($this->getUser());
                $em->flush();
            }else{
                
            }

            return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Usuario $entity, $datos = array())
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario__create', $datos),
            'method' => 'POST',
        ));
        

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="usuario__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Usuario();
        $data = array('id' => $request->get('id', -1));
        $form   = $this->createCreateForm($entity, $data);
        
        $datos = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false)){
            return $this->render("FormatEasyUsuariosBundle:Usuario:_new.html.twig", $datos);
        }
        return $datos;
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="usuario__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyUsuariosBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuario__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyUsuariosBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        if($request->isXmlHttpRequest()){
            $c = $this->render(
                'FormatEasyUsuariosBundle:Usuario:_edit.html.twig',
                array(
                    'entity'      => $entity,
                    'edit_form'   => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                )
            );
            return new \Symfony\Component\HttpFoundation\Response($c);
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/Actualiza/{id}", name="usuario__update")
     * @Template("FormatEasyUsuariosBundle:Usuario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyUsuariosBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('usuario__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}", name="usuario__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyUsuariosBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuario_'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    /**
     * @return \FormatEasy\CommonBundle\Controller\IndexController Utilidades de FormatEasy
     */
    public function getFormatEasyUtils() {
        return $this->get('formateasy.util');
    }
    /**
     * get Pagination
     * 
     * @param \FormatEasy\CommonBundle\Controller\IndexController $feu Clase de Utilidades
     * @param String    $route     Ruta
     * @param String    $bundle    Nombre del Bundle
     * @param String    $entity    Nombre del Entity
     * @param String    $limit     Limite
     * @param Array     $campos    Arreglo de campos con la siguiente estructura:
     *                              array(
     *                                  array('nombre'  => 'Nombre del Campo.',
     *                                      'operacion' => 'Operación del Filtro.',
     *                                      'valor'     => array(
     *                                              'campo'     =>  'Nombre de campo.',
     *                                              'tipo'      =>  'Tipo de campo. text, email, integer, money, number, date, datetime, time, checkbox, radio',
     *                                              'options'   =>  'Opciones del tipo de campo'
     *                                      )
     *                                  )
     *                              )
     * 
     * @return array Arreglo con el paginator y el formulario
     */
    private function getPagination(IndexController $feu, $route, $bundle, $entity, $limit, $campos = null, $campos_en_form = false) {
        $form = $feu->getFormFilter(array(), $route, $campos_en_form);
        if($campos_en_form && is_array($campos) && !empty($campos)){
            foreach($campos as $campo){
                $valor = $campo['valor'];
                $options = $valor['options'];
                $options['required'] = false;
                $form->add($valor['campo'], $valor['tipo'], $options);
            }
        }
        $data = array();
        if ($form->isValid()) {
           $data = $form->getData();
        }
        
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('a')
           ->from('FormatEasy'.$bundle.'Bundle:'.$entity, 'a');
        if (array_key_exists("filtro", $data)){
            $data['filtro'] = trim($data['filtro']);
            if (strlen($data['filtro'])>0){
                if(!is_null($campos) && !empty($campos) && is_array($campos)){
                    foreach($campos as $campo){
                        if($campos_en_form && isset($data[$campo['valor']['campo']]) && is_string($data[$campo['valor']['campo']])){
                            $campo_ = $data[$campo['valor']['campo']];
                        }else{
                            $campo_ = $data['filtro'];
                        }
                        if(strtolower($campo['operacion']) == 'like')
                            $campo_ = "'%".$campo_."%'";
                        $qb->orWhere("a.".$campo['nombre'].' '.$campo['operacion'].' '.$campo_);
                    }
                    
                }
                else
                   $qb
                      ->orWhere($qb->expr()->like("a.nombre", "?1"))
                      ->orWhere($qb->expr()->like("a.descripcion", "?1"))
                      ->setParameter(1,"%".$data['filtro']."%");
            }
        }
        $paginacion = $feu->getPaginacion($entity, $bundle, $limit, $route, $qb->getQuery());
        $paginacion['form_filter'] = $form;
        return $paginacion;
    }
}
