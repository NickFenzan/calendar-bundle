<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use EMR\Bundle\CalendarBundle\Entity\UtilizationMetric;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/utilization_metric")
 */
class UtilizationMetricController extends Controller {

    /**
     * @Route("/", name="utilization_metric")
     * @Method({"GET"});
     * @Template()
     */
    public function indexAction() {
        $metricRepo = $this->getDoctrine()->getManager()->getRepository('EMRCalendarBundle:UtilizationMetric');
        return [
            'metrics' => $metricRepo->findAll()
        ];
    }

    /**
     * @Route("/new", name="utilization_metric_new")
     * @Method({"GET"});
     * @Template()
     */
    public function newAction() {
        $metric = new UtilizationMetric();
        $form = $this->createCreateForm($metric);
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/", name="utilization_metric_create")
     * @Method({"POST"});
     * @Template("EMRCalendarBundle:UtilizationMetric:new.html.twig")
     */
    public function createAction(Request $request) {
        $metric = new UtilizationMetric();
        $form = $this->createCreateForm($metric);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($metric);
            $em->flush();
            return $this->redirectToRoute('utilization_metric');
        }
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/edit", name="utilization_metric_edit")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @Method({"GET"});
     * @Template()
     */
    public function editAction(UtilizationMetric $metric) {
        $form = $this->createEditForm($metric);
        $deleteForm = $this->createDeleteForm($metric);
        return ['form' => $form->createView(),
            'delete' => $deleteForm->createView()];
    }

    /**
     * @Route("/{id}", name="utilization_metric_update")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @Method({"PUT"});
     * @Template("EMRCalendarBundle:UtilizationMetric:edit.html.twig")
     */
    public function updateAction(Request $request, UtilizationMetric $metric) {
        $form = $this->createEditForm($metric);
        $deleteForm = $this->createDeleteForm($metric);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($metric);
            $em->flush();
            return $this->redirectToRoute('utilization_metric');
        }
        return ['form' => $form->createView(),
            'delete' => $deleteForm->createView()];
    }

    /**
     * @Route("/{id}", name="utilization_metric_delete")
     * @ParamConverter("metric", class="EMRCalendarBundle:UtilizationMetric")
     * @Method({"DELETE"});
     */
    public function deleteAction(Request $request, UtilizationMetric $metric) {
        $form = $this->createDeleteForm($metric);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($metric);
            $em->flush();
        }
        return $this->redirectToRoute('utilization_metric');
    }

    private function createCreateForm(UtilizationMetric $metric) {
        return $this->createForm('new_utilization_metric', $metric, [
                    'method' => 'POST',
                    'action' => $this->generateUrl('utilization_metric_create')
                ])->add('submit', 'submit', ['label' => 'Create']);
    }

    private function createEditForm(UtilizationMetric $metric) {
        return $this->createForm('new_utilization_metric', $metric, [
                    'method' => 'PUT',
                    'action' => $this->generateUrl('utilization_metric_update', ['id' => $metric->getId()])
                ])->add('submit', 'submit', ['label' => 'Update']);
    }

    private function createDeleteForm(UtilizationMetric $metric) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('utilization_metric_delete', array('id' => $metric->getId())))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
