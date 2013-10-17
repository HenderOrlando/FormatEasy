<?php

namespace FormatEasy\FormatosBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use FormatEasy\FormatosBundle\Entity\Formato;

class FormatoToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (formato) to a string (id).
     *
     * @param  Formato|null $formato
     * @return string
     */
    public function transform($formato)
    {
        if (null === $formato) {
            return "";
        }

        return $formato->getId();
    }

    /**
     * Transforms a string (id) to an object (formato).
     *
     * @param  string $id
     *
     * @return Formato|null
     *
     * @throws TransformationFailedException if object (formato) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $formato = $this->om
            ->getRepository('FormatEasyFormatosBundle:Formato')
            ->findOneBy(array('id' => $id))
        ;

        if (null === $formato) {
            throw new TransformationFailedException(sprintf(
                'An formato with id "%s" does not exist!',
                $id
            ));
        }

        return $formato;
    }

}