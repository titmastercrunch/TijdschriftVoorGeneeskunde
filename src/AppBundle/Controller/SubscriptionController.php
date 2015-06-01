<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Subscriber;
use AppBundle\Entity\Subscription;
use AppBundle\Form\Type\SubscriberFormType;

class SubscriptionController extends Controller{

    /**
     * @Route("/subscription/{userid}/new", name="newSubscription")
     */
    public function newSubscriptionAction(Request $request, $userid){

        $em = $this->getDoctrine()->getManager();
        $newsubscriber = false;

        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        if(!$user->getSubscriber()){
            $user->setSubscriber(new Subscriber());
            $newsubscriber = true;
        }

        $subscriber = $user->getSubscriber();

        $subscriberform = $this->createForm(new SubscriberFormType(), $subscriber);
        $subscriberform->handleRequest($request);

        if ($subscriberform->isValid())
        {
            $date = new \DateTime();
            $expire = new \DateTime();
            $expire->add(new \DateInterval('P1Y'));
            //create a new subscription with
            $subscription = new Subscription($date, $expire);
            $subscriber->addSubscription($subscription);
            $subscription->setSubscriber($subscriber);
            $user->setSubscriber($subscriber);
            $subscriber->setUser($user);


            $em->persist($subscription);
            if($newsubscriber){
                $em->persist($subscriber->getFacturationAddress());
                $em->persist($subscriber->getDeliveryAddress());
                $em->persist($subscriber);
            }

            $em->flush();
            $this->addFlash(
                'notice', 'subscription added'
            );
            return $this->render('FOSUserBundle::Profile/show.html.twig', array(
                'user' => $user,
            ));
        }


        return $this->render('subscription/new.html.twig', array(
            'form' => $subscriberform->createView(),
            'newsubscriber' => $newsubscriber,
        ));
    }

    /**
     * @Route("/subscription/{userid}/activate", name="activateSubscription")
     */
    public function activateSubscriptionAction(Request $request, $userid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));

        $user->getSubscriber()->getActiveSubscription()->setPaid(true);
        $user->addRole('ROLE_PAIDUSER');
        $em->flush();

        return $this->render('FOSUserBundle::Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/subscription/{userid}/deactivate", name="deActivateSubscription")
     */
    public function deActivateSubscriptionAction(Request $request, $userid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));

        $user->getSubscriber()->getActiveSubscription()->setPaid(false);
        $user->removeRole('ROLE_PAIDUSER');
        $em->flush();

        return $this->render('FOSUserBundle::Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

}
