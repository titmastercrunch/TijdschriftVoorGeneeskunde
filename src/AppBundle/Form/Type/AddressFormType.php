<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('street')
			->add('postalCode')
			->add('municipality')
			->add('country');
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Address',
        ));
    }

	public function getName(){
		return 'address';
	}
}
