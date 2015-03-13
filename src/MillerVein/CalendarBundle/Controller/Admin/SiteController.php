<?php
namespace MillerVein\CalendarBundle\Controller\Admin;

use MillerVein\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of SiteController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/site")
 */
class SiteController extends DefaultController{
    const CLASS_NAME = "Site";
    const FORM_SERVICE = "site";
    const DISPLAY_PROPERTY = "city";
    
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
