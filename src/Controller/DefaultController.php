<?php
namespace App\Controller;

//use App\Entity\Article;
//use App\Entity\Category;
//use App\Form\ArticleType;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        return $this->render('lucky/index.html.twig', []);
    }

    /**
     * @Route("/blog", name="blog")
     * @return Response
     */
    public function blog()
    {
        return $this->render('lucky/blog.html.twig', []);
    }

    /**
     * @Route("/news", name="news")
     * @return Response
     */
    public function news()
    {
        return $this->render('lucky/news.html.twig', []);
    }

    /**
     * @Route("/{aaa}/liturgy_singl.html.twig", name="liturgy_singl.html.twig")
     * @param $aaa
     * @return Response
     */
    public function liturgySingl($aaa)
    {
        $result =  $this->render(/** @lang text */ 'lucky/liturgy_singl.html.twig', ['number' => $aaa]);
        $this->addFlash('success', $aaa);

        return $result;
    }

    /**
     * @Route("/liturgy", name="liturgy")
     * @return Response
     */
    public function liturgy()
    {
        return $this->render(/** @lang text */ 'lucky/liturgy.html.twig', []);
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact()
    {
        return $this->render(/** @lang text */ 'lucky/contact.html.twig', []);
    }

    /**
     * @Route(path="/add-article", name="add-article")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function next(EntityManagerInterface $entityManager, Request $request)
    {
        $category = new Category();
        $category->setTitle('aaaaaaa');

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article, ['method' => $request->getMethod()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $entityManager->persist($article);
             $entityManager->flush();
            $this->addFlash('success', 'Done!');
            return $this->redirect('add-article');
        }

        return $this->render('lucky/article_form.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/articles/{id}", name="edit-article")
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    public function editArticle(Article $article, EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(
            ArticleType::class,
            $article,
            ['method' => $request->getMethod()]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Done!');
            return $this->redirectToRoute('edit-article', ['id' => $article->getId() ]);
        }

        return $this->render('lucky/article_form.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/articles/delete/{id}")
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function deleteArticle(Article $article, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return new Response('Deleted');
    }

    /**
     * @Route(path="/list")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function list(EntityManagerInterface $entityManager)
    {
        $articleRepo = $entityManager->getRepository(Article::class);
        $articles = $articleRepo->findAll();

        dd($articleRepo->findByCategoryId(2));

        return new Response('List!');
    }

}