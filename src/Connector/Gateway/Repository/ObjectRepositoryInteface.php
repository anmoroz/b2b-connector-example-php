<?php
/**
 * Author: Andrey Morozov
 * Date: 26.07.2016
 */

namespace Connector\Gateway\Repository;

interface ObjectRepositoryInteface
{
    /**
     * Finds an objects in the repository.
     *
     * @return \Generator
     */
    public function iterate();

    /**
     * Returns the class name of the object managed by the repository.
     *
     * @return string
     */
    public function getClassName();
}