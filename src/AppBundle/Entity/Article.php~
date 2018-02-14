<?php
namespace AppBundle\Entity;
use AppBundle\Service\TimestampableEntityMysql;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Article{
    use TimestampableEntityMysql;
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
     * @var User $editor
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $editor;

    /**
     * @var User $author
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $author;
    /**
     * @var  string $content
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;
    /**
     * @var bool $published
     * @ORM\Column(type="boolean", options={"default":0})
     */
    protected $published;
    /**
     * @var  \DateTime $publishedAt
     * @ORM\Column(type="datetime")
     */
    protected $publishedAt;
    /**
     * @var Menu $menu
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Menu", fetch="EAGER")
     */
    protected $menu;
    /**
     * @var string $image
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Article")
     */
    protected $articles = [];
    /**
     * Article constructor.
     * @param string $title
     * @param string $content
     * @param \DateTime $publishedAt
     * @param Menu $menu
     */
    public function __construct($title=null, $content=null, \DateTime $publishedAt=null, Menu $menu=null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->publishedAt = $publishedAt;
        $this->menu = $menu;
        $this->setPublished(false);
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Article
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
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Article
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     *
     * @return Article
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set menu
     *
     * @param \AppBundle\Entity\Menu $menu
     *
     * @return Article
     */
    public function setMenu(Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \AppBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Add article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Article
     */
    public function addArticle(Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \AppBundle\Entity\Article $article
     */
    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->articles->toArray();
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Article
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add editor
     *
     * @param \AppBundle\Entity\User $editor
     *
     * @return Article
     */
    public function addEditor(\AppBundle\Entity\User $editor)
    {
        $this->editor[] = $editor;

        return $this;
    }

    /**
     * Remove editor
     *
     * @param \AppBundle\Entity\User $editor
     */
    public function removeEditor(\AppBundle\Entity\User $editor)
    {
        $this->editor->removeElement($editor);
    }

    /**
     * Get editor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Set editor
     *
     * @param \AppBundle\Entity\User $editor
     *
     * @return Article
     */
    public function setEditor(\AppBundle\Entity\User $editor = null)
    {
        $this->editor = $editor;

        return $this;
    }
}
