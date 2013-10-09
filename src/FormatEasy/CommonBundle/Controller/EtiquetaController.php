<?php

namespace FormatEasy\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\CommonBundle\Entity\Etiqueta;
use FormatEasy\CommonBundle\Form\EtiquetaType;

/**
 * Etiqueta controller.
 *
 * @Route("/etiqueta_")
 */
class EtiquetaController extends Controller
{

    /**
     * Lists all Etiqueta entities.
     *
     * @Route("/", name="etiqueta_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Etiqueta entity.
     *
     * @Route("/", name="etiqueta__create")
     * @Method("POST")
     * @Template("FormatEasyCommonBundle:Etiqueta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Etiqueta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('etiqueta__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Etiqueta entity.
    *
    * @param Etiqueta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Etiqueta $entity)
    {
        $form = $this->createForm(new EtiquetaType(), $entity, array(
            'action' => $this->generateUrl('etiqueta__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Etiqueta entity.
     *
     * @Route("/new", name="etiqueta__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Etiqueta();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Etiqueta entity.
     *
     * @Route("/{id}", name="etiqueta__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Etiqueta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Etiqueta entity.
     *
     * @Route("/{id}/edit", name="etiqueta__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Etiqueta entity.');
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
    * Creates a form to edit a Etiqueta entity.
    *
    * @param Etiqueta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Etiqueta $entity)
    {
        $form = $this->createForm(new EtiquetaType(), $entity, array(
            'action' => $this->generateUrl('etiqueta__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Etiqueta entity.
     *
     * @Route("/{id}", name="etiqueta__update")
     * @Method("PUT")
     * @Template("FormatEasyCommonBundle:Etiqueta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Etiqueta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('etiqueta__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Etiqueta entity.
     *
     * @Route("/{id}", name="etiqueta__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Etiqueta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('etiqueta_'));
    }

    /**
     * Creates a form to delete a Etiqueta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etiqueta__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
