<?php

namespace Hip\AppBundle\Entity;

use Hip\Content\Model\ContentInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="Hip\Content\Repository\ContentRepository")
 * @ORM\Table(name="contents")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "get_content",
 *         parameters={"id" = "expr(object.getId())"}
 *     )
 * )
 */
class Content extends BaseEntity implements ContentInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;


    /**
     * @param $array
     * @return Content
     */
    public static function fromArray($array)
    {
        $model = new self();
        if (array_key_exists('title', $array)) {
            $model->setTitle($array['title']);
        }
        if (array_key_exists('body', $array)) {
            $model->setBody($array['body']);
        }

        return $model;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Content
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Content
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Content
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
}
