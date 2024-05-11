<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route(name: 'category_index', methods: 'GET')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->queryAll()->getQuery()->getResult();

        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    #[Route('/{id}', name: 'category_show', methods: 'GET')]
    public function show(Category $category, TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findTasksByCategory($category);

        return $this->render('category/show.html.twig', ['category' => $category, 'tasks' => $tasks]);
    }
}
