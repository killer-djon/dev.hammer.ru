<?php
namespace StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="pages")
 */
class Pages
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $pagetitle;
    
    /**
     * @MongoDB\String
     */
    protected $pagealias;


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
     * Set pagetitle
     *
     * @param string $pagetitle
     * @return self
     */
    public function setPagetitle($pagetitle)
    {
        $this->pagetitle = $pagetitle;
        return $this;
    }

    /**
     * Get pagetitle
     *
     * @return string $pagetitle
     */
    public function getPagetitle()
    {
        return $this->pagetitle;
    }

    /**
     * Set pagealias
     *
     * @param string $pagealias
     * @return self
     */
    public function setPagealias($pagealias)
    {
        $this->pagealias = $pagealias;
        return $this;
    }

    /**
     * Get pagealias
     *
     * @return string $pagealias
     */
    public function getPagealias()
    {
        return $this->pagealias;
    }
}
