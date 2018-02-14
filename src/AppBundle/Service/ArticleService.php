<?php

namespace AppBundle\Service;

use AppBundle\Entity\Article;
use AppBundle\Entity\Menu;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class ArticleService
{

    protected $em;
    private $container;
    private $fs;


    public function __construct(EntityManagerInterface $em, ContainerInterface $container, Filesystem $fs)
    {
        $this->em = $em;
        $this->container = $container;
        $this->fs = $fs;
    }

    /**
     * @return Article[]
     */
    public function getAllArticles()
    {
        return $this->em->getRepository("AppBundle:Article")->findBy([],["publishedAt"=>"Desc"]);
    }

    public function getPublishedArticles(){
        return $this->em->createQuery("select a from AppBundle\Entity\Article a where a.published = true")
            ->getResult();
    }
    public function getPublishedArticlesByMenuId($idMenu){
        return $this->em->createQuery("select a from AppBundle\Entity\Article a join a.menu m  where a.published = TRUE 
        and m.id = :id")
            ->setParameter("id", $idMenu)
            ->execute();

    }
    public function getById($id)
    {
        return $this->em->getRepository("AppBundle:Article")->find($id);
    }
    public function create(Article $article){
        $this->em->persist($article);
        $this->em->flush();
        //Non symétrique
    }

    public function removeArticleById($id)
    {
        $article = $this->em->getRepository("AppBundle:Article")->find($id);
        $fileName = $article->getImage();
        if($this->fs->exists($this->container->getParameter('image_directory')."/".$fileName))
            $this->fs->remove($this->container->getParameter('image_directory')."/".$fileName);
        $this->em->remove($article);
        $this->em->flush();
    }
}