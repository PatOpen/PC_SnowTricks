<?php

namespace App\Controller\Admin;


use App\Entity\Image;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTrickController extends AbstractController
{
	/**
	 * @var TrickRepository
	 */
	private TrickRepository $repository;

	public function __construct(TrickRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @Route("/admin", name="admin.trick.index")
	 *
	 * @param TrickRepository $repository
	 *
	 * @return Response
	 */
	public function index(TrickRepository $repository)
	{
		$trick = $repository->findAll();
		return $this->render('admin/trick/index.html.twig', [
			'tricks' => $trick
		]);
	}

	/**
	 * @Route ("/admin/creer-figure", name="admin.trick.new")
	 * @param Request $request
	 *
	 * @param ImageUploader $image_uploader
	 *
	 * @return RedirectResponse|Response
	 */
	public function new(Request $request, ImageUploader $image_uploader)
	{
		$trick = new Trick();
		$image = new Image();
		$form = $this->createForm(TrickType::class, $trick);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){

			$imageFile = $form->get('image')->getData();

			if ($imageFile){
				$imageFilename = $image_uploader->upload($imageFile);
				$trick->addImage($image->setImageName($imageFilename));
			}

			$manager = $this->getDoctrine()->getManager();
			$trick->setUser( $this->getUser());
			$manager->persist($trick);
			$manager->flush();
			return $this->redirectToRoute('admin.trick.index');
		}

		return $this->render('admin/trick/new.html.twig', [
			'trick' => $trick,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/admin/modifier-figure/{id}", name="admin.trick.edit")
	 * @param Trick $trick
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function edit(Trick $trick, Request $request)
	{
		$form = $this->createForm(TrickType::class, $trick);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$manager = $this->getDoctrine()->getManager();
			$manager->flush();
			return $this->redirectToRoute('admin.trick.index');
		}

		return $this->render('admin/trick/edit.html.twig', [
			'trick' => $trick,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route ("/admin/delete/{id}", name="admin.trick.delete")
	 *
	 * @param Trick $trick
	 *
	 * @return RedirectResponse
	 */
	public function delete(Trick $trick)
	{
		$manager = $this->getDoctrine()->getManager();
		$manager->remove($trick);
		$manager->flush();

		return $this->redirectToRoute('admin.trick.index');
	}
}
