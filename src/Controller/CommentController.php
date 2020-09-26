<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
	/**
	 * @Route ("/commentaire/modifier/{id}-{slug}", name="edit.comment")
	 * @IsGranted ("IS_AUTHENTICATED_FULLY")
	 * @param Comment $comment
	 * @param string $slug
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function editComment(Comment $comment, string $slug, Request $request)
	{
		$form = $this->createForm(CommentType::class, $comment);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$comment->setModifiedAt(new DateTime('now'));

			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'Votre commentaire a bien été modifié !');

			return $this->redirectToRoute('trick.show', ['slug' => $slug]);
		}

		return $this->render( 'pages/comment-edit.html.twig',[
			'comment' => $comment,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route ("/commentaire/supprimer/{id}-{slug}", name="delete.comment")
	 * @IsGranted ("IS_AUTHENTICATED_FULLY")
	 *
	 * @param Comment $comment
	 *
	 * @param string $slug
	 *
	 * @return RedirectResponse
	 */
	public function deleteComment(Comment $comment, string $slug)
	{
		$manager = $this->getDoctrine()->getManager();
		$manager->remove($comment);
		$manager->flush();

		$this->addFlash('success', 'Le commentaire a bien été supprimé !');

		return $this->redirectToRoute('trick.show', ['slug' => $slug]);
	}

}