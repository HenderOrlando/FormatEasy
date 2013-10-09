<?php

namespace FormatEasy\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato;
use FormatEasy\FormatosBundle\Form\UsuarioRespuestaPreguntaFormatoType;

/**
 * UsuarioRespuestaPreguntaFormato controller.
 *
 * @Route("/usuarioRespuestaPreguntaFormato_")
 */
class UsuarioRespuestaPreguntaFormatoController extends Controller
{

    /**
     * Lists all UsuarioRespuestaPreguntaFormato entities.
     *
     * @Route("/", name="usuarioRespuestaPreguntaFormato_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new UsuarioRespuestaPreguntaFormato entity.
     *
     * @Route("/", name="usuarioRespuestaPreguntaFormato__create")
     * @Method("POST")
     * @Template("FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new UsuarioRespuestaPreguntaFormato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuarioRespuestaPreguntaFormato__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a UsuarioRespuestaPreguntaFormato entity.
    *
    * @param UsuarioRespuestaPreguntaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(UsuarioRespuestaPreguntaFormato $entity)
    {
        $form = $this->createForm(new UsuarioRespuestaPreguntaFormatoType(), $entity, array(
            'action' => $this->generateUrl('usuarioRespuestaPreguntaFormato__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UsuarioRespuestaPreguntaFormato entity.
     *
     * @Route("/new", name="usuarioRespuestaPreguntaFormato__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UsuarioRespuestaPreguntaFormato();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a UsuarioRespuestaPreguntaFormato entity.
     *
     * @Route("/{id}", name="usuarioRespuestaPreguntaFormato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioRespuestaPreguntaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UsuarioRespuestaPreguntaFormato entity.
     *
     * @Route("/{id}/edit", name="usuarioRespuestaPreguntaFormato__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioRespuestaPreguntaFormato entity.');
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
    * Creates a form to edit a UsuarioRespuestaPreguntaFormato entity.
    *
    * @param UsuarioRespuestaPreguntaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UsuarioRespuestaPreguntaFormato $entity)
    {
        $form = $this->createForm(new UsuarioRespuestaPreguntaFormatoType(), $entity, array(
            'action' => $this->generateUrl('usuarioRespuestaPreguntaFormato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing UsuarioRespuestaPreguntaFormato entity.
     *
     * @Route("/{id}", name="usuarioRespuestaPreguntaFormato__update")
     * @Method("PUT")
     * @Template("FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioRespuestaPreguntaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('usuarioRespuestaPreguntaFormato__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a UsuarioRespuestaPreguntaFormato entity.
     *
     * @Route("/{id}", name="usuarioRespuestaPreguntaFormato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UsuarioRespuestaPreguntaFormato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuarioRespuestaPreguntaFormato_'));
    }

    /**
     * Creates a form to delete a UsuarioRespuestaPreguntaFormato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuarioRespuestaPreguntaFormato__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
