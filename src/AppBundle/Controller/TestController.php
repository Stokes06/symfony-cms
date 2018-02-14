<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Menu;
use AppBundle\Service\ArticleService;
use AppBundle\Service\MenuService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TestController extends Controller{

    /**
     * @param ArticleService $articleService
     * @Route("/test")
     */
    public function testArticleService(ArticleService $articleService, MenuService $menuService){

        dump(
                "hahaa"
          );
        //Stop pour éviter le no response
        die;
    }
}