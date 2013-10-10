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
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyPlantillasBundle:Hoja')->findAll();

        $datos = array(
            'entities' => $entities,
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyPlantillasBundle:Hoja:_index.html.twig', $datos);
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
}
