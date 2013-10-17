<?php

namespace FormatEasy\PlantillasBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta;

class PlantillaRespuestaToIdTransformer implements DataTransformerInterface
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
     * Transforms an object (plantillaFormato) to a string (id).
     *
     * @param  PlantillaRespuesta|null $plantillaFormato
     * @return integer
     */
    public function transform($plantillaFormato)
    {
        if (null === $plantillaFormato) {
            return "";
        }

        return $plantillaFormato->getId();
    }

    /**
     * Transforms a string (id) to an object (plantillaFormato).
     *
     * @param  string $id
     *
     * @return PlantillaRespuesta|null
     *
     * @throws TransformationFailedException if object (plantillaFormato) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $plantillaFormato = $this->om
            ->getRepository('FormatEasyPlantillasBundle:PlantillaRespuesta')
            ->findOneBy(array('id' => $id))
        ;

        if (null === $plantillaFormato) {
            throw new TransformationFailedException(sprintf(
                'An plantillaFormato with id "%s" does not exist!',
                $id
            ));
        }

        return $plantillaFormato;
    }

}