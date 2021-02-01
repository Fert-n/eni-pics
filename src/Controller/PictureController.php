<?php

namespace App\Controller;

use App\Form\SearchPictureType;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PictureController extends AbstractController
{
    /**
     * @var PictureRepository
     */
    private $pictureRepository;

    /**
     * PictureController constructor.
     */
    public function __construct(PictureRepository $pictureRepository)
    {
        $this->pictureRepository = $pictureRepository;
    }

    /**
     * Affiche la liste des photos et le formulaire de recherche
     * @Route("/", name="picture_home")
     */
    public function home(Request $request): Response
    {
        //crée une instance du formulaire de recherche (il n'est pas associé à une entité)
        $searchForm = $this->createForm(SearchPictureType::class);

        //récupère les données soumises dans la requête
        $searchForm->handleRequest($request);

        //les données du form sont là (s'il a été soumis)
        $data = $searchForm->getData();
        $orderBy = [];

        if (isset($data['orderBy']) && $data['orderBy'] !== null) {
            $orderBy[$data['orderBy']] = 'DESC';
        }

        $pictures = $this->pictureRepository->findPictureByTagName(
            $data ? (string) $data['keyword'] : null,
            $orderBy
        );

        return $this->render('picture/home.html.twig', [
            'pictures' => $pictures,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * Affiche le détail d'une photo
     * @Route("/details/{id}", name="picture_detail")
     */
    public function detail(int $id): Response
    {
        //récupère la photo dont l'id est dans l'URL
        $picture = $this->pictureRepository->find($id);

        return $this->render('picture/detail.html.twig', [
            'picture' => $picture
        ]);
    }


}
