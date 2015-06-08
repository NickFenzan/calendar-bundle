<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use EMR\Bundle\CalendarBundle\Entity\UtilizationGoal;
use EMR\Bundle\CalendarBundle\Entity\UtilizationMetric;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationMetricGoalController extends Controller {

    /**
     * @Route("/utilization_metric/{id}/utilization_goal/", name="utilization_metric_goal")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @Method({"GET"});
     * @Template()
     */
    public function indexAction(UtilizationMetric $metric) {
        return ['metric'=>$metric];
    }

    /**
     * @Route("/utilization_metric/{id}/utilization_goal/new", name="utilization_metric_goal_new")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @Method({"GET"});
     * @Template()
     */
    public function newAction(UtilizationMetric $metric) {
        $goal = new UtilizationGoal();
        $goal->setMetric($metric);
        $form = $this->createCreateForm($goal);
        return [
            'goal' => $goal,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/utilization_metric/{id}/utilization_goal/", name="utilization_metric_goal_create")
     * @Method({"POST"});
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @Template("EMRCalendarBundle:UtilizationMetricGoal:new.html.twig")
     */
    public function createAction(Request $request, UtilizationMetric $metric) {
        $goal = new UtilizationGoal();
        $goal->setMetric($metric);
        $form = $this->createCreateForm($goal);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($goal);
            $em->flush();
            return $this->redirectToRoute('utilization_metric_goal', ['id' => $metric->getId()]);
        }
        return [
            'goal' => $goal,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/utilization_metric/{id}/utilization_goal/{goal_id}/edit", name="utilization_metric_goal_edit")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @ParamConverter("goal", class="EMRCalendarBundle:UtilizationGoal", options={"id" = "goal_id"})
     * @Method({"GET"});
     * @Template()
     */
    public function editAction(UtilizationMetric $metric, UtilizationGoal $goal) {
        $goal->setMetric($metric);
        $form = $this->createEditForm($goal);
        $deleteForm = $this->createDeleteForm($goal);
        return [
            'goal' => $goal,
            'form' => $form->createView(),
            'delete' => $deleteForm->createView()
        ];
    }

    /**
     * @Route("/utilization_metric/{id}/utilization_goal/{goal_id}", name="utilization_metric_goal_update")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @ParamConverter("goal", class="EMRCalendarBundle:UtilizationGoal", options={"id" = "goal_id"})
     * @Method({"PUT"});
     * @Template("EMRCalendarBundle:UtilizationGoal:edit.html.twig")
     */
    public function updateAction(Request $request, UtilizationMetric $metric, UtilizationGoal $goal) {
        $goal->setMetric($metric);
        $form = $this->createEditForm($goal);
        $deleteForm = $this->createDeleteForm($goal);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($goal);
            $em->flush();
            return $this->redirectToRoute('utilization_metric_goal', ['id' => $metric->getId()]);
        }
        return [
            'goal' => $goal,
            'form' => $form->createView(),
            'delete' => $deleteForm->createView()
        ];
    }

    /**
     * @Route("/utilization_metric/{id}/utilization_goal/{goal_id}", name="utilization_metric_goal_delete")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @ParamConverter("goal", class="EMRCalendarBundle:UtilizationGoal", options={"id" = "goal_id"})
     * @Method({"DELETE"});
     */
    public function deleteAction(Request $request, UtilizationMetric $metric, UtilizationGoal $goal) {
        $goal->setMetric($metric);
        $form = $this->createDeleteForm($goal);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($goal);
            $em->flush();
        }
        return $this->redirectToRoute('utilization_metric_goal', ['id' => $metric->getId()]);
    }

    private function createCreateForm(UtilizationGoal $goal) {
        return $this->createForm('new_utilization_goal', $goal, [
                    'method' => 'POST',
                    'action' => $this->generateUrl('utilization_metric_goal_create', ['id' => $goal->getMetric()->getId()])
                ])
                ->remove('metric')
                ->add('submit', 'submit', ['label' => 'Create']);
    }

    private function createEditForm(UtilizationGoal $goal) {
        return $this->createForm('new_utilization_goal', $goal, [
                    'method' => 'PUT',
                    'action' => $this->generateUrl('utilization_metric_goal_update', ['id' => $goal->getMetric()->getId(),'goal_id'=>$goal->getId()])
                ])
                ->remove('metric')
                ->add('submit', 'submit', ['label' => 'Update']);
    }

    private function createDeleteForm(UtilizationGoal $goal) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('utilization_metric_goal_delete', ['id' => $goal->getMetric()->getId(),'goal_id'=>$goal->getId()]))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
