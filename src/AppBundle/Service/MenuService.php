<?php
namespace AppBundle\Service;
use AppBundle\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

class MenuService{

    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function getAll(){
        return $this->em->getRepository("AppBundle:Menu")->findAll();
    }
    public function getAllExcept($id){
      return $this->em->createQuery("SELECT m from AppBundle\Entity\Menu m where m.id != :id")
                    ->setParameter("id", $id)
                    ->execute();
    }
    public function create(Menu $menu){
        $this->em->persist($menu);
        $this->em->flush();
        $parent = $menu->getParent();
        if($parent){
            $parent->addChild($menu);
            $this->em->persist($parent);
            $this->em->flush();
        }
    }

    public function getById($id)
    {
        return $this->em->getRepository("AppBundle:Menu")->find($id);
    }

    public function delete(Menu $menu)
    {
        $this->em->remove($menu);
        $this->em->flush();
    }
}