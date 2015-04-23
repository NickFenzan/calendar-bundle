<?php

namespace MillerVein\CalendarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

abstract class DefaultController extends Controller {

    const ENTITY_PATH = "MillerVein\\CalendarBundle\\Entity\\";
    const CLASS_NAME = null;
    const FORM_SERVICE = null;
    const DISPLAY_PROPERTY = null;
    
    public function indexAction() {
        $fullClassName = static::ENTITY_PATH . static::CLASS_NAME;

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($fullClassName);

        return $this->render("MillerVeinCalendarBundle:Default:index.html.twig", [
                    'classname' => static::CLASS_NAME,
                    'entities' => $repo->findAll(),
                    'displayProperty' => static::DISPLAY_PROPERTY
        ]);
    }
    
    public function newAction(Request $request){
        return $this->formAction($request);
    }
    
    public function editAction($id, Request $request){
        return $this->formAction($request,$id);
    }
    
    public function deleteAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $fullClassName = static::ENTITY_PATH . static::CLASS_NAME;
        $entity = $em->find($fullClassName, $id);
        $em->remove($entity);
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response('Success');
    }
    

    protected function formAction(Request $request, $id = null) {
        $fullClassName = static::ENTITY_PATH . static::CLASS_NAME;

        $class = ($id) ?
                $this->getDoctrine()->getManager()->find($fullClassName, $id) :
                new $fullClassName();

        $form = $this->createForm(static::FORM_SERVICE, $class)->add('save', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($class);
            $em->flush();
        }

        return $this->render("MillerVeinCalendarBundle:Default:form.html.twig", [
                    'classname' => static::CLASS_NAME,
                    'form' => $form->createView(),
                    'indexPath' => ($id) ? '../' : './'
            ]
        );
    }

  
}
