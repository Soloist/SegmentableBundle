<?php

namespace Soloist\Bundle\SegmentableBundle\Mapping\Driver;

use Gedmo\Mapping\Driver\AnnotationDriverInterface;

class Annotation implements AnnotationDriverInterface
{
    const SEGMENT = 'Soloist\Bundle\SegmentableBundle\Mapping\Annotation\Segment';

    private $originalDriver;

    /**
     * @var \Doctrine\Common\Annotations\AnnotationReader
     */
    private $reader;

    /**
     * Read extended metadata configuration for
     * a single mapped class
     *
     * @param object $meta
     * @param array  $config
     * @return void
     */
    public function readExtendedMetadata($meta, array &$config)
    {
        $class = $meta->getReflectionClass();

        foreach ($class->getProperties() as $property) {
            // skip inherited properties
            if ($meta->isMappedSuperclass && !$property->isPrivate() ||
                $meta->isInheritedField($property->name) ||
                isset($meta->associationMappings[$property->name]['inherited'])
            ) {
                continue;
            }

            if ($segment = $this->reader->getPropertyAnnotation($property, self::SEGMENT)) {
                $field = $property->getName();
                $meta->mapManyToOne(array(
                    'fieldName'    => $field,
                    'targetEntity' => 'Soloist\Bundle\SegmentableBundle\Entity\Segment',
                    'joinColumns'  => array(
                        array(
                            'name'                 => $field,
                            'referencedColumnName' => 'id',
                            'onDelete'             => 'SET NULL'
                        )
                    )
                ));
                // store the metadata
                $config['segment'][$field] = array();
            }
        }
    }

    /**
     * Passes in the original driver
     *
     * @param $driver
     * @return void
     */
    public function setOriginalDriver($driver)
    {
        $this->originalDriver = $driver;
    }

    /**
     * Set annotation reader class
     * since older doctrine versions do not provide an interface
     * it must provide these methods:
     *     getClassAnnotations([reflectionClass])
     *     getClassAnnotation([reflectionClass], [name])
     *     getPropertyAnnotations([reflectionProperty])
     *     getPropertyAnnotation([reflectionProperty], [name])
     *
     * @param object $reader - annotation reader class
     */
    public function setAnnotationReader($reader)
    {
        $this->reader = $reader;
    }


}
