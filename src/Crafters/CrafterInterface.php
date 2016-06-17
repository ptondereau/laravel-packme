<?php

namespace Ptondereau\PackMe\Crafters;

/**
 * Interface Crafter.
 */
interface CrafterInterface
{
    /**
     * Craft the application with parameters.
     *
     * @return mixed
     */
    public function craft();

    /**
     * @param null|string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @param null|array $author
     *
     * @return $this
     */
    public function setAuthor(array $author);

    /**
     * @param string $destination
     *
     * @return $this
     */
    public function setDestination($destination);

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description);
}
