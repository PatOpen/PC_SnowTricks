<?php


namespace App\Controller;


use App\Entity\Video;
use App\Form\VideoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
	/**
	 * @Route ("/change-video/{slug}-{id}", name="change.video")
	 * @IsGranted ("ROLE_USER")
	 * @param $slug
	 * @param Video $video
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function changeImage($slug, Video $video, Request $request)
	{
		$form = $this->createForm(VideoType::class, $video);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$videoUrl = $form->get('urlVideo')->getData();
			$videoId = explode('=', $videoUrl);
			$videoName = $videoId[1];

			$video->setUrlVideo($videoName);

			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'La vidéo a bien été ajouté !');
			return $this->redirectToRoute('admin.trick.edit', ['id' => $slug]);
		}

		return $this->render('pages/changeVideo.html.twig', [
			'video' => $video,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/delete-video/{slug}-{id}", name="delete.video")
	 * @IsGranted ("ROLE_USER")
	 * @param $slug
	 *
	 * @param Video $video
	 *
	 * @return RedirectResponse
	 */
	public function deleteImage($slug, Video $video)
	{
		$manager = $this->getDoctrine()->getManager();
		$manager->remove($video);
		$manager->flush();

		$this->addFlash('success', 'La vidéo a bien été supprimé !');

		return $this->redirectToRoute('admin.trick.edit', ['id' => $slug]);
	}


}