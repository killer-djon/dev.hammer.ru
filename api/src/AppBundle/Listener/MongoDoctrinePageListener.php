<?php
namespace AppBundle\Listener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use StorageBundle\Document\Pages;

class MongoDoctrinePageListener
{
    
    /**
	 * After document was load
	 *
	 * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        // post load document
        $document = $eventArgs->getDocument();
    }
    
    /**
	 * Preload document
	 * this document will be empty before load
	 *
	 * @param LifecycleEventArgs $eventArgs
     */
    public function preLoad(LifecycleEventArgs $eventArgs)
    {
    }
    
}