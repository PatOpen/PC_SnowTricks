<?php


namespace App\Controller;


use App\Entity\Trick;
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
		return $this->render('pages/trick.html.twig',[
			'trick' => $trick
		]);
	}

}