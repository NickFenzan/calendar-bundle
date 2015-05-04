<?php
namespace EMR\Bundle\CalendarBundle\Controller\Admin;

use EMR\Bundle\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ColumnTagController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/column_tag")
 */
class ColumnTagController extends DefaultController{
    const CLASS_NAME = "ColumnTag";
    const FORM_SERVICE = "column_tag";
    const DISPLAY_PROPERTY = "name";
    
    /**
     * @Route("/")
     */
    public function indexAction() {
        return parent::indexAction();
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
