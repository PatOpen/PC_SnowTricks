<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
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
	 * @param MailerInterface $mailer
	 *
	 * @return Response
	 * @throws TransportExceptionInterface
	 */
	public function registration( Request $request, UserPasswordEncoderInterface $encoder, MailerInterface $mailer)
	{
		$user = new User();

		$form = $this->createForm( RegistrationType::class, $user );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() )
		{
			$hash = $encoder->encodePassword( $user, $user->getPassword() );
			$user->setPassword( $hash );

			$user->setToken(md5(uniqid()));

			$manager = $this->getDoctrine()->getManager();
			$manager->persist( $user );
			$manager->flush();

			$email = (new TemplatedEmail())
				->from('patopenclassrom@gmail.com')
				->to($user->getEmail())
				->subject('Activation de votre compte')
				->htmlTemplate('email/activation.html.twig')
				->context(['user' => $user]);

			$mailer->send($email);

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
	public function activation($token, UserRepository $repository)
	{
		$user = $repository->findOneBy(['token' => $token]);

		if (!$user){
			throw $this->createNotFoundException('Cet utilisateur n\'existe pas...');
		}

		$user->setToken(null);
		$manager= $this->getDoctrine()->getManager();
		$manager->persist($user);
		$manager->flush();

		$this->addFlash('success', 'Votre compte est bien activé !');

		return $this->redirectToRoute('home');
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
