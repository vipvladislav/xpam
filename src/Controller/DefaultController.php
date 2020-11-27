<?php
namespace App\Controller;

//use App\Entity\Article;
//use App\Entity\Category;
//use App\Form\ArticleType;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * @param ArticleRepository $articleRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function news(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request)
    {
//        $articles = $articleRepository->findAll();
        $queryBuilder = $articleRepository->findArticlesQueryBuilder();

        $articles = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6  /*limit per page*/
        );

        return $this->render('lucky/news.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/sermon_singl.html.twig/{id}", name="sermon_singl")
     * @param Article $article
     * @return Response
     */

    public function sermonSingle(Article $article)
    {
        return $this->render('lucky/sermon_singl.html.twig', [
            'article' => $article
        ]);

    }
//    public function liturgySingl(Article $article, EntityManagerInterface $entityManager, Request $request)
//    {
//        {
////            $result =
//            $this->render(/** @lang text */ 'lucky/sermon_singl.html.twig', ['number' => 'id']);
////            $this->addFlash('success', 'id');
//
//            return $this->redirectToRoute('liturgy_singl', ['id' => $article->getId()]);
////            return $result;
//        }
//    }

    /**
     * @Route("/sermon", name="sermon")
     * @return Response
     */
    public function liturgy()
    {
        return $this->render(/** @lang text */ 'lucky/sermon.html.twig', []);
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
//        $category = new Category();
//        $category->setTitle('aaaaaaa');

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
            return $this->redirectToRoute('edit-article', ['id' => $article->getId()]);
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

//        dd($articleRepo->findByCategoryId(2));

        return new Response('List!');
    }

}