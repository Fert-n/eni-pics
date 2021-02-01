<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TagRepository;

class TagController extends AbstractController
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * TagController constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Affiche le détail d'une photo
     * @Route("/tags/{id}", name="tag_picture")
     */
    public function tags(int $id): Response
    {
        //récupère les tags
        $tag = $this->tagRepository->find($id);

        return $this->render('tag/tag.html.twig', [
            'tag' => $tag
        ]);
    }
}
