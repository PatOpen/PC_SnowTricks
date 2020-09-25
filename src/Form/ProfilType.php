<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
            	'label' => 'Your firstname',
	            'required' => false
            ])
            ->add('lastname', TextType::class, [
            	'label' => 'Your lastname',
	            'required' => false
            ])
            ->add('email', EmailType::class, [
	            'label' => 'Your email',
	            'required' => false
            ])
            ->add('avatar', FileType::class, [
	            'label' => false,
	            'required' => false,
	            'mapped' => false,
	            'constraints' => [
		            new File([
			            'maxSize' => '2048k',
			            'mimeTypes' => [
				            'image/jpeg',
				            'image/png',
			            ],
			            'mimeTypesMessage' => 'Merci de mettre une image valide (jpeg ou png)',
		            ])
	            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
	        'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
