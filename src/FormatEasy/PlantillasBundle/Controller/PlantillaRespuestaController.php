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
     * @Route("/Botones/{formato}/", name="_plantillaRespuesta_buttonlist")
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
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PlantillaRespuesta entity.
     *
     * @Route("/", name="plantillaRespuesta__create")
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

            return $this->redirect($this->generateUrl('plantillaRespuesta__show', array('id' => $entity->getId())));
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
            'action' => $this->generateUrl('plantillaRespuesta__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PlantillaRespuesta entity.
     *
     * @Route("/new", name="plantillaRespuesta__new")
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
     * @Route("/{id}", name="plantillaRespuesta__show")
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
     * @Route("/{id}/edit", name="plantillaRespuesta__edit")
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
            'action' => $this->generateUrl('plantillaRespuesta__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PlantillaRespuesta entity.
     *
     * @Route("/{id}", name="plantillaRespuesta__update")
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

            return $this->redirect($this->generateUrl('plantillaRespuesta__edit', array('id' => $id)));
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
     * @Route("/{id}", name="plantillaRespuesta__delete")
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

        return $this->redirect($this->generateUrl('plantillaRespuesta_'));
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
            ->setAction($this->generateUrl('plantillaRespuesta__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
