<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use EMR\Bundle\CalendarBundle\Entity\GoalReward;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/goal_reward")
 */
class GoalRewardController extends Controller {

    /**
     * @Route("/", name="goal_reward")
     * @Method({"GET"});
     * @Template()
     */
    public function indexAction() {
        $rewardRepo = $this->getDoctrine()->getManager()->getRepository('EMRCalendarBundle:GoalReward');
        return [
            'rewards' => $rewardRepo->findAll()
        ];
    }

    /**
     * @Route("/new", name="goal_reward_new")
     * @Method({"GET"});
     * @Template()
     */
    public function newAction() {
        $reward = new GoalReward();
        $form = $this->createCreateForm($reward);
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/", name="goal_reward_create")
     * @Method({"POST"});
     * @Template("EMRCalendarBundle:GoalReward:new.html.twig")
     */
    public function createAction(Request $request) {
        $reward = new GoalReward();
        $form = $this->createCreateForm($reward);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reward);
            $em->flush();
            return $this->redirectToRoute('goal_reward');
        }
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/edit", name="goal_reward_edit")
     * @ParamConverter("goal", class="EMRCalendarBundle:GoalReward")
     * @Method({"GET"});
     * @Template()
     */
    public function editAction(GoalReward $reward) {
        $form = $this->createEditForm($reward);
        $deleteForm = $this->createDeleteForm($reward);
        return ['form' => $form->createView(),
            'delete' => $deleteForm->createView()];
    }

    /**
     * @Route("/{id}", name="goal_reward_update")
     * @ParamConverter("reward", class="EMRCalendarBundle:GoalReward")
     * @Method({"PUT"});
     * @Template("EMRCalendarBundle:GoalReward:edit.html.twig")
     */
    public function updateAction(Request $request, GoalReward $reward) {
        $form = $this->createEditForm($reward);
        $deleteForm = $this->createDeleteForm($reward);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reward);
            $em->flush();
            return $this->redirectToRoute('goal_reward');
        }
        return ['form' => $form->createView(),
            'delete' => $deleteForm->createView()];
    }

    /**
     * @Route("/{id}", name="goal_reward_delete")
     * @ParamConverter("reward", class="EMRCalendarBundle:GoalReward")
     * @Method({"DELETE"});
     */
    public function deleteAction(Request $request, GoalReward $reward) {
        $form = $this->createDeleteForm($reward);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reward);
            $em->flush();
        }
        return $this->redirectToRoute('goal_reward');
    }

    private function createCreateForm(GoalReward $reward) {
        return $this->createForm('new_goal_reward', $reward, [
                    'method' => 'POST',
                    'action' => $this->generateUrl('goal_reward_create')
                ])->add('submit', 'submit', ['label' => 'Create']);
    }

    private function createEditForm(GoalReward $reward) {
        return $this->createForm('new_goal_reward', $reward, [
                    'method' => 'PUT',
                    'action' => $this->generateUrl('goal_reward_update', ['id' => $reward->getId()])
                ])->add('submit', 'submit', ['label' => 'Update']);
    }

    private function createDeleteForm(GoalReward $reward) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('goal_reward_delete', array('id' => $reward->getId())))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
