<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,)
            ->add('description', TextareaType::class)
	        ->add('category', EntityType::class, [
	        	'class'=> Category::class,
		        'choice_label' => function($category){
	        	    return $category->getName();
		        }
	        ])
	        ->add('videos', UrlType::class, [
	        	'label' => 'Add an video youtube ( enter the full link)',
		        'attr' => [
			        'class' => 'form-control'
		        ],
		        'mapped' => false,
		        'required' => false
	        ])
	        ->add('image', FileType::class, [
	        	'label' => false,
		        'mapped' => false,
		        'required' => false,
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
            'data_class' => Trick::class,
	        'translation_domain' => 'forms'
        ]);
    }


}
