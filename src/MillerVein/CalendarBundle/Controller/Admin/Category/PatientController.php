<?php
namespace MillerVein\CalendarBundle\Controller\Admin\Category;

use MillerVein\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CategoryPatientController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/category/patient")
 */
class PatientController extends DefaultController{
    const CLASS_NAME = "Category\Patient";
    const FORM_SERVICE = "category_patient";
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
