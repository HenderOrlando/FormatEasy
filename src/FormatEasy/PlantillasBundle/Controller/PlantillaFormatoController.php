<?php

namespace FormatEasy\PlantillasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FormatEasy\PlantillasBundle\Entity\PlantillaFormato;
use FormatEasy\PlantillasBundle\Form\PlantillaFormatoType;

/**
 * Plantilla controller.
 *
 * @Route("/Plantilla-Formato")
 */
class PlantillaFormatoController extends Controller
{

    /**
     * Lists all Plantilla entities.
     *
     * @Route("/", name="plantilla_")
     * @Method("GET")
     * @Template("FormatEasyPlantillasBundle:PlantillaFormato:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyPlantillasBundle:PlantillaFormato')->findAll();

        $datos = array(
            'entities' => $entities,
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_index.html.twig', $datos);
        }
        
        return $datos;
    }
    /**
     * Creates a new PlantillaFormato entity.
     *
     * @Route("/", name="plantilla__create")
     * @Method("POST")
     * @Template("FormatEasyPlantillasBundle:PlantillaFormato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PlantillaFormato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $datos = array('id' => $entity->getId());
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_show.html.twig', $datos);
            }
            return $this->redirect($this->generateUrl('plantilla__show', $datos));
        }
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
    * Creates a form to create a Plantilla Formato entity.
    *
    * @param PlantillaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PlantillaFormato $entity)
    {
        $form = $this->createForm(new PlantillaFormatoType(), $entity, array(
            'action' => $this->generateUrl('plantilla__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Plantilla Formato entity.
     *
     * @Route("/new", name="plantilla__new")
     * @Method("GET")
     * @Template("FormatEasyPlantillasBundle:PlantillaFormato:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $entity = new PlantillaFormato();
        $form   = $this->createCreateForm($entity);

        $datos = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
     * Finds and displays a Plantilla Formato entity.
     *
     * @Route("/{id}", name="plantilla__show")
     * @Method("GET")
     * @Template("FormatEasyPlantillasBundle:PlantillaFormato:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plantilla Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_show.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
     * Displays a form to edit an existing Plantilla Formato entity.
     *
     * @Route("/{id}/edit", name="plantilla__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plantilla Formato entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_edit.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
    * Creates a form to edit a Plantilla Formato entity.
    *
    * @param PlantillaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PlantillaFormato $entity)
    {
        $form = $this->createForm(new PlantillaFormatoType(), $entity, array(
            'action' => $this->generateUrl('plantilla__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Plantilla Formato entity.
     *
     * @Route("/{id}", name="plantilla__update")
     * @Method("PUT")
     * @Template("FormatEasyPlantillasBundle:PlantillaFormato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plantilla Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $datos = array('id' => $id);
            
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_edit.html.twig', $datos);
            }

            return $this->redirect($this->generateUrl('plantilla__edit', $datos));
        }
        
        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:PlantillaFormato:_edit.html.twig', $datos);
        }

        return $datos;
    }
    /**
     * Deletes a Plantilla Formato entity.
     *
     * @Route("/{id}", name="plantilla__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyPlantillasBundle:PlantillaFormato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Plantilla Formato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Plantilla Formato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plantilla__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
