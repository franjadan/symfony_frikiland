<?php

namespace App\Controller;

use Datetime;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $post = $this->em->getRepository(Post::class)->find($id);
        //$post = $this->em->getRepository(Post::class)->findOneBy(['id' => $id]);

        $custom_post = $this->em->getRepository(Post::class)->findPost($id);


        return $this->render('post/index.html.twig', [
            'post' => $post,
            'custom_post' => $custom_post
        ]);
    }

    /*
    #[Route('/insert/post', name: 'insert_post')]
    public function insert(){
        $post = new Post;
        $user = $this->em->getRepository(User::class)->find(1);

        $post->setTitle('Mi post insertado')
        ->setDescription('Hola mundo')
        ->setCreationDate(new Datetime())
        ->setUrl('mi url')
        ->setFile('Hola mundo')
        ->setType('Opinion')
        ->setUser($user);

        $this->em->persist($post);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    }
    */

    #[Route('/insert/post', name: 'insert_post')]
    public function insert(){
        $post = new Post('Mi post insertado', 'Opinion', 'Hola mundo', 'hola.jpg', null, 'hola_mundo');
        $user = $this->em->getRepository(User::class)->find(1);
        $post->setUser($user);

        $this->em->persist($post);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/update/post', name: 'insert_post')]
    public function update(){
        $post = $this->em->getRepository(Post::class)->find(4);
        $post->setTitle('Mi nuevo titulo');

        //No hace falta porque ya está en la base de datos
        //$this->em->persist($post);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/remove/post', name: 'insert_post')]
    public function remove(){
        $post = $this->em->getRepository(Post::class)->find(4);
        $this->em->remove($post);

        //No hace falta porque ya está en la base de datos
        //$this->em->persist($post);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    }

}
