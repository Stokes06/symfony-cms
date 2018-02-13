<?php
namespace AppBundle\Twig;
class TextExtension extends \Twig_Extension{

    public function getFilters()
    {
       return array(new \Twig_SimpleFilter("cut", [$this, 'cutFilter']));
    }
    public function cutFilter(string $text, int $size){
        $depace = strlen($text) > $size;
        $text = substr($text, 0, $size);
        return $text.($depace? "...":null);
    }
}