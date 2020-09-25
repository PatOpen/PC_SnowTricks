<?php


namespace App\Controller\profil;


use App\Entity\User;
use App\Form\ProfilType;
use App\Service\AvatarUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

	/**
	 * @Route ("/profil/{pseudo}", name="user.profil")
	 * @IsGranted ("IS_AUTHENTICATED_FULLY")
	 *
	 * @param User $user
	 * @param Request $request
	 * @param AvatarUploader $uploader
	 *
	 * @return Response
	 */
	public function profil(User $user, Request $request, AvatarUploader $uploader)
	{
		$form = $this->createForm(ProfilType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){

			$imageFile = $form->get('avatar')->getData();

			if ($imageFile){
				$imageName = $uploader->upload($imageFile);
				$user->setAvatar($imageName);
			}

			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'Votre profil a été mis à jour');

			return $this->redirectToRoute('user.profil', ['pseudo' => $user->getPseudo()]);
		}

		return $this->render('admin/profil/profil.html.twig', [
				'user' => $user,
				'form' => $form->createView()
		]);
	}
}