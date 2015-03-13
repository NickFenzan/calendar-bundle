<?php
namespace MillerVein\CalendarBundle\Controller\Admin;

use MillerVein\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of PatientController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/patient")
 */
class PatientController extends DefaultController{
    const CLASS_NAME = "Patient";
    const FORM_SERVICE = "patient";
    const DISPLAY_PROPERTY = "lname";
    
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
