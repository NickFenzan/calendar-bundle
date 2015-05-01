<?php
namespace MillerVein\Bundle\CalendarBundle\Controller\Admin;

use MillerVein\Bundle\CalendarBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of RecurrenceRuleController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/recurrence_rule")
 */
class RecurrenceRuleController extends DefaultController{
    const CLASS_NAME = "RecurrenceRule";
    const FORM_SERVICE = "recurrence_rule";
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
