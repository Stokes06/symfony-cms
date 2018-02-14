<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Menu;
use AppBundle\Form\MenuType;
use AppBundle\Service\MenuService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MenuController extends Controller
{

    public function getAllMenusAction(MenuService $menuService)
    {
        $menus = $menuService->getAll();

        return $this->render('@App/Admin/Menu/all_menus.html.twig', ["menus" => $menus]);
    }

    public function createMenuAction(Request $request, MenuService $menuService, $id = 0)
    {
        $menu = $id>0 ? $menuService->getById($id) : new Menu();
        $form = $this->createForm(MenuType::class, $menu, ['id' => $id]);
        if($_POST){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $menuService->create($menu);
               return $this->redirectToRoute("all_menus");
            }
        }
    return $this->render("@App/Admin/Menu/new_menu.html.twig", ['form' => $form->createView(), 'menu'=>$menu]);
    }

    public function deleteMenuAction(MenuService $menuService, Menu $id){
        $menuService->delete($id);
       return $this->redirectToRoute("all_menus");
    }

}