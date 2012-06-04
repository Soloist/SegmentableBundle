<?php

namespace Soloist\Bundle\SegmentableBundle\EventListener;

use Gedmo\Mapping\MappedEventSubscriber;
use Doctrine\Common\EventArgs;

class SegmentableListener extends MappedEventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    function getSubscribedEvents()
    {
        return array(
            'loadClassMetadata'
        );
    }

    public function loadClassMetadata(EventArgs $args)
    {
        // this will check for our metadata
        $this->loadMetadataForObjectClass(
            $args->getEntityManager(),
            $args->getClassMetadata()
        );
    }

    /**
     * Get the namespace of extension event subscriber.
     * used for cache id of extensions also to know where
     * to find Mapping drivers and event adapters
     *
     * @return string
     */
    protected function getNamespace()
    {
        return 'Soloist\Bundle\SegmentableBundle';
    }
}
