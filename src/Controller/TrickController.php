<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
	/**
	 * @Route ("/figure/{id}", name="trick.show")
	 *
	 * @param Trick $trick
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function show(Trick $trick, Request $request)
	{
		$comment = new Comment();

		$form = $this->createForm(CommentType::class, $comment);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){

			$comment->setUser( $this->getUser());
			$trick->addComment($comment);

			$manager = $this->getDoctrine()->getManager();
			$manager->persist($trick);
			$manager->flush();

			$this->addFlash('success', 'Votre commentaire a bien été ajouté !');

			return $this->redirectToRoute('trick.show', ['id' => $trick->getId()]);
		}

		return $this->render( 'pages/trick-show.html.twig',[
			'trick' => $trick,
			'form' => $form->createView()
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