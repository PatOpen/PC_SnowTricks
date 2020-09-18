<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/inscription", name="registration")
	 *
	 * @param Request $request
	 * @param UserPasswordEncoderInterface $encoder
	 *
	 * @return Response
	 */
	public function registration( Request $request, UserPasswordEncoderInterface $encoder )
	{
		$user = new User();

		$form = $this->createForm( RegistrationType::class, $user );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() )
		{
			$hash = $encoder->encodePassword( $user, $user->getPassword() );
			$user->setPassword( $hash );
			$manager = $this->getDoctrine()->getManager();
			$manager->persist( $user );
			$manager->flush();

			return $this->redirectToRoute( 'login' );
		}

		return $this->render( 'security/registration.html.twig', [
			'form' => $form->createView()
		] );
	}

	/**
	 * @Route("/connexion", name="login")
	 *
	 * @param AuthenticationUtils $authentication_utils
	 *
	 * @return Response
	 */
	public function login(AuthenticationUtils $authentication_utils)
	{
		$error = $authentication_utils->getLastAuthenticationError();
		$lastUsername = $authentication_utils->getLastUsername();
		return $this->render( 'security/login.html.twig', [
			'last_username' => $lastUsername,
			'error' => $error
		] );
	}

	/**
	 * @Route("/deconnexion", name="logout")
	 */
	public function logout()
	{
	}
}
