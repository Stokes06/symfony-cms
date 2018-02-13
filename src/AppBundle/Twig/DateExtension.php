<?php
namespace AppBundle\Twig;

class DateExtension extends \Twig_Extension{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('dateDiff', array($this,'dateDiffFilter')),
        );
    }
    //Calcul le temps entre la date et aujourd'hui
    public function dateDiffFilter(\DateTime $date){
        // interval : intervalle de temps entre aujourd'hui et la date qu'on a dans le twig
        $now = new \DateTime("now");
        $interval = $date->diff($now);

       if($interval->y > 0){
           return $interval->format("depuis %y années et %m mois");
       }else if($interval->m > 0){
           return $interval->format("depuis %m mois et %d jours");
       }else if($interval->d >= 2 || $interval->d ==1 && $date->format("H") > $now->format("H")){
           return $interval->format("depuis %d jours et %h heures");
       }else if($interval->d ===1 && $date->format("H") <= $now->format("H")
       || $interval->d===0 && $date->format("H") > $now->format("H")) {
           return $interval->format("depuis hier");
       }else{
           return $interval->format("depuis %h heures et %i minutes");
       }

    }
}