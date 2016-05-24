<?php
namespace StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="categories")
 */
class Category
{
	/**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $auto;
    
    /**
     * @MongoDB\String
     */
    protected $name;
    
    /**
     * @MongoDB\String
     */
    protected $link;
    
    /**
     * @MongoDB\String
     */
    protected $param;
    
    /**
     * @MongoDB\String
     */
    protected $parentId;
    
    
    /**
     * @MongoDB\String
     */
    protected $parentName;
    

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set auto
     *
     * @param string $auto
     * @return self
     */
    public function setAuto($auto)
    {
        $this->auto = $auto;
        return $this;
    }

    /**
     * Get auto
     *
     * @return string $auto
     */
    public function getAuto()
    {
        return $this->auto;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Get link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set param
     *
     * @param string $param
     * @return self
     */
    public function setParam($param)
    {
        $this->param = $param;
        return $this;
    }

    /**
     * Get param
     *
     * @return string $param
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Set parentId
     *
     * @param string $parentId
     * @return self
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * Get parentId
     *
     * @return string $parentId
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set parentName
     *
     * @param string $parentName
     * @return self
     */
    public function setParentName($parentName)
    {
        $this->parentName = $parentName;
        return $this;
    }

    /**
     * Get parentName
     *
     * @return string $parentName
     */
    public function getParentName()
    {
        return $this->parentName;
    }
}
