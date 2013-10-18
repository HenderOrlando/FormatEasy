<?php

namespace FormatEasy\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FormatEasy\FormatosBundle\Entity\Pregunta;
use FormatEasy\FormatosBundle\Form\PreguntaType;
use FormatEasy\FormatosBundle\Entity\Formato;
use FormatEasy\FormatosBundle\Form\FormatoType;

/**
 * Pregunta controller.
 *
 * @Route("/Pregunta")
 */
class PreguntaController extends Controller
{

    /**
     * Form para responder la Pregunta.
     *
     * @Route("/Responder/{pregunta}/en/{formato}/", name="pregunta__responderPregunta")
     * @Route("/Responder/{pregunta}/en/{formato}/{disabled}-Deshabilitado/", name="pregunta__responderPregunta_deshabilitado", defaults={"disabled" = "Si"})
     * @ParamConverter("pregunta", class="FormatEasyFormatosBundle:Pregunta", options={"canonical" = "pregunta", "repository_method" = "findOneByCanonical"})
     * @ParamConverter("formato", class="FormatEasyFormatosBundle:Formato", options={"canonical" = "formato", "repository_method" = "findOneByCanonical"})
     * @Template("FormatEasyFormatosBundle:Pregunta:_formResponderPregunta.html.twig")
     */
    public function formResponderPreguntaAction(Pregunta $pregunta, Formato $formato){
        $em = $this->getDoctrine()->getManager();
//        $pf = new \FormatEasy\FormatosBundle\Entity\PreguntaFormato();
        $pf = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->findOneBy(array('formato' => $formato, 'pregunta' => $pregunta));
        $form = $this->createFormBuilder();
        $canonical = str_replace('-', '_', $pf->getPlantillaRespuesta()->getCanonical());
        if(!$canonical){
            $canonical = $pregunta->getPlantilla()->getCanonical();
        }
        $pr = $pf->getPlantillaRespuesta();
        $nombre = $pf->getCanonicalForm();
        if(!$nombre){
            $nombre = $pregunta->getCanonicalForm();
        }
        if(!$pr){
            $pr = $pregunta->getPlantilla();
        }
        if(stripos($canonical, 'texto') !== false || stripos($canonical, 'fecha') !== false || stripos($canonical, 'hora') !== false || stripos($canonical, 'numero') !== false){
            $form->add($nombre, $pr->getWidget());
        }else{
            foreach ($pregunta->getRespuestas() as $respuesta) {
                $form->add($respuesta->getCanonicalForm(), $pr->getWidget());
            }
        }
        $disabled = $this->getRequest()->get('disabled', false);
        $form->setDisabled($disabled)
            ->setAction($this->generateUrl('pregunta__responderPregunta', array(
            'pregunta'     =>  $pregunta->getCanonical(),
            'formato'     =>  $formato->getCanonical(),
        )));
        $form = $form->getForm();
        return array(
            'p'     =>  $pregunta,
            'f'     =>  $formato,
            'nombre'=>  $nombre,
            'pf'    =>  $pf,
            'pr'    =>  $pr,
            'form'  =>  $form->createView(),
        );
    }
    
    /**
     * Lists all Pregunta entities.
     *
     * @Route("/", name="pregunta_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyFormatosBundle:Pregunta')->findAll();

        $datos = array(
            'entities' => $entities,
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Pregunta:_index.html.twig', $datos);
        }
        
        return $datos;
    }
    /**
     * Creates a new Pregunta entity.
     *
     * @Route("/", name="pregunta__create")
     * @Method("POST")
     * @Template("FormatEasyFormatosBundle:Pregunta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pregunta();
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
                return $this->render('FormatEasyFormatosBundle:Pregunta:_show.html.twig', $datos);
            }
            return $this->redirect($this->generateUrl('pregunta__show', array('id' => $entity->getId())));
        }
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Pregunta:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
    * Creates a form to create a Pregunta entity.
    *
    * @param Pregunta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Pregunta $entity)
    {
        $form = $this->createForm(new PreguntaType(), $entity, array(
            'action' => $this->generateUrl('pregunta__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pregunta entity.
     *
     * @Route("/new", name="pregunta__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Pregunta();
        $form   = $this->createCreateForm($entity);

        $datos = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Pregunta:_new.html.twig', $datos);
        }

        return $datos;
    }

    /**
     * Finds and displays a Pregunta entity.
     *
     * @Route("/{id}", name="pregunta__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Pregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Pregunta:_show.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
     * Displays a form to edit an existing Pregunta entity.
     *
     * @Route("/{id}/edit", name="pregunta__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Pregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pregunta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Pregunta:_edit.html.twig', $datos);
        }
        
        return $datos;
    }

    /**
    * Creates a form to edit a Pregunta entity.
    *
    * @param Pregunta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pregunta $entity)
    {
        $form = $this->createForm(new PreguntaType(), $entity, array(
            'action' => $this->generateUrl('pregunta__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pregunta entity.
     *
     * @Route("/{id}", name="pregunta__update")
     * @Method("PUT")
     * @Template("FormatEasyFormatosBundle:Pregunta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:Pregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $datos = array('id' => $id);
            
            if($request->isXmlHttpRequest()){
                return $this->render('FormatEasyFormatosBundle:Pregunta:_edit.html.twig', $datos);
            }

            return $this->redirect($this->generateUrl('pregunta__edit', $datos));
        }
        
        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        if($request->isXmlHttpRequest()){
            return $this->render('FormatEasyFormatosBundle:Pregunta:_edit.html.twig', $datos);
        }

        return $datos;
    }
    /**
     * Deletes a Pregunta entity.
     *
     * @Route("/{id}", name="pregunta__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyFormatosBundle:Pregunta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pregunta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Pregunta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pregunta__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
