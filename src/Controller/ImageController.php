<?php


namespace App\Controller;


use App\Entity\Image;
use App\Form\ImageType;
use App\Service\ImageUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{

	/**
	 * @Route ("/change-image/{slug}-{id}", name="change.image")
	 * @IsGranted ("ROLE_USER")
	 * @param $slug
	 * @param Image $image
	 * @param Request $request
	 * @param ImageUploader $image_uploader
	 *
	 * @return RedirectResponse|Response
	 */
	public function changeImage($slug, Image $image, Request $request, ImageUploader $image_uploader)
	{
		$form = $this->createForm(ImageType::class, $image);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$imageFile = $form->get('image')->getData();

			if ($imageFile){
				$imageFilename = $image_uploader->upload($imageFile);
				$image->setImageName($imageFilename);
			}

			$altImage = $form->get('altImage')->getData();
			$image->setAltImage($altImage);

			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'L\'image a bien été ajouté !');
			return $this->redirectToRoute('trick.edit', ['slug' => $slug]);
		}

		return $this->render('pages/changeImage.html.twig', [
			'image' => $image,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/delete-image/{slug}-{id}", name="delete.image")
	 * @IsGranted ("ROLE_USER")
	 * @param $slug
	 * @param Image $image
	 *
	 * @return RedirectResponse
	 */
	public function deleteImage($slug, Image $image)
	{
		$name = $image->getImageName();
		unlink($this->getParameter('images_directory').'/'.$name);

		$manager = $this->getDoctrine()->getManager();
		$manager->remove($image);
		$manager->flush();

		$this->addFlash('success', 'L\'image a bien été supprimé !');

		return $this->redirectToRoute('trick.edit', ['slug' => $slug]);
	}

}