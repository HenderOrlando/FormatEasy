<?php

namespace FormatEasy\PlantillasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\PlantillasBundle\Entity\PlantillaPregunta;
use FormatEasy\PlantillasBundle\Form\PlantillaPreguntaType;

/**
 * PlantillaPregunta controller.
 *
 * @Route("/Plantilla-Pregunta")
 */
class PlantillaPreguntaController extends Controller
{

    /**
     * Lists all PlantillaPregunta entities.
     *
     * @Route("/", name="plantillapregunta_")
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $title = 'Plantillas de Pregunta';
        $entity = 'PlantillaPregunta';
        $bundle = 'Plantillas';
        $route = strtolower($entity).'_';
        $limit = 10;
        
        $paginacion = $this->get('formateasy.util')->getPaginacion($entity, $bundle, $route, $limit);
        
        $datos = array(
            'paginas' => $paginacion['pag'],
            'form_filtro' => $paginacion['form_filter']->createView(),
            'title' => $title,
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyCommonBundle:Index:_menu.html.twig', $datos);
        }
        return $datos;
    }
    
    /**
     * Creates a new PlantillaPregunta entity.
     *
     * @Route("/", name="plantillapregunta__create")
     * @Method("POST")
     * @Template("FormatEasyPlantillasBundle:PlantillaPregunta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PlantillaPregunta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('plantillapregunta__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PlantillaPregunta entity.
    *
    * @param PlantillaPregunta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PlantillaPregunta $entity)
    {
        $form = $this->createForm(new PlantillaPreguntaType(), $entity, array(
            'action' => $this->generateUrl('plantillapregunta__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PlantillaPregunta entity.
     *
     * @Route("/new", name="plantillapregunta__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PlantillaPregunta();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PlantillaPregunta entity.
     *
     * @Route("/{id}", name="plantillapregunta__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlantillaPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PlantillaPregunta entity.
     *
     * @Route("/{id}/edit", name="plantillapregunta__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlantillaPregunta entity.');
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
    * Creates a form to edit a PlantillaPregunta entity.
    *
    * @param PlantillaPregunta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PlantillaPregunta $entity)
    {
        $form = $this->createForm(new PlantillaPreguntaType(), $entity, array(
            'action' => $this->generateUrl('plantillapregunta__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PlantillaPregunta entity.
     *
     * @Route("/{id}", name="plantillapregunta__update")
     * @Method("PUT")
     * @Template("FormatEasyPlantillasBundle:PlantillaPregunta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlantillaPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('plantillapregunta__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PlantillaPregunta entity.
     *
     * @Route("/{id}", name="plantillapregunta__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaPregunta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PlantillaPregunta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('plantillapregunta_'));
    }

    /**
     * Creates a form to delete a PlantillaPregunta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plantillapregunta__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
