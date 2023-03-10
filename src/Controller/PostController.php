<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /*
    #[Route('/post/{id}', name: 'app_post')]
    public function index(Post $post): Response
    {

        dump($post);
        
        return $this->render('post/index.html.twig', [
            'controller_name' => ['saludo' => '¡Hola mundo!', 'nombre' => 'Fran'],
            'post' => $post
        ]);
    }
    */

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/posts/', name: 'app_posts')]
    public function indexAll(): Response
    {

        //$posts = $this->em->getRepository(Post::class)->findAll();
        $posts = $this->em->getRepository(Post::class)->findBy(['id' => 1, 'title' => 'mi primer post de prueba']);
        return $this->render('post/indexAll.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/post/{id}', name: 'app_post')]
    public function index($id): Response
    {

        //$post = $this->em->getRepository(Post::class)->find($id);
        $post = $this->em->getRepository(Post::class)->findOneBy(['id' => $id]);
        return $this->render('post/index.html.twig', [
            'post' => $post
        ]);
    }

}
