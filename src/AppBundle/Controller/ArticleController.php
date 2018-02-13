<?php
/**
 * Created by PhpStorm.
 * User: HB1
 * Date: 06/02/2018
 * Time: 16:53
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Service\ArticleService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ArticleController extends Controller
{
    /** @var  Article[] $articles */
    protected $articles;

    /**
     * ArticleController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @Route("/")
     */
    public function indexEditorAction(){
        if($this->isGranted("ROLE_EDITOR"))
              return $this->redirectToRoute('handle_articles');
        return $this->redirectToRoute('all_articles');
    }


    /**
     * Gestion des articles par l'éditeur
     * @param ArticleService $articleService
     * @return Response
     */
    public function handleArticlesAction( ArticleService $articleService){
        $articles = $articleService->getAllArticles();
        return $this->render('@App/Admin/Article/all_articles.html.twig', ["articles" => $articles]);
    }

    /**
     * Afficher tous les articles
     * @param ArticleService $articleService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllArticlesAction(Session $session, ArticleService $articleService)
    {
        $lastArticleSeen = $session->get("last_article");
        /*   $loger =  $this->container->get('logger');
           $loger->info("look, i want every articles !");*/
        $articles = $articleService->getPublishedArticles();
        return $this->render('@App/User/all_articles.html.twig', ["articles" => $articles, "lastArticleSeen" => $lastArticleSeen]);
    }

    /**
     * Afficher un article
     * @param ArticleService $articleService
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getArticleAction(Session $session, ArticleService $articleService, $id)
    {
        /** @var Article $article */
        $article = $articleService->getById($id);

        if($this->isGranted("ROLE_EDITOR"))
            return $this->render('@App/Admin/Article/article.html.twig', ["article" => $article]);

        if(!$article->getPublished())
            return $this->render("@App/error404.html.twig");
        $session->set("last_article", $article);

        return $this->render('@App/User/article.html.twig', ["article" => $article]);
    }

    /**
     * Création ou modification d'un article
     * @param Filesystem $fs
     * @param ArticleService $articleService
     * @param Request $request
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newArticleAction(Filesystem $fs, ArticleService $articleService, Request $request, $id = null)
    {
        $article = $id ? $articleService->getById($id) : new Article();
        $fileName = $article->getImage();
        if($fileName)
               $article->setImage(new File($this->getParameter('image_directory').$fileName));

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST") {
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $article->getImage();
                //Supprimer l'ancienne photo
                if($fileName && $file){
                    if($fs->exists($this->getParameter('image_directory').$fileName))
                          $fs->remove($this->getParameter('image_directory').$fileName);
                }
                /** @var File $file */
                //Ajouter la nouvelle photo
                if ($file) {
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                    $file->move(
                        $this->getParameter('image_directory'),
                        $fileName
                    );
                }

                $article->setImage($fileName);
                $articleService->create($article);
                $articleName = $article->getTitle();
                //Ajoute un flash qui sera reçu par la vue
                $this->addFlash($id ? "update" : "create", "l'article $articleName a été ".($id ?  "modifié" : "ajouté"));
                return $this->redirectToRoute('handle_articles');
            }
        }

        return $this->render('@App/Admin/Article/new_article.html.twig', ["form" => $form->createView(), "article"=>$article]);
    }

    /**
     * Suppression d'un article
     * @param Filesystem $fs
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteArticleAction(FileSystem $fs, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AppBundle:Article")->find($id);
        $fileName = $article->getImage();
        if($fs->exists($this->getParameter('image_directory')."/".$fileName))
            $fs->remove($this->getParameter('image_directory')."/".$fileName);
        $em->remove($article);
        $em->flush();
        $this->addFlash("delete", "article supprimé");
        return $this->redirectToRoute("all_articles");
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}