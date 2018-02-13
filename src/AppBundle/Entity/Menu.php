<?php
/**
 * Created by PhpStorm.
 * User: HB1
 * Date: 06/02/2018
 * Time: 17:09
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Menu
{
    /**
     * @var int $id
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var string $title
     * @ORM\Column(type="string")
     */
    protected $title;
    /**
     * @var Menu $parent
     * @ORM\ManyToOne(inversedBy="children", targetEntity="AppBundle\Entity\Menu")
     */
    protected $parent;
    /**
     * @var Menu[] $children
     * @ORM\OneToMany(mappedBy="parent", targetEntity="AppBundle\Entity\Menu")
     */
    protected $children;

    /**
     * Constructor
     */
    public function __construct($nom=null)
    {
        $this->title = $nom;
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Menu
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set parent
     *
     * @param Menu $parent
     *
     * @return Menu
     */
    public function setParent(Menu $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Menu $child
     *
     * @return Menu
     */
    public function addChild(\AppBundle\Entity\Menu $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Menu $child
     */
    public function removeChild(\AppBundle\Entity\Menu $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
    public function __toString()
    {
        return $this->title;
    }
}
