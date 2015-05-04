<?php

namespace EMR\Bundle\CalendarBundle\Form\Handler;

use EMR\Bundle\CalendarBundle\DomainManager\HoursManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursFormHandler {

    protected $hoursManager;

    public function __construct(HoursManager $hoursManager) {
        $this->hoursManager = $hoursManager;
    }

    public function handle(FormInterface $form, Request $request) {
        if (!$request->isMethod('POST')) {
            return false;
        }
        $form->bind($request);
        if (!$form->isValid()) {
            return false;
        }
        $validHours = $form->getData();
        $this->hoursManager->save($validHours);
        return true;
    }

}
