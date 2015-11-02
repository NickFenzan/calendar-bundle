<?php
namespace EMR\Bundle\CalendarBundle\Controller\Admin;

use EMR\Bundle\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ColumnController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/column")
 */
class ColumnController extends DefaultController{
    const CLASS_NAME = "Column";
    const FORM_SERVICE = "column_create";
    const DISPLAY_PROPERTY = "name";
    
    /**
     * @Route("/")
     */
    public function indexAction() {
        $fullClassName = static::ENTITY_PATH . static::CLASS_NAME;
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($fullClassName);

        return $this->render("EMRCalendarBundle:Admin\Columns:index.html.twig", ['columns' => $repo->findAll()]);
    }

    /**
     * @Route("/new")
     */
    public function newAction(Request $request) {
        return parent::newAction($request);
    }

    /**
     * @Route("/edit/{id}")
     */
    public function editAction($id, Request $request) {
        return parent::editAction($id, $request);
    }

}
