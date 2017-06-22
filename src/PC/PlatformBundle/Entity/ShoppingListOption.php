<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingListOption
 *
 * @ORM\Table(name="shopping_list_option")
 * @ORM\Entity(repositoryClass="PC\PlatformBundle\Repository\ShoppingListOptionRepository")
 */
class ShoppingListOption
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="eco", type="boolean", nullable=true)
     */
    private $eco;

    /**
     * @var bool
     *
     * @ORM\Column(name="quick", type="boolean", nullable=true)
     */
    private $quick;

    /**
     * @var bool
     *
     * @ORM\Column(name="diet", type="boolean", nullable=true)
     */
    private $diet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="PC\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="pc_shoppinglistoption_category")
     */
    private $styles;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->styles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set eco
     *
     * @param boolean $eco
     *
     * @return ShoppingListOption
     */
    public function setEco($eco)
    {
        $this->eco = $eco;

        return $this;
    }

    /**
     * Get eco
     *
     * @return boolean
     */
    public function getEco()
    {
        return $this->eco;
    }

    /**
     * Set quick
     *
     * @param boolean $quick
     *
     * @return ShoppingListOption
     */
    public function setQuick($quick)
    {
        $this->quick = $quick;

        return $this;
    }

    /**
     * Get quick
     *
     * @return boolean
     */
    public function getQuick()
    {
        return $this->quick;
    }

    /**
     * Set diet
     *
     * @param boolean $diet
     *
     * @return ShoppingListOption
     */
    public function setDiet($diet)
    {
        $this->diet = $diet;

        return $this;
    }

    /**
     * Get diet
     *
     * @return boolean
     */
    public function getDiet()
    {
        return $this->diet;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ShoppingListOption
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add style
     *
     * @param \PC\PlatformBundle\Entity\Category $style
     *
     * @return ShoppingListOption
     */
    public function addStyle(\PC\PlatformBundle\Entity\Category $style)
    {
        $this->styles[] = $style;

        return $this;
    }

    /**
     * Remove style
     *
     * @param \PC\PlatformBundle\Entity\Category $style
     */
    public function removeStyle(\PC\PlatformBundle\Entity\Category $style)
    {
        $this->styles->removeElement($style);
    }

    /**
     * Get styles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStyles()
    {
        return $this->styles;
    }
}
