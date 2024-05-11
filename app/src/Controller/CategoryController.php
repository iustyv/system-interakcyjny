<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\TaskRepository;
use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route('/{id}', name: 'category_show', methods: 'GET')]
    public function show(Category $category): Response
    {
        $tasks = $this->taskRepository->findTasksByCategory($category);

        return $this->render('category/show.html.twig', ['category' => $category, 'tasks' => $tasks]);
    }
}
