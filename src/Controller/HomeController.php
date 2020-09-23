<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	/**
	 * @Route ("/", name="home")
	 * @param TrickRepository $repository
	 *
	 * @return Response
	 */
   public function index(TrickRepository $repository): Response
    {
    	$numberTricksPagination = 9;
    	$tricks = $repository->trickPagination(0, $numberTricksPagination);
    	$tricksTotal = $repository->numberTotalTricks();

        return $this->render('pages/home.html.twig', [
        	'tricks' => $tricks,
	        'tricksTotal' => $tricksTotal,
	        'numberTricksPagination' => $numberTricksPagination
        ]);
    }
}
