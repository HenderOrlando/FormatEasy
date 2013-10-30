<?php

namespace FormatEasy\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use FormatEasy\FormatosBundle\Entity\PreguntaFormato;
use FormatEasy\FormatosBundle\Form\PreguntaFormatoType;
use FormatEasy\FormatosBundle\Entity\Formato;
use FormatEasy\FormatosBundle\Form\PreguntaType;
use FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta;

/**
 * PreguntaFormato controller.
 *
 * @Route("/Formato-Admin")
 */
class PreguntaFormatoController extends Controller
{
    /**
     * alinear Pregunta.
     *
     * @Route("/Alinear/{pregunta}/{alinea}/", name="preguntaFormato_alinear")
     * @ParamConverter("pregunta", class="FormatEasyFormatosBundle:PreguntaFormato", options={"id" = "id"})
     * @Template()
     */
    public function alinearPreguntaAction(PreguntaFormato $pf, Request $request){
        $em = $this->getDoctrine()->getManager();
        $alinea = $request->get('alinea', 'Izquierda');
        $datos = $this->setStyle($em, array('Alinear', $alinea), $pf, 'Alinear');
        return JsonResponse::create($datos);
    }
    /**
     * ancho Pregunta.
     *
     * @Route("/Ancho/{pregunta}/{ancho}/", name="preguntaFormato_ancho")
     * @ParamConverter("pregunta", class="FormatEasyFormatosBundle:PreguntaFormato", options={"id" = "id"})
     * @Template()
     */
    public function anchoPreguntaAction(PreguntaFormato $pf, Request $request){
        $em = $this->getDoctrine()->getManager();
        $ancho = $request->get('ancho', '1');
        $datos = $this->setStyle($em, 'Ancho-'.$ancho, $pf, 'Ancho');
        return JsonResponse::create($datos);
    }
    /**
     * columnas Pregunta.
     *
     * @Route("/Columnas/{columnas}/{pregunta}/", name="preguntaFormato_columnas")
     * @ParamConverter("pregunta", class="FormatEasyFormatosBundle:PreguntaFormato", options={"id" = "id"})
     * @Template()
     */
    public function columnasPreguntaAction(PreguntaFormato $pf, Request $request){
        $em = $this->getDoctrine()->getManager();
        $columna = $request->get('columnas', '2');
        $datos = $this->setStyle($em, 'Columnas-'.$columna, $pf, 'Columnas');
        return JsonResponse::create($datos);
    }
    /**
     * vista Pregunta.
     *
     * @Route("/Vista/{vista}/{pregunta}/", name="preguntaFormato_vista")
     * @ParamConverter("pregunta", class="FormatEasyFormatosBundle:PreguntaFormato", options={"id" = "id"})
     * @Template()
     */
    public function vistaPreguntaAction(PreguntaFormato $pf, Request $request){
        $em = $this->getDoctrine()->getManager();
        $vista = $request->get('vista', 'Bloque');
        $datos = $this->setStyle($em, 'En-'.$vista, $pf, 'Vista');
        return JsonResponse::create($datos);
    }
    private function setStyle($em, $style, PreguntaFormato $pf, $tipo = false){
        $etiqueta = null;
        if(is_array($style)){
            $etiqueta = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->getOneEtiqueta($style);
        }
        elseif(is_string($style)){
            $etiqueta = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->findOneBy(array('canonical' => $style));
        }
        $datos = array(
            'style' =>  $style,
            'error' => true,
            'msg'   => ''
        );
        if($etiqueta){
            if(!is_null($pf->getGrupo())){
                $grupo = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->findBy(array('grupo' => $pf->getGrupo(), 'formato' => $pf->getFormato()));
                foreach($grupo as $p){
                    $this->validaEtiquetas($p, $em, $etiqueta, $tipo);
                }
            }else{
                $this->validaEtiquetas($pf, $em, $etiqueta, $tipo);
            }
            $em->flush();
            $datos['error'] = false;
            $datos['etiqueta'] = $etiqueta->getCanonical();
        }
        return $datos;
    }
    private function validaEtiquetas(PreguntaFormato $pf, $em, $etiqueta, $tipo = false){
        $et = false;
        if($tipo)
            $et = $pf->getEtiqueta($tipo);
        if($et){
            $pf->removeEtiqueta($et);
        }
        $pf->addEtiqueta($etiqueta);
        $em->persist($pf);
    }
    /**
     * Add Pregunta.
     *
     * @Route("/Etiqueta/{accion}/{formato}/{etiqueta}/{posicion}/", name="preguntaFormato__agregarEtiquetas")
     * @Route("/Etiqueta/{accion}/{formato}/{etiqueta}/", name="preguntaFormato__agregarEtiquetas")
     * @Route("/Etiqueta/{accion}/{formato}/", name="preguntaFormato__agregarEtiquetas")
     * @ParamConverter("formato", class="FormatEasyFormatosBundle:Formato", options={"canonical" = "formato", "repository_method" = "findOneByCanonical"})
     * @Template()
     */
    public function agrupaPreguntaAction(Formato $formato, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $orden = $request->get('posicion', -1);
        $accion = $request->get('accion', -1);
        $etiquetas = $request->get('etiqueta', false);
        $pregunta = $request->get('pregunta', false);
        if($pregunta){
            $pregunta = $em->getRepository('FormatEasyFormatosBundle:Pregunta')->findOneByCanonical(str_replace($formato->getCanonical().'-', '', $pregunta));
        }
        if($etiquetas){
            $etiqueta_ = explode(' ', $etiquetas);
            $etiqueta = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->getOneByWithEtiquetas(array('canonical' => "'".$etiqueta_[1]."'"),array('diseño'));
            $pf = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->findOneBy(array('pregunta' => $pregunta, 'formato' => $formato));
            $pf->addEtiqueta($etiqueta);
//            $num_grupos = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->getNumGrupos($pregunta,$formato);
//            var_dump($num_grupos);
//            die;
            $em->persist($pf);
            $em->flush();
            return JsonResponse::create(array(
                'msg' =>  '',
                'error' =>  false,
            ));
        }
        return JsonResponse::create(array(
            'orden'     =>  $orden,
            'accion'    =>  $accion,
            'formato'   =>  $formato?$formato:'No Formato',
            'etiqueta'  =>  $etiqueta?$etiqueta:$request->get('etiqueta', false),
            'preguntaFormato'  =>  $pf?$pf:'No Pregunta Formato',
            'pregunta'  =>  $pregunta?$pregunta:$request->get('pregunta', false),
        ));
    }
    /**
     * Add Pregunta.
     *
     * @Route("/Agregar/{formato}/{respuesta}/", name="preguntaFormato__addPregunta")
     * @Route("/Agregar/{formato}/{respuesta}/{posicion}/{etiqueta}", name="preguntaFormato__addPregunta_posicion")
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
        $etiqueta = $request->get('etiqueta', 'Formato');
        $orden_ = FALSE;
        if($orden >= 0){
            $entity->setOrden($orden+1);
            $orden_ = true;
        }
        if(in_array('Diseno', $respuesta->getTextEtiquetas(false))){
            return $this->render('FormatEasyFormatosBundle:PreguntaFormato:_formPreguntaFormatoDiseño.html.twig', array(
                'pp' => $formato->getPlantillaPreguntas(),
                'pr' => $respuesta,
                'f' => $formato,
                'pf' => $entity,
            ));
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
                $this->sortPreguntaFormato($em, $entity, -1, $entity->getOrden(), $etiqueta);
//                $em->persist($entity);
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
     * Edit Orden Pregunta Formato.
     *
     * @Route("/Cambiar-Orden/", name="preguntaFormato__ordenPreguntaFormato_")
     * @Route("/Cambiar-Orden/{pos_antes}/a/{pos_ahora}/{id}/{etiqueta}", name="preguntaFormato__ordenPreguntaFormato", defaults={"id" = -1, "pos_antes" = -1, "pos_ahora" = -1})
     * @Template("FormatEasyFormatosBundle:PreguntaFormato:_formPreguntaFormato.html.twig")
     */
    public function editOrdenPreguntaFormatoAction(Request $request)
    {
        $pos_antes = $request->get('pos_antes')+0;
        $pos_ahora = $request->get('pos_ahora')+0;
        $etiqueta = $request->get('etiqueta', 'Formato');
        $id = $request->get('id')+0;
//        $pos_ahora++;
        if($pos_ahora == -1){
            return new JsonResponse(array(
                'error' => TRUE,
                'msg'   => 'Fail',
                'datos' => array(
                    'antes' =>  $pos_antes,
                    'ahora' =>  $pos_ahora,
                    'etiqueta' =>  $etiqueta,
                    'id'    =>  $id
                )
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $pf = null;
        if($pos_antes){
            $pf = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->getOneByWithEtiquetas(array('formato' => $id, 'orden' => $pos_antes), array($etiqueta));
            if(is_array($pf) && isset($pf['dql'])){
                return new JsonResponse(array(
                    'error' => TRUE,
                    'msg'   => 'Fail',
                    'datos' => array(
                        'antes' =>  $pos_antes,
                        'ahora' =>  $pos_ahora,
                        'id'    =>  $id,
                        'result'    =>  $pf,
                    )
                ));
            }
            
        }
        $this->sortPreguntaFormato($em, $pf, $pos_antes, $pos_ahora, $etiqueta);
        $em->flush();
        return new JsonResponse(array(
//            'viejas'=> $viejas,
            'error' => FALSE,
            'msg'   => 'Ok',
//            'datos' => array(
//                    'antes' =>  $pos_antes,
//                    'ahora' =>  $pos_ahora,
//                    'id'    =>  $id
//                ),
        ));
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
                $this->sortPreguntaFormato($em, $entity, -1, $entity->getOrden());
//                $em->persist($entity);
                $em->flush();

//                return $this->redirect($this->generateUrl('preguntaFormato__show', array('id' => $entity->getId())));
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
     * Edit Diseño Pregunta Formato.
     *
     * @Route("/Diseño/{id}/", name="preguntaFormato__verDiseñoPreguntaFormato")
     * @ParamConverter("entity", class="FormatEasyFormatosBundle:PreguntaFormato", options={"id" = "id", "repository_method" = "findOneById"})
     * @Template()
     */
    public function editDisenoPreguntaFormatoAction(PreguntaFormato $entity, Request $request)
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
                $this->sortPreguntaFormato($em, $entity, -1, $entity->getOrden());
//                $em->persist($entity);
                $em->flush();

//                return $this->redirect($this->generateUrl('preguntaFormato__show', array('id' => $entity->getId())));
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
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $title = 'Preguntas de Formatos';
        $entity = 'PreguntaFormato';
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

    public function sortPreguntaFormato($em, PreguntaFormato $pf, $pos_antes, $pos_ahora, $etiqueta = null) {
        $pfs_ = array();
        if(!$pf || $pos_antes < 0 || ($pf && $pos_antes > -1 && $pos_antes > $pos_ahora)){
            $pfs_ = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->getGreaterEqualTo(array('orden' => $pos_ahora), array('orden' => 'Asc'), $etiqueta);
            $pos = $pos_ahora;
        }elseif($pf && $pos_antes < $pos_ahora){
            $pfs_ = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->getGreaterEqualTo(array('orden' => $pos_antes+1), array('orden' => 'Asc'), $etiqueta);
            $pos = $pos_antes-1;
        }
        foreach($pfs_ as $pfs){
            if(!$pf || $pos_antes < 0  || ($pf && $pos_antes > -1 && $pf->getId() != $pfs->getId() && $pos+1 != $pos_ahora)){
                $pfs->setOrden(++$pos);
                $em->persist($pfs);
            }else{
                break;
            }
        }
        if($pf){
            $pf->setOrden($pos_ahora);
            $em->persist($pf);
        }
    }
}
