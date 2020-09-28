<?php

namespace App\Controller\Admin;


use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\ImageUploader;
use App\Service\SluggFast;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
	 * @IsGranted("ROLE_ADMIN")
	 *
	 * @Route("/admin", name="admin.trick.index")
	 *
	 *
	 * @return Response
	 */
	public function index()
	{
		$trick = $this->repository->findAll();
		return $this->render('admin/trick/index.html.twig', [
			'tricks' => $trick
		]);
	}

	/**
	 * @IsGranted("ROLE_USER")
	 *
	 * @Route ("/creer-figure", name="trick.new")
	 * @param Request $request
	 *
	 * @param ImageUploader $image_uploader
	 *
	 * @return RedirectResponse|Response
	 */
	public function new(Request $request, ImageUploader $image_uploader)
	{
		$trick = new Trick();
		$video = new Video();
		$image = new Image();

		$form = $this->createForm(TrickType::class, $trick);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$title = $form->get('title')->getData();
			if ($title){
				$trick->setSlug(SluggFast::slugify($title));
			}

			$videoUrl = $form->get('videos')->getData();

			if (empty($videoUrl)){
				$videoId = explode('=', $videoUrl);
				$videoName = $videoId[1];
				$trick->addVideo($video->setUrlVideo($videoName));
			}

			$imageFile = $form->get('image')->getData();

			if ($imageFile){
				$imageFilename = $image_uploader->upload($imageFile);
				$trick->addImage($image->setImageName($imageFilename));
			}
			$trick->setUser( $this->getUser());

			$manager = $this->getDoctrine()->getManager();
			$manager->persist($trick);
			$manager->flush();

			$this->addFlash('success', 'Les modifications ont bien été pris en compte');

			return $this->redirectToRoute('home');
		}

		return $this->render('admin/trick/new.html.twig', [
			'trick' => $trick,
			'form' => $form->createView()
		]);
	}

	/**
	 * @IsGranted("ROLE_USER")
	 *
	 * @Route("/modifier-figure/{slug}", name="trick.edit")
	 *
	 *
	 * @param Trick $trick
	 * @param Request $request
	 * @param ImageUploader $image_uploader
	 *
	 * @return Response
	 */
	public function edit(Trick $trick, Request $request, ImageUploader $image_uploader)
	{
		$video = new Video();
		$image = new Image();
		$slug = $trick->getSlug();

		$form = $this->createForm(TrickType::class, $trick);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$title = $form->get('title')->getData();
			if ($title){
				$slug = SluggFast::slugify($title);
				$trick->setSlug($slug);
			}


			$videoUrl = $form->get('videos')->getData();
			if ($videoUrl){
				$videoId = explode('=', $videoUrl);
				$videoName = $videoId[1];

				$trick->addVideo($video->setUrlVideo($videoName));
			}

			$imageFile = $form->get('image')->getData();

			if ($imageFile){
				$imageFilename = $image_uploader->upload($imageFile);
				$trick->addImage($image->setImageName($imageFilename));
			}
			$trick->setModifiedAt(new DateTime( 'now' ));

			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'Les modifications ont bien été pris en compte !');


			return $this->redirectToRoute('trick.edit', [
				'slug' => $slug
			]);
		}

		return $this->render('admin/trick/edit.html.twig', [
			'trick' => $trick,
			'form' => $form->createView()
		]);
	}


	/**
	 * @IsGranted("ROLE_USER")
	 *
	 * @Route ("/delete/{slug}", name="trick.delete")
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

		return $this->redirectToRoute('home');
	}
}
