<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
	/**
	 * @Route ("/figure/{slug}", name="trick.show")
	 *
	 * @param Trick $trick
	 *
	 * @param Request $request
	 *
	 * @param CommentRepository $repository
	 * @param PaginatorInterface $paginator
	 *
	 * @return Response
	 */
	public function show(Trick $trick, Request $request, CommentRepository $repository, PaginatorInterface $paginator)
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

			return $this->redirectToRoute('trick.show', ['slug' => $trick->getSlug()]);
		}

		$comments = $paginator->paginate(
			$repository->commentsForOneTrick($trick),
			$request->query->getInt('page', 1),
			9
		);


		return $this->render( 'pages/trick-show.html.twig',[
			'trick' => $trick,
			'comments' => $comments,
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