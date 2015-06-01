<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Subscriber;
use AppBundle\Entity\Subscription;
use AppBundle\Entity\Address;
use AppBundle\Entity\Types\PaymentType;

/**
 * Class LoadBookstoreDate
 */
class LoadSubscriberData implements FixtureInterface, ContainerAwareInterface
{

    /** @var ContainerInterface */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $subscriber = new Subscriber();
        $subscriber->setPricingType(PaymentType::BOOKSTORE_PRICE);
        $date = new \DateTime();
        $expire = new \DateTime();
        $expire->add(new \DateInterval('P1Y'));
        //create a new subscription with
        $subscription = new Subscription($date, $expire);
        $subscription->setPaid(true);
        $subscriber->addSubscription($subscription);
        $subscription->setSubscriber($subscriber);

        $address = new Address();
        $address->setStreet('straat testuserbookstore');
        $address->setMunicipality('gemeente testuserbookstore');
        $address->setPostalCode(4490);
        $address->setCountry('Belgium');
        $subscriber->setFacturationAddress($address);
        $subscriber->setDeliveryAddress($address);

        $user = $manager->getRepository('AppBundle:User')->findOneBy(array('username' => 'testuserbookstore'));
        $user->addRole('ROLE_PAIDUSER');
        $user->setSubscriber($subscriber);
        $subscriber->setUser($user);

        $manager->persist($subscription);
        $manager->persist($subscriber->getFacturationAddress());
        $manager->persist($subscriber->getDeliveryAddress());
        $manager->persist($subscriber);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}