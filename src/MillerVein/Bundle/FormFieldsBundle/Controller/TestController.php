<?php

namespace MillerVein\Bundle\FormFieldsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of testController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TestController extends Controller{
    /**
     * @Route("/date_range")
     */
    public function dateRangeTestAction(Request $request){
        $form = $this->testForm();
        $form->handleRequest($request);
        if($form->isValid()){
            $data = $form->getData();
            $daterange = $data['datetime'];
            echo $daterange->getStart()->format('Y-m-d H:i:s')."<bR>";
            echo $daterange->getEnd()->format('Y-m-d H:i:s');
        }
        
        return $this->render('::form.html.twig',['form'=>$form->createView()]);
    }
    
    protected function testForm(){
        $fb = $this->createFormBuilder();
        $fb->add('datetime','datetime_range',[
            'mode' => 'date'
        ]);
        $fb->add('submit','submit');
        return $fb->getForm();
    }
}
