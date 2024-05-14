<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\TaskRepository;
use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Type\CategoryType;

#[Route('/category')]
class CategoryController extends AbstractController
{
    public function __construct(private readonly CategoryServiceInterface $categoryService, private readonly TaskRepository $taskRepository)
    {}

    #[Route(name: 'category_index', methods: 'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->categoryService->getPaginatedList($page);

        return $this->render('category/index.html.twig', ['pagination' => $pagination]);
    }

    #[Route('/{id}', name: 'category_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    public function show(Category $category): Response
    {
        $tasks = $this->taskRepository->findTasksByCategory($category);

        return $this->render('category/show.html.twig', ['category' => $category, 'tasks' => $tasks]);
    }

    #[Route('/create', name: 'category_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->save($category);

            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            'category/create.html.twig',
            ['form' => $form->createView()]
        );
    }
}
