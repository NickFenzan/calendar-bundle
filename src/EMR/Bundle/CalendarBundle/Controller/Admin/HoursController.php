<?php
namespace EMR\Bundle\CalendarBundle\Controller\Admin;

use EMR\Bundle\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of HoursController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/hours")
 */
class HoursController extends DefaultController{
    const CLASS_NAME = "Hours";
    const FORM_SERVICE = "hours";
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
    
    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id, Request $request) {
        return parent::deleteAction($id, $request);
    }

}
