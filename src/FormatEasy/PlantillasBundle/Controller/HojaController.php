<?php

namespace FormatEasy\PlantillasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\PlantillasBundle\Entity\Hoja;
use FormatEasy\PlantillasBundle\Form\HojaType;

/**
 * Hoja controller.
 *
 * @Route("/Hoja")
 */
class HojaController extends Controller
{

    /**
     * Lists all Hoja entities.
     *
     * @Route("/", name="hoja_")
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $title = 'Hojas';
        $entity = 'Hoja';
        $bundle = 'Plantillas';
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
                'url'   => $this->generateUrl('plantillapregunta__new'),
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
                            'dato'    =>   'Orientacion',
                        ),
                        array(
                            'dato'    =>   'Ancho',
                        ),
                        array(
                            'dato'    =>   'Alto',
                        ),
                        array(
                            'dato'    =>   'Botones',
                            'acciones'=>    array(
                                array(
                                    'url'   => 'respuesta__edit',
                                    'data_url'=> array('id'),
                                    'type'  => 'default',
                                    'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                                ),
                                array(
                                    'url'   => 'respuesta__delete',
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
     * Creates a new Hoja entity.
     *
     * @Route("/", name="hoja__create")
     * @Method("POST")
     * @Template("FormatEasyPlantillasBundle:Hoja:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Hoja();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        $datos = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyPlantillasBundle:Hoja:_show.html.twig', $datos);
            }
            return $this->redirect($this->generateUrl('hoja__show', array('id' => $entity->getId())));
        }
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:Hoja:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
    * Creates a form to create a Hoja entity.
    *
    * @param Hoja $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Hoja $entity)
    {
        $form = $this->createForm(new HojaType(), $entity, array(
            'action' => $this->generateUrl('hoja__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Hoja entity.
     *
     * @Route("/new", name="hoja__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Hoja();
        $form   = $this->createCreateForm($entity);
        
        $datos = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:Hoja:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
     * Finds and displays a Hoja entity.
     *
     * @Route("/{id}", name="hoja__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:Hoja')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hoja entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:Hoja:_show.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
     * Displays a form to edit an existing Hoja entity.
     *
     * @Route("/{id}/edit", name="hoja__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:Hoja')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hoja entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:Hoja:_show.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
    * Creates a form to edit a Hoja entity.
    *
    * @param Hoja $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Hoja $entity)
    {
        $form = $this->createForm(new HojaType(), $entity, array(
            'action' => $this->generateUrl('hoja__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Hoja entity.
     *
     * @Route("/{id}", name="hoja__update")
     * @Method("PUT")
     * @Template("FormatEasyPlantillasBundle:Hoja:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:Hoja')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hoja entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            
            $datos = array('id' => $id);
            
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyPlantillasBundle:Hoja:_edit.html.twig', $datos);
            }

            return $this->redirect($this->generateUrl('hoja__edit', $datos));
        }
        
        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:Hoja:_edit.html.twig', $datos);
        }

        return $datos;
    }
    /**
     * Deletes a Hoja entity.
     *
     * @Route("/{id}", name="hoja__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyPlantillasBundle:Hoja')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Hoja entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Hoja entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hoja__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    /**
     * 
     * @return \FormatEasy\CommonBundle\Controller\IndexController
     */
    public function getFormatEasyUtils() {
        return $this->get('formatEasy.util');
    }
}
