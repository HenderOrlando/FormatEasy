<?php

namespace FormatEasy\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FormatEasy\FormatosBundle\Entity\Respuesta;
use FormatEasy\FormatosBundle\Entity\Pregunta;
use FormatEasy\FormatosBundle\Form\RespuestaType;

/**
 * Respuesta controller.
 *
 * @Route("/Respuesta")
 */
class RespuestaController extends Controller
{

    /**
     * Lists all Respuesta entities.
     *
     * @Route("/", name="respuesta_")
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $title = 'Respuestas';
        $entity = 'Respuesta';
        $bundle = 'Formatos';
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
     * Lists all Respuesta de una pregunta.
     *
     * @Route("/Lista/{pregunta}/{etiqueta}/", name="respuestas_pregunta", defaults={"etiqueta"="Opciones"})
     * @Template()
     */
    public function respuestasPreguntaAction($pregunta, $etiqueta)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Pregunta')->findOneByCanonical($pregunta);
        //$etiqueta = $em->getRepository('FormatEasyFormatosBundle:Etiqueta')->findOneByCanonical($etiqueta);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pregunta entity.'.$pregunta);
        }

        $datos = array(
            'respuestas'      => $entity->getRespuestas($etiqueta),
            'etiqueta'      => $etiqueta
        );
        
        return $this->render('FormatEasyFormatosBundle:Respuesta:_listaRespuestasPregunta.html.twig', $datos);
    }
    /**
     * Creates a new Respuesta entity.
     *
     * @Route("/", name="respuesta__create")
     * @Method("POST")
     * @Template("FormatEasyFormatosBundle:Respuesta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Respuesta();
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
                return $this->render('FormatEasyFormatosBundle:Respuesta:_show.html.twig', $datos);
            }
            return $this->redirect($this->generateUrl('respuesta__show', array('id' => $entity->getId())));
        }
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Respuesta:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
    * Creates a form to create a Respuesta entity.
    *
    * @param Respuesta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Respuesta $entity)
    {
        $form = $this->createForm(new RespuestaType(), $entity, array(
            'action' => $this->generateUrl('respuesta__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Respuesta entity.
     *
     * @Route("/new", name="respuesta__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Respuesta();
        $form   = $this->createCreateForm($entity);

        $datos = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Respuesta:_new.html.twig', $datos);
        }

        return $datos;
    }
    /**
     * Displays a form to create a new Respuesta entity.
     *
     * @Route("/Agregar-Respuesta/{pregunta}", name="respuesta__addRespuesta")
     * @ParamConverter("pregunta", class="FormatEasyFormatosBundle:Pregunta", options={"canonical" = "pregunta", "repository_method" = "findOneByCanonical"})
     * @Template()
     */
    public function addRespuestaAction(Pregunta $pregunta, Request $request)
    {
        $entity = new Respuesta();
        $entity->setPregunta($pregunta);
        $form   = $this->createCreateForm($entity);

        $datos = array(
            'pregunta'  => $pregunta,
            'entity'    => $entity,
            'form'      => $form->createView(),
        );
        if($request->getMethod() == 'POST'){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            }
            $deleteForm = $this->createDeleteForm($entity->getId());
            $editForm = $this->createEditForm($entity);
            $datos = array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'new' => true,
            );

            return $this->render('FormatEasyFormatosBundle:Respuesta:_editRespuesta.html.twig', $datos);
        }
        
        return $this->render('FormatEasyFormatosBundle:Respuesta:_addRespuesta.html.twig', $datos);
    }

    /**
     * Finds and displays a Respuesta entity.
     *
     * @Route("/{id}", name="respuesta__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Respuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Respuesta:_show.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
     * Displays a form to edit an existing Respuesta entity.
     *
     * @Route("/{id}/edit", name="respuesta__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Respuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuesta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Respuesta:_edit.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
     * Displays a form to edit an existing Respuesta entity.
     *
     * @Route("/Actualizar/{id}", name="respuesta__editar")
     * @Template()
     */
    public function editRespuestaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Respuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuesta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        return $this->render('FormatEasyFormatosBundle:Respuesta:_editRespuesta.html.twig', $datos);
    }

    /**
    * Creates a form to edit a Respuesta entity.
    *
    * @param Respuesta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Respuesta $entity)
    {
        $form = $this->createForm(new RespuestaType(), $entity, array(
            'action' => $this->generateUrl('respuesta__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Respuesta entity.
     *
     * @Route("/{id}", name="respuesta__update")
     * @Method("PUT")
     * @Template("FormatEasyFormatosBundle:Respuesta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Respuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $datos = array('id' => $id);
            
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyFormatosBundle:Respuesta:_edit.html.twig', $datos);
            }

            return $this->redirect($this->generateUrl('respuesta__edit', $datos));
        }
        
        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Respuesta:_edit.html.twig', $datos);
        }

        return $datos;
    }
    /**
     * Deletes a Respuesta entity.
     *
     * @Route("/{id}", name="respuesta__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyFormatosBundle:Respuesta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Respuesta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Respuesta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('respuesta__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
