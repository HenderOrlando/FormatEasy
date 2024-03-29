<?php

namespace FormatEasy\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\FormatosBundle\Entity\Formato;
use FormatEasy\FormatosBundle\Form\FormatoType;

/**
 * Formato controller.
 *
 * @Route("/Formato")
 */
class FormatoController extends Controller
{

    /**
     * Lists all Formato entities.
     *
     * @Route("/", name="formato_")
     * @Method("GET")
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $title = 'Formatos';
        $entity = 'Formato';
        $bundle = 'Formatos';
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
                'url'   => $this->generateUrl('formato__new'),
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
                            'dato'    =>   'Margen Sup',
                        ),
                        array(
                            'dato'    =>   'Margen Der',
                        ),
                        array(
                            'dato'    =>   'Margen Inf',
                        ),
                        array(
                            'dato'    =>   'Margen Izq',
                        ),
                        array(
                            'dato'    =>   'Plantilla Preguntas',
                        ),
                        array(
                            'dato'    =>   'Plantilla Formato',
                        ),
                        array(
                            'dato'    =>   'Acciones',
                            'acciones'=>    array(
                                array(
                                    'url'   => 'formato__edit',
                                    'data_url'=> array('id'),
                                    'type'  => 'default',
                                    'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                                ),
                                array(
                                    'url'   => 'formato__delete',
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
     * Creates a new Formato entity.
     *
     * @Route("/", name="formato__create")
     * @Method("POST")
     * @Template("FormatEasyFormatosBundle:Formato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Formato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $pf = $em->getRepository('FormatEasyPlantillasBundle:PlantillaFormato')->findFirst();
        $pp = $em->getRepository('FormatEasyPlantillasBundle:PlantillaPregunta')->findFirst();

        $datos = array(
            'plantillaFormato' => $pf,
            'plantillaPregunta' => $pp,
            'entity' => $entity,
            'form'   => $form->createView(),
        );

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $datos['plantillaFormato'] = $entity->getPlantillaFormato();
            $datos['plantillaPregunta'] = $entity->getPlantillaPreguntas();
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyFormatosBundle:Formato:_show.html.twig', $datos);
            }
            return $this->redirect($this->generateUrl('formato__show', array('id' => $entity->getId())));
        }
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Formato:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
    * Creates a form to create a Formato entity.
    *
    * @param Formato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Formato $entity)
    {
        $form = $this->createForm(new FormatoType(), $entity, array(
            'action' => $this->generateUrl('formato__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/new", name="formato__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Formato();
        $em = $this->getDoctrine()->getManager();
        $pf = $em->getRepository('FormatEasyPlantillasBundle:PlantillaFormato')->findFirst();
        $pp = $em->getRepository('FormatEasyPlantillasBundle:PlantillaPregunta')->findFirst();
        $entity->setPlantillaFormato($pf)
               ->setPlantillaPreguntas($pp);
        $form = $this->createCreateForm($entity);
        
        $datos = array(
            'plantillaFormato' => $pf,
            'plantillaPregunta' => $pp,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Formato:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
     * Finds and displays a Formato entity.
     *
     * @Route("/{id}", name="formato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Formato:_show.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
     * Displays a form to edit an existing Formato entity.
     *
     * @Route("/Diseñar/{id}/", name="formato_disenarFormato")
     * @Method("GET")
     * @Template("FormatEasyFormatosBundle:Formato:edit_design.html.twig")
     */
    public function disenaFormatoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $preguntas = $em->getRepository('FormatEasyFormatosBundle:Formato')->getPreguntasGroupByGrupos($entity); 
//        echo '<pre>';
//        var_dump($preguntas);
//        echo '</pre>';
//        die;
        $datos = array(
            'entity'            => $entity,
            'p'                 => $preguntas,
            'plantillaFormato'  => $entity->getPlantillaFormato(),
            'edit_form'         => $editForm->createView(),
            'delete_form'       => $deleteForm->createView(),
            'preguntas'         => $entity->getPreguntas()
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Formato:_edit_design.html.twig', $datos);
        }
        
        return $datos;
    }
    /**
     * Displays a form to edit an existing Formato entity.
     *
     * @Route("/{id}/edit", name="formato__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'            => $entity,
            'plantillaFormato'  => $entity->getPlantillaFormato(),
            'edit_form'         => $editForm->createView(),
            'delete_form'       => $deleteForm->createView(),
            'preguntas'         => $entity->getPreguntas()
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Formato:_edit.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
    * Creates a form to edit a Formato entity.
    *
    * @param Formato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Formato $entity)
    {
        $form = $this->createForm(new FormatoType(), $entity, array(
            'action' => $this->generateUrl('formato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Formato entity.
     *
     * @Route("/{id}", name="formato__update")
     * @Method("PUT")
     * @Template("FormatEasyFormatosBundle:Formato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $datos = array('id' => $id);
            
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyFormatosBundle:Formato:_edit.html.twig', $datos);
            }

            return $this->redirect($this->generateUrl('formato__edit', $datos));
        }
        
        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Formato:_edit.html.twig', $datos);
        }

        return $datos;
    }
    /**
     * Deletes a Formato entity.
     *
     * @Route("/{id}", name="formato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyFormatosBundle:Formato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Formato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formato__delete', array('id' => $id)))
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
}
