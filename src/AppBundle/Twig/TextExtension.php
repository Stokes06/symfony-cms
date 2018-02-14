<?php
namespace AppBundle\Twig;
use AppBundle\Entity\Menu;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;

class TextExtension extends \Twig_Extension{

    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
       return array(
           new \Twig_SimpleFilter("cut", [$this, 'cutFilter']),
           new \Twig_SimpleFilter("nice_url", [$this, 'niceUrlFilter']),
           new \Twig_SimpleFilter("published_label", [$this, 'publishedLabelFilter'], array('is_safe' => array('html'))),
           );
    }
    public function getFunctions()
    {
        $functionAriane = new \Twig_SimpleFunction('filAriane', [$this, 'generateFilArianeFunction'], array('is_safe' => array('html')));
        return array(
            new \Twig_SimpleFunction('isActive', [$this, 'isActiveFunction']),
            $functionAriane
        );
    }

    public function cutFilter(string $text, int $size){
        $depace = strlen($text) > $size;
        $text = substr($text, 0, $size);
        return $text.($depace? "...":null);
    }
    public function niceUrlFilter(string $url){
        return str_replace(' ', '-', $url);
    }

    public function publishedLabelFilter(bool $isPublished){
        if($isPublished)
            return "<span class=\"label label-success\">publié</span>";
        return "<span class=\"label label-danger\">non publié</span>";
    }
    public function isActiveFunction($url){
        return $_SERVER['REQUEST_URI'] == $url ? 'active' : '';
    }

    public function generateFilArianeFunction(Menu $menu){
      return  $this->generateHtmlAriane($menu);
    }
    public function generateHtmlAriane(Menu $menu=null, string $html=null){
        if(!$menu) return $html;
        $add = '<li><a href="'.$this->container->get('router')->generate('articles_by_menu',['id'=>$menu->getId(), 'title'=>$menu->getTitle()]).'">'.$menu->getTitle().'</a></li>';
        return $this->generateHtmlAriane($menu->getParent(), $add.$html);
    }
}
