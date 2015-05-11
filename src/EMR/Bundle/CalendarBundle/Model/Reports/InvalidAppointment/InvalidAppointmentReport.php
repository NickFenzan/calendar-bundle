<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports\InvalidAppointment;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Validator\LegacyValidator;

/**
 * Description of InvalidAppointments
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class InvalidAppointmentReport {
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var Form
     */
    protected $form;
    /**
     *
     * @var LegacyValidator
     */
    protected $validator;
    /**
     * @var InvalidAppointmentRequest 
     */
    protected $request;
    protected $results;
    
    public function __construct(EntityManager $em, LegacyValidator $validator, Form $form) {
        $this->em = $em;
        $this->form = $form;
        $this->validator = $validator;
    }
    
    function getRequest() {
        return $this->request;
    }

    function setRequest(InvalidAppointmentRequest $request) {
        $this->request = $request;
    }
    
    public function getFormView(){
        return $this->form->createView();
    }
    
    function getResults() {
        return $this->results;
    }

    public function run(){
        $apptRepo = $this->em->getRepository('EMRCalendarBundle:Appointment\Appointment');
        $appts = $apptRepo->findAppointmentsByDate($this->request->getStartDate(), $this->request->getEndDate());
        foreach($appts as $appt){
            $errors = $this->validator->validate($appt,null,["invalidAppointment"]);
            if(count($errors) > 0){
                $this->results[] = new InvalidAppointmentResult($appt,$errors);
            }
        }
    }
}