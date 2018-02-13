<?php

namespace AppBundle\Form;

use AppBundle\Entity\Article;
use AppBundle\Entity\Menu;
use AppBundle\Service\ArticleService;
use AppBundle\Service\MenuService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleType extends AbstractType
{
    /**
     * @var ArticleService
     */
    private $articleService;
    /**
     * @var MenuService
     */
    private $menuService;

    public function __construct(ArticleService $articleService, MenuService $menuService)
    {
        $this->articleService = $articleService;
        $this->menuService = $menuService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('publishedAt', DateTimeType::class)
            ->add('menu', EntityType::class, [
                "class" => Menu::class,
                "placeholder" => "Selectionnez le menu",
                "choices" => $this->menuService->getAll(),
                "choice_label" => "title"
            ])
            ->add("articles", EntityType::class, [
                "class" => Article::class,
                "placeholder" => "Choisissez les articles associés",
                "choices" => $this->articleService->getAllArticles(),
                "choice_label" => "title",
                "multiple" => true,
                "required" => false
            ])
            ->add("image", FileType::class, ["required"=>false])
            ->add("published", ChoiceType::class, [
                "choices" => ['yes' => 1,'no' => 0],
                "label" => "est-il publié ?"
            ]);
    }
}