<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/inscription", name="registration")
	 *
	 * @param Request $request
	 * @param UserPasswordEncoderInterface $encoder
	 *
	 * @param MailerInterface $mailer
	 *
	 * @return Response
	 * @throws TransportExceptionInterface
	 */
	public function registration( Request $request, UserPasswordEncoderInterface $encoder, MailerInterface $mailer )
	{
		$user = new User();

		$form = $this->createForm( RegistrationType::class, $user );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() )
		{
			$hash = $encoder->encodePassword( $user, $user->getPassword() );
			$user->setPassword( $hash );

			$user->setToken( md5( uniqid() ) );

			$manager = $this->getDoctrine()->getManager();
			$manager->persist( $user );
			$manager->flush();

			$email = ( new TemplatedEmail() )->from( 'patopenclassrom@gmail.com' )->to( $user->getEmail() )->subject( 'Activation de votre compte' )->htmlTemplate( 'email/activation.html.twig' )->context( [ 'user' => $user ] );

			$mailer->send( $email );

			return $this->redirectToRoute( 'login' );
		}

		return $this->render( 'security/registration.html.twig', [
			'form' => $form->createView()
		] );
	}

	/**
	 * @Route ("/activation/{token}", name="activation")
	 * @param $token
	 * @param UserRepository $repository
	 *
	 * @return RedirectResponse
	 */
	public function activation( $token, UserRepository $repository )
	{
		$user = $repository->findOneBy( [ 'token' => $token ] );

		if ( ! $user )
		{
			throw $this->createNotFoundException( 'Cet utilisateur n\'existe pas...' );
		}

		$user->setToken( null );
		$manager = $this->getDoctrine()->getManager();
		$manager->persist( $user );
		$manager->flush();

		$this->addFlash( 'success', 'Votre compte est bien activé !' );

		return $this->redirectToRoute( 'home' );
	}

	/**
	 * @Route("/connexion", name="login")
	 *
	 * @param AuthenticationUtils $authentication_utils
	 *
	 * @return Response
	 */
	public function login( AuthenticationUtils $authentication_utils )
	{
		$error        = $authentication_utils->getLastAuthenticationError();
		$lastUsername = $authentication_utils->getLastUsername();

		return $this->render( 'security/login.html.twig', [
			'last_username' => $lastUsername,
			'error'         => $error
		] );
	}

	/**
	 * @Route("/deconnexion", name="logout")
	 */
	public function logout()
	{
	}

	/**
	 * @Route ("/oubli-pass", name="forgotten.pass")
	 * @param Request $request
	 * @param UserRepository $repository
	 * @param MailerInterface $mailer
	 * @param TokenGeneratorInterface $generator
	 *
	 * @return RedirectResponse|Response
	 * @throws TransportExceptionInterface
	 */
	public function forgottenPass( Request $request, UserRepository $repository, MailerInterface $mailer, TokenGeneratorInterface $generator )
	{
		$form = $this->createForm( ResetPassType::class );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() )
		{

			$data = $form->getData();
			$user = $repository->findOneByEmail( $data['email'] );

			if ( ! $user )
			{
				$this->addFlash( 'danger', 'Cette adresse  n\'existe pas' );
				$this->redirectToRoute( 'login' );
			}

			$token = $generator->generateToken();

			try
			{
				$user->setToken( $token );
				$manager = $this->getDoctrine()->getManager();
				$manager->persist( $user );
				$manager->flush();

			} catch ( Exception $e )
			{
				$this->addFlash( 'warning', 'Une erreur est survenue : ' . $e->getMessage() );

				return $this->redirectToRoute( 'login' );
			}

			$email = ( new TemplatedEmail() )->from( 'patopenclassrom@gmail.com' )->to( $user->getEmail() )->subject( 'Réinitialisation du mot de passe' )->htmlTemplate( 'email/reset-pass.html.twig' )->context( [ 'user'  => $user,
			                                                                                                                                                                                                         'token' => $token
				] );

			$mailer->send( $email );

			$this->addFlash( 'success', 'Un email de réinitialisation de mot de passe vous a été envoyer' );

			return $this->redirectToRoute( 'login' );

		}

		return $this->render( 'security/resetPass.html.twig', [
			'form' => $form->createView()
		] );
	}

	/**
	 * @Route ("/reset-pass/{token}", name="app.reset.password")
	 * @param $token
	 * @param Request $request
	 * @param UserPasswordEncoderInterface $encoder
	 *
	 * @return RedirectResponse|Response
	 */
	public function resetPassword( $token, Request $request, UserPasswordEncoderInterface $encoder )
	{
		$user = $this->getDoctrine()->getRepository( User::class )->findOneBy( [ 'token' => $token ] );

		if ( ! $user )
		{
			$this->addFlash( 'error', 'Token inconnu' );

			return $this->redirectToRoute( 'login' );
		}

		if ( $request->isMethod( 'POST' ) )
		{
			$user->setToken( null );

			$user->setPassword( $encoder->encodePassword( $user, $request->request->get( 'password' ) ) );

			$manager = $this->getDoctrine()->getManager();
			$manager->persist( $user );
			$manager->flush();

			$this->addFlash( 'success', 'Votre mot de passe a bien été modifié !' );

			return $this->redirectToRoute( 'login' );
		}
		else
		{
			return $this->render( 'security/newPassword.html.twig', [ 'token' => $token ] );
		}
	}
}
