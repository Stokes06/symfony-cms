<?php

namespace AppBundle\Form;

use AppBundle\Entity\Menu;
use AppBundle\Service\MenuService;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    /**
     * @var MenuService
     */
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("title", TextType::class)
            ->add("parent", EntityType::class, [
                "class" => Menu::class,
                "placeholder" => "Selectionnez le menu parent",
                "choices" => $this->menuService->getAllExcept($options['id']),
                "required" => 0
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "id" => 0
        ]);
    }
}