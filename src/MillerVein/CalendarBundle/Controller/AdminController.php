<?php

namespace MillerVein\CalendarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * 
 * @Route("/admin")
 */
class AdminController extends Controller {

    /**
     * 
     * @Route("/", name="admin_menu")
     * @Template()
     */
    public function indexAction() {
        return [];
    }

}
