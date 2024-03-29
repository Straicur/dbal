<?php

/**
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This file is part of nulldark/dbal
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Nulldark\DBAL;

use Nulldark\Stdlib\Collections\Collection;
use Nulldark\Stdlib\Collections\CollectionInterface;

/**
 * @author Dominik Szamburski
 * @package Nulldark\DBAL
 * @license LGPL-2.1
 * @version 0.5.0
 */
final class Result
{
    public function __construct(
        private readonly \PDOStatement $stmt
    ) {
    }

    /**
     * Returns the next row from a result set as a numeric array or `FALSE` if there are no more rows.
     *
     * @return list<mixed>|false
     */
    public function fetchNumeric(): array|false
    {
        return $this->fetch(FetchMode::NUMERIC);
    }

    /**
     * Returns the next row from a result set as an associative array or `FALSE` if there are no more rows.
     *
     * @return array<string, list<mixed>>|false
     */
    public function fetchAssociative(): array|false
    {
        return $this->fetch(FetchMode::ASSOC);
    }

    /**
     *  Returns the next row from a result set as an object or `FALSE` if there are no more rows.
     *
     * @return object|false
     */
    public function fetchObject(): object|false
    {
        return $this->fetch(FetchMode::OBJECT);
    }

    /**
     * Returns the first value of the next row of the result or `FALSE` if there are no more rows.
     *
     * @return list<mixed>|false
     */
    public function fetchOne(): array|false
    {
        return $this->fetch(FetchMode::COLUMN);
    }

    /**
     * Returns a collection containing all the result rows represented as numeric arrays.
     *
     * @return \Nulldark\Stdlib\Collections\CollectionInterface
     */
    public function fetchAllNumeric(): CollectionInterface
    {
        return $this->fetchAll(FetchMode::NUMERIC);
    }

    /**
     *  Returns a collection containing all the result rows represented as associative arrays.
     *
     * @return \Nulldark\Stdlib\Collections\CollectionInterface
     */
    public function fetchAllAssociative(): CollectionInterface
    {
        return $this->fetchAll(FetchMode::ASSOC);
    }

    /**
     * Returns a collection containing all the result rows represented as objects.
     *
     * @return \Nulldark\Stdlib\Collections\CollectionInterface
     */
    public function fetchAllObject(): CollectionInterface
    {
        return $this->fetchAll(FetchMode::OBJECT);
    }

    /**
     * Returns a collection containing the values of the first column of the result.
     *
     * @return \Nulldark\Stdlib\Collections\CollectionInterface
     */
    public function fetchFirstColumn(): CollectionInterface
    {
        return $this->fetchAll(FetchMode::COLUMN);
    }

    /**
     * Returns the number of rows affected by the last SQL statement.
     *
     * @return int
     */
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    /**
     * Returns the number of columns in the result set
     *
     * @return int
     */
    public function columnCount(): int
    {
        return $this->stmt->columnCount();
    }

    /**
     * @param \Nulldark\DBAL\FetchMode $mode
     * @return mixed
     */
    private function fetch(FetchMode $mode): mixed
    {
        return $this->stmt->fetch($mode->value);
    }

    /**
     * @param \Nulldark\DBAL\FetchMode $mode
     * @return \Nulldark\Stdlib\Collections\CollectionInterface
     */
    private function fetchAll(FetchMode $mode): CollectionInterface
    {
        return new Collection(
            $this->stmt->fetchAll($mode->value)
        );
    }
}
