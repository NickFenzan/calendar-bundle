<?php
namespace MillerVein\CalendarBundle\Controller\Admin;

use MillerVein\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of HoursController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/hours")
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

}
