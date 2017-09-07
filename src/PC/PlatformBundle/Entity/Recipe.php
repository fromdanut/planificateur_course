<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use PC\PlatformBundle\Validator\Antiflood;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="PC\PlatformBundle\Repository\RecipeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="name", message="Une recette existe déjà avec ce nom.")
 */
class Recipe
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=True)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="cooking_time", type="integer", options={"unsigned"=true})
     * @Assert\Range(min=0)
     */
    private $cookingTime;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_personne", type="integer", options={"unsigned"=true})
     * @Assert\Range(min=1)
     */
    private $nbPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="long_description", type="text")
     * @Assert\Length(min=100, max=7000)
     */
    private $longDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="string", length=255)
     * @Assert\Length(max=500)
     */
    private $shortDescription;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     * @Assert\Range(min=1, max=5)
     */
    private $rating;


    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=5)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="calorie", type="integer")
     */
    private $calorie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\OneToOne(targetEntity="PC\PlatformBundle\Entity\Image", cascade={"persist"})
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="PC\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="pc_recipe_category")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="PC\PlatformBundle\Entity\RecipeIngredient", mappedBy="recipe", cascade={"persist"}, orphanRemoval=true)
     */
    private $recipeIngredients;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $user;

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
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cookingTime
     *
     * @param integer $cookingTime
     *
     * @return Recipe
     */
    public function setCookingTime($cookingTime)
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * Get cookingTime
     *
     * @return int
     */
    public function getCookingTime()
    {
        return $this->cookingTime;
    }

    /**
     * Set longDescription
     *
     * @param string $longDescription
     *
     * @return Recipe
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Get longDescription
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Recipe
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {   
        return $this->shortDescription;
    }

    /**
     * Set image
     *
     * @param \PC\PlatformBundle\Entity\Image $image
     *
     * @return Recipe
     */
    public function setImage(\PC\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \PC\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Recipe
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datePublication = new \DateTime();
        $this->recipeIngredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \PC\PlatformBundle\Entity\Category $category
     *
     * @return Recipe
     */
    public function addCategory(\PC\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \PC\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(\PC\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Recipe
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }


    /**
     * Add recipeIngredient
     *
     * @param \PC\PlatformBundle\Entity\RecipeIngredient $recipeIngredient
     *
     * @return Recipe
     */
    public function addRecipeIngredient(\PC\PlatformBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredients[] = $recipeIngredient;

        $recipeIngredient->setRecipe($this);

        return $this;
    }

    /**
     * Remove recipeIngredient
     *
     * @param \PC\PlatformBundle\Entity\RecipeIngredient $recipeIngredient
     */
    public function removeRecipeIngredient(\PC\PlatformBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredients->removeElement($recipeIngredient);
    }

    /**
     * Get recipeIngredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipeIngredients()
    {
        return $this->recipeIngredients;
    }

    /*
        Retourne le prix global d'une recette en fonction de ses recipeIngredients.
    */

    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param $price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }


    /**
     * @ORM\PreFlush
     */
    public function computePrice()
    {
        $price = 0;

        foreach ($this->getRecipeIngredients() as $recipeIngredient) {
            $price += ( $recipeIngredient->getIngredient()->getPrice() * $recipeIngredient->getQuantity() );
        }

        $this->setPrice($price);
    }

    /**
     * Set calorie
     *
     * @param \bollean $calorie
     *
     * @return Recipe
     */
    public function setCalorie($calorie)
    {
        $this->calorie = $calorie;

        return $this;
    }

    /**
     * Get calorie
     *
     * @return \bollean
     */
    public function getCalorie()
    {
        return $this->calorie;
    }

    /**
     * @ORM\PreFlush
     */
    public function computeCalorie()
    {
        $calorie = 0;

        foreach ($this->getRecipeIngredients() as $recipeIngredient) {
            $calorie += ( $recipeIngredient->getIngredient()->getCalorie() * $recipeIngredient->getQuantity() );
        }

        // Calories per person.
        $calorie = ceil($calorie / $this->getNbPerson());

        $this->setCalorie($calorie);
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Recipe
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set nbPerson
     *
     * @param integer $nbPerson
     *
     * @return Recipe
     */
    public function setNbPerson($nbPerson)
    {
        $this->nbPerson = $nbPerson;

        return $this;
    }

    /**
     * Get nbPerson
     *
     * @return integer
     */
    public function getNbPerson()
    {
        return $this->nbPerson;
    }
}
