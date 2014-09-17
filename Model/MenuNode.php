<?php

namespace FDevs\MenuBundle\Model;

use FDevs\PageBundle\Model\PublishableTrait;
use FDevs\PageBundle\Model\PublishTimePeriodTrait;
use Symfony\Cmf\Bundle\CoreBundle\Model\ChildInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;

class MenuNode extends MenuNodeBase implements PublishTimePeriodInterface, PublishableInterface, ChildInterface
{
    use PublishableTrait;
    use PublishTimePeriodTrait;

    /** @var MenuNode */
    protected $parent;
    /** @var mixed */
    protected $content;
    /** @var string */
    protected $linkType;

    /**
     * {@inheritDoc}
     */
    public function setParentObject($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getParentObject()
    {
        return $this->parent;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * @param string $linkType
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;
    }

    /**
     * @return MenuNode
     */
    public function getParent()
    {
        return $this->getParentObject();
    }

    /**
     * @param MenuNode $parent
     */
    public function setParent($parent)
    {
        $this->setParentObject($parent);
    }

}
