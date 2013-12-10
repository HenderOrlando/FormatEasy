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
     * @Route("/Responder/{pregunta}/en/{formato}/{disabled}-Deshabilitado/", name="pregunta__responderPregunta_deshabilitado", defaults={"disabled" = "No"})
     * @ParamConverter("pregunta", class="FormatEasyFormatosBundle:Pregunta", options={"canonical" = "pregunta", "repository_method" = "findOneByCanonical"})
     * @ParamConverter("formato", class="FormatEasyFormatosBundle:Formato", options={"canonical" = "formato", "repository_method" = "findOneByCanonical"})
     * @Template("FormatEasyFormatosBundle:Pregunta:_formResponderPregunta.html.twig")
     */
    public function formResponderPreguntaAction(Pregunta $pregunta, Formato $formato){
        $em = $this->getDoctrine()->getManager();
//        $pf = new \FormatEasy\FormatosBundle\Entity\PreguntaFormato();
        $pf = $em->getRepository('FormatEasyFormatosBundle:PreguntaFormato')->findOneBy(array('formato' => $formato, 'pregunta' => $pregunta));
        if(!$pf){
            throw $this->createNotFoundException('Pregunta "'.$pregunta.'" de Formato "'.$formato.'" no Encontrada');
        }
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
        if(stripos($pr->getWidget(), 'choice') === false && stripos($pr->getWidget(), 'checkbox') === false && stripos($pr->getWidget(), 'radio') === false){
            $form->add($nombre, $pr->getWidget());
        }else{
            $opts[-1] = 'Agregar';
            foreach($pregunta->getRespuestas() as $respuesta){
                $opts[$respuesta->getId()] = $respuesta->getNombre();
            }
            $form->add($nombre, $pr->getWidget(), array(
                'choices'   =>  $opts,
                'empty_value' => 'Elije una '.$nombre
            ));
        }
        $disabled = $this->getRequest()->get('disabled', false);
        $form->setDisabled($disabled)
            ->setAction($this->generateUrl('pregunta__responderPregunta', array(
            'pregunta'     =>  $pregunta->getCanonical(),
            'formato'     =>  $formato->getCanonical(),
        )));
        $form_ = $form->getForm();
        return array(
            'p'     =>  $pregunta,
            'f'     =>  $formato,
            'nombre'=>  $nombre,
            'pf'    =>  $pf,
            'pr'    =>  $pr,
            'form'  =>  $form_->createView(),
        );
    }
    
    /**
     * Lists all Pregunta entities.
     *
     * @Route("/", name="pregunta_")
     * @Template("FormatEasyCommonBundle:Index:menu.html.twig")
     */
    public function indexAction(Request $request)
    {
        $title = 'Preguntas';
        $entity = 'Pregunta';
        $bundle = 'Formatos';
        $route = strtolower($entity).'_';
        $limit = 10;
        $feu = $this->getFormatEasyUtils();
        
//        $form = $feu->getFormFilter(array(), $route);
//        
//        $data = array();
//        if ($form->isValid()) {
//           $data = $form->getData();
//        }
//        
        $qb = null;
//        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
//        $qb->select('a')
//           ->from('FormatEasy'.$bundle.'Bundle:'.$entity, 'a');
//        if (array_key_exists("filtro", $data)){
//            $data['filtro'] = trim($data['filtro']);
//            if (strlen($data['filtro'])>0){
//                   $qb
//                      ->orWhere($qb->expr()->like("a.widget", "?1"))
//                      ->orWhere($qb->expr()->like("a.fechaCreado", "?1"))
//                      ->setParameter(1,"%".$data['filtro']."%");      
//            }
//        }
//        $qb = $qb->getQuery();
        $paginacion = $feu->getPaginacion($entity, $bundle, $limit, $route, $qb);
//        $paginacion['form_filter'] = $form;
        $botones = array(
            array(
                'url'   => $this->generateUrl('pregunta__new'),
                'type'  => 'primary',
                'label' => '<span class="glyphicon glyphicon-plus" ></span> Agregar',
            ),
        );
        $head = array(
            'fil'=>array(
                array(
                    'col'=>array(
                        array(
                            'dato'    =>   'Nombre',
                        ),
                        array(
                            'dato'    =>   'Descripcion',
                        ),
                        array(
                            'dato'    =>   'Plantilla Respuestas',
                        ),
                        array(
                            'dato'    =>   'Acciones',
                            'acciones'=>    array(
                                array(
                                    'url'   => 'pregunta__edit',
                                    'data_url'=> array('id'),
                                    'type'  => 'default',
                                    'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                                ),
                                array(
                                    'url'   => 'pregunta__delete',
                                    'data_url'=> array('id'),
                                    'type'  => 'danger',
                                    'label' => '<span class="glyphicon glyphicon-trash" ></span> Borrar',
                                ),
                            )
                        ),
                    )
                ),
            )
        );
        $datos = array(
            'paginas'       =>  $paginacion['pag'],
            'form_filtro'   =>  $paginacion['form_filter']->createView(),
            'title'         =>  $title,
            'head'          =>  $head,
            'botones'       =>  $botones,
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false)){
            return $this->render('FormatEasyCommonBundle:Index:_menu.html.twig', $datos);
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
    /**
     * @return \FormatEasy\CommonBundle\Controller\IndexController Utilidades de FormatEasy
     */
    public function getFormatEasyUtils() {
        return $this->get('formateasy.util');
    }
}
