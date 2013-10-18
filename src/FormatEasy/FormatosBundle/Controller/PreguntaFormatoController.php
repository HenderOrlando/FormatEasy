<?php

namespace FormatEasy\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FormatEasy\FormatosBundle\Entity\PreguntaFormato;
use FormatEasy\FormatosBundle\Form\PreguntaFormatoType;
use FormatEasy\FormatosBundle\Entity\Formato;
use FormatEasy\FormatosBundle\Entity\Pregunta;
use FormatEasy\FormatosBundle\Form\PreguntaType;
use FormatEasy\FormatosBundle\Entity\Respuesta;
use FormatEasy\FormatosBundle\Form\RespuestaType;
use FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta;

/**
 * PreguntaFormato controller.
 *
 * @Route("/Formato-Admin")
 */
class PreguntaFormatoController extends Controller
{
    /**
     * Add Pregunta.
     *
     * @Route("/Agregar/{formato}/{respuesta}/", name="preguntaFormato__addPregunta")
     * @Route("/Agregar/{formato}/{respuesta}/{posicion}/", name="preguntaFormato__addPregunta_posicion")
     * @ParamConverter("formato", class="FormatEasyFormatosBundle:Formato", options={"canonical" = "formato", "repository_method" = "findOneByCanonical"})
     * @ParamConverter("respuesta", class="FormatEasyPlantillasBundle:PlantillaRespuesta", options={"canonical" = "respuesta", "repository_method" = "findOneByCanonical"})
     * @Template()
     */
    public function addPreguntaAction(PlantillaRespuesta $respuesta, Formato $formato, Request $request)
    {
        $entity = new PreguntaFormato();
        $entity->setFormato($formato);
        $entity->setPlantillaRespuesta($respuesta);
        $orden = $request->get('posicion', -1);
        $orden_ = FALSE;
        if($orden >= 0){
            $entity->setOrden($orden);
            $orden_ = true;
        }
        $form = $this->getForm($entity, array(
                'form_pregunta' => new PreguntaType(array(
                    'plantilla' => $respuesta,
                    'em'        => $this->getDoctrine()->getManager()
                )),
                'plantilla'     => $respuesta,
                'formato'       => $formato,
                'orden'         => $orden_,
            ), array(
                'respuesta'     => $respuesta->getCanonical(),
                'formato'       => $formato->getCanonical(),
                'em'            => $this->getDoctrine()->getManager(),
            ));
        if($request->getMethod() == 'POST' || $request->getMethod() == 'PUT'){
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return array(
                    'form'   => $form->createView(),
                    'pp' => $formato->getPlantillaPreguntas(),
                    'pr' => $respuesta,
                    'f' => $formato,
                    'pf' => $entity,
                );
            }
        }
        return array(
            'form'   => $form->createView(),
            'pp' => $formato->getPlantillaPreguntas(),
            'pr' => $respuesta,
            'f' => $formato,
        );
    }
    /**
     * Edit Pregunta Formato.
     *
     * @Route("/Ver/{id}/", name="preguntaFormato__verPreguntaFormato")
     * @ParamConverter("entity", class="FormatEasyFormatosBundle:PreguntaFormato", options={"id" = "id", "repository_method" = "findOneById"})
     * @Template("FormatEasyFormatosBundle:PreguntaFormato:_formPreguntaFormato.html.twig")
     */
    public function editPreguntaFormatoAction(PreguntaFormato $entity, Request $request)
    {
        $modify = false;
        if(!$entity->getNombre()){
            $modify = true;
            $entity->setNombre($entity->getPregunta()->getNombre());
        }
        if(!$entity->getDescripcion()){
            $modify = true;
            $entity->setDescripcion($entity->getPregunta()->getDescripcion());
        }
        if($modify){
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
        $respuesta = $entity->getPlantillaRespuesta();
        $formato = $entity->getFormato();
        $orden_ = true;
        $form = $this->getForm($entity, array(
                'form_pregunta' => new PreguntaType(array(
                    'plantilla' => $respuesta,
                    'em'        => $this->getDoctrine()->getManager()
                )),
                'plantilla'     => $respuesta,
                'formato'       => $formato,
                'orden'         => $orden_,
                'em'            => $this->getDoctrine()->getManager()
            ), array(
                'id'            => $entity->getId(),
                'respuesta'     => $respuesta->getCanonical(),
                'formato'       => $formato->getCanonical(),
            ));
        if($request->getMethod() === 'POST' || $request->getMethod() === 'PUT'){
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('preguntaFormato__show', array('id' => $entity->getId())));
            }
        }
        
        return array(
            'form' => $form->createView(),
            'pp' => $formato->getPlantillaPreguntas(),
            'pf' => $entity,
            'pr' => $respuesta,
            'f' => $formato,
        );
    }
    
    /**
    * Creates a form .
    *
    * @param mixed $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function getForm($entity, $datos = array(), $parameters = array())
    {
        $classname_type = str_replace('Entity', 'Form', get_class($entity)).'Type';
        $url_action = explode('\\',get_class($entity));
        $url_action = $url_action[3];
        $url_action = strtolower($url_action[0]).substr($url_action, 1).'__';
        $button = 'Guardar';
        if(is_null($entity->getId())){
            $button = 'Crear';
            $url_action .= 'create';
        }else{
            $button = 'Actualizar';
            $url_action .= 'update';
        }
        $form = $this->createForm(new $classname_type($datos), $entity, array(
            //'action' => $this->generateUrl($url_action, $parameters),
            'method' => 'POST',
            'em'            => $this->getDoctrine()->getManager(),
        ));

//        $form->add('submit', 'submit', array('label' => $button));

        return $form;
    }

    /**
     * Lists all PreguntaFormato entities.
     *
     * @Route("/", name="preguntaFormato_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PreguntaFormato entity.
     *
     * @Route("/{respuesta}/{formato}/", name="preguntaFormato__create")
     * @ParamConverter("formato", class="FormatEasyFormatosBundle:Formato", options={"canonical" = "formato", "repository_method" = "findOneByCanonical"})
     * @ParamConverter("respuesta", class="FormatEasyPlantillasBundle:PlantillaRespuesta", options={"canonical" = "respuesta", "repository_method" = "findOneByCanonical"})
     * @Method("POST")
     * @Template("FormatEasyFormatosBundle:PreguntaFormato:new.html.twig")
     */
    public function createAction(PlantillaRespuesta $respuesta, Formato $formato)
    {
//        $entity = new PreguntaFormato();
//        $form = $this->createCreateForm($entity);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('preguntaFormato__show', array('id' => $entity->getId())));
//        }
//
//        return array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        );
        $request = $this->getRequest();
        $entity = new PreguntaFormato();
        $entity->setFormato($formato);
        $entity->setPlantillaRespuesta($respuesta);
        $orden = $request->get('posicion', -1);
        if($orden >= 0){
            $entity->setOrden($orden);
        }
        $form = $this->getForm($entity, array(
                'form_pregunta' => new PreguntaType(array(
                    'plantilla' => $respuesta,
                    'em'            => $this->getDoctrine()->getManager()
                )),
                'plantilla'     => $respuesta,
                'formato'       => $formato,
            ), array(
                'respuesta'     => $respuesta->getCanonical(),
                'formato'       => $formato->getCanonical(),
                'em'            => $this->getDoctrine()->getManager(),
            ));
        if($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                if(!$entity->getNombre()){
                    $entity->setNombre($entity->getPregunta()->getNombre());
                }
                if(!$entity->getDescripcion()){
                    $entity->setDescripcion($entity->getPregunta()->getDescripcion());
                }
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('preguntaFormato__show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PreguntaFormato entity.
    *
    * @param PreguntaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PreguntaFormato $entity)
    {
        $form = $this->createForm(new PreguntaFormatoType(), $entity, array(
            'action' => $this->generateUrl('preguntaFormato__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PreguntaFormato entity.
     *
     * @Route("/new", name="preguntaFormato__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PreguntaFormato();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PreguntaFormato entity.
     *
     * @Route("/{id}", name="preguntaFormato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PreguntaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PreguntaFormato entity.
     *
     * @Route("/{id}/edit", name="preguntaFormato__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PreguntaFormato entity.');
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
    * Creates a form to edit a PreguntaFormato entity.
    *
    * @param PreguntaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PreguntaFormato $entity)
    {
        $form = $this->createForm(new PreguntaFormatoType(), $entity, array(
            'action' => $this->generateUrl('preguntaFormato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PreguntaFormato entity.
     *
     * @Route("/{id}", name="preguntaFormato__update")
     * @Method("PUT")
     * @Template("FormatEasyFormatosBundle:PreguntaFormato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PreguntaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('preguntaFormato__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PreguntaFormato entity.
     *
     * @Route("/{id}", name="preguntaFormato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PreguntaFormato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('preguntaFormato_'));
    }

    /**
     * Creates a form to delete a PreguntaFormato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('preguntaFormato__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
