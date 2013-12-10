<?php

namespace FormatEasy\PlantillasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta;
use FormatEasy\PlantillasBundle\Form\PlantillaRespuestaType;

/**
 * PlantillaRespuesta controller.
 *
 * @Route("/Plantilla-Respuesta")
 */
class PlantillaRespuestaController extends Controller
{

    /**
     * Lists all PlantillaRespuesta entities in button.
     *
     * @Route("/BotonesDiseño/{formato}/", name="_plantillarespuesta_buttonlistdiseno")
     * @Method("GET")
     * @Template("FormatEasyPlantillasBundle:PlantillaRespuesta:buttonList.html.twig")
     */
    public function buttonListDisenoAction($formato)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')->getAllWithEtiquetas(array(), array('Diseño'));
        $formato = $em->getRepository('FormatEasyFormatosBundle:Formato')->findOneBy(array('canonical' => $formato));
        $etiquetas = array();
        foreach ($entities as $entity) {
            $etiquetas[$entity->getId()] = $entity->getTextEtiquetas();
        }
        return array(
            'entities' => $entities,
            'formato'  => $formato,
            'etiquetas'  => $etiquetas,
        );
    }
    /**
     * Lists all PlantillaRespuesta entities in button.
     *
     * @Route("/Botones/{formato}/", name="_plantillarespuesta_buttonlist")
     * @Method("GET")
     * @Template()
     */
    public function buttonListAction($formato)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')->findAll();
        $formato = $em->getRepository('FormatEasyFormatosBundle:Formato')->findOneBy(array('canonical' => $formato));
        $etiquetas = array();
        foreach ($entities as $entity) {
            $etiquetas[$entity->getId()] = $entity->getTextEtiquetas();
        }
        return array(
            'entities' => $entities,
            'formato'  => $formato,
            'etiquetas'  => $etiquetas,
        );
    }
    /**
     * Lists all PlantillaRespuesta entities.
     *
     * @Route("/", name="plantillaRespuesta_")
     * @Route("/", name="plantillarespuesta_")
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $title = 'Plantillas de Respuesta';
        $entity = 'PlantillaRespuesta';
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
                'url'   => $this->generateUrl('plantillarespuesta__new'),
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
                            'dato'    =>   'Widget',
                        ),
                        array(
                            'dato'    =>   'Acciones',
                            'acciones'=>    array(
                                array(
                                    'url'   => 'plantillarespuesta__edit',
                                    'data_url'=> array('id'),
                                    'type'  => 'default',
                                    'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                                ),
                                array(
                                    'url'   => 'plantillarespuesta__delete',
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
     * Creates a new PlantillaRespuesta entity.
     *
     * @Route("/", name="plantillarespuesta__create")
     * @Method("POST")
     * @Template("FormatEasyPlantillasBundle:PlantillaRespuesta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PlantillaRespuesta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('plantillarespuesta__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PlantillaRespuesta entity.
    *
    * @param PlantillaRespuesta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PlantillaRespuesta $entity)
    {
        $form = $this->createForm(new PlantillaRespuestaType(), $entity, array(
            'action' => $this->generateUrl('plantillarespuesta__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PlantillaRespuesta entity.
     *
     * @Route("/new", name="plantillarespuesta__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PlantillaRespuesta();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PlantillaRespuesta entity.
     *
     * @Route("/{id}", name="plantillarespuesta__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlantillaRespuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PlantillaRespuesta entity.
     *
     * @Route("/{id}/edit", name="plantillarespuesta__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlantillaRespuesta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a PlantillaRespuesta entity.
    *
    * @param PlantillaRespuesta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PlantillaRespuesta $entity)
    {
        $form = $this->createForm(new PlantillaRespuestaType(), $entity, array(
            'action' => $this->generateUrl('plantillarespuesta__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PlantillaRespuesta entity.
     *
     * @Route("/{id}", name="plantillarespuesta__update")
     * @Method("PUT")
     * @Template("FormatEasyPlantillasBundle:PlantillaRespuesta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlantillaRespuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('plantillarespuesta__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PlantillaRespuesta entity.
     *
     * @Route("/{id}", name="plantillarespuesta__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PlantillaRespuesta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('plantillarespuesta_'));
    }

    /**
     * Creates a form to delete a PlantillaRespuesta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plantillarespuesta__delete', array('id' => $id)))
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
