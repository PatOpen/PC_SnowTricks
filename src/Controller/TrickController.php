<?php


namespace App\Controller;


use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
	/**
	 * @Route ("/figure/{id}", name="trick.show")
	 *
	 * @param Trick $trick
	 *
	 * @return Response
	 */
	public function show(Trick $trick)
	{
		return $this->render( 'pages/trick-show.html.twig',[
			'trick' => $trick
		]);
	}

	/**
	 * @Route ("/load-tricks/{start}", name="load.tricks")
	 *
	 * @param int $start
	 * @param TrickRepository $repository
	 *
	 * @return Response
	 */
	public function loadTricks(int $start, TrickRepository $repository)
	{

		$tricks = $repository->trickPagination($start, 9);
		$tricksTotal = $repository->numberTotalTricks();

		return $this->render('pages/tricks-home.html.twig',[
			'tricks' => $tricks,
			'numberTricksPagination' =>  9,
			'tricksTotal' => $tricksTotal
		]);
	}

}