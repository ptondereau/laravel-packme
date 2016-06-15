<?php

namespace Ptondereau\PackMe\Crafters;

/**
 * Interface Crafter
 *
 * @package Ptondereau\PackMe\Crafters
 */
interface Crafter
{
    /**
     * Craft the application with parameters.
     * 
     * @return mixed
     */
    public function craft();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor($author);

    /**
     * @param string $destination
     * @return $this
     */
    public function setDestination($destination);

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);
}