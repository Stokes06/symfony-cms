<?php

namespace AppBundle\Controller;

use AppBundle\Service\ArticleService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TestController extends Controller{

    /**
     * @param ArticleService $articleService
     * @Route("/test")
     */
    public function testArticleService(ArticleService $articleService){
        //Contenu du test
        dump(
            $articleService->getPublishedArticlesByMenuId(1)
          );
        //Stop pour éviter le no response
        die;
    }
}