<?php
/**
 * This file is part of GameQ.
 *
 * GameQ is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * GameQ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace GameQ;

/**
 * Provide an interface for easy storage of a parsed server response
 *
 * @author    Aidan Lister   <aidan@php.net>
 * @author    Tom Buskens    <t.buskens@deviation.nl>
 */
class Result
{

    /**
     * Formatted server response
     *
     * @var        array
     */
    protected $result = [];

    /**
     * Adds variable to results
     *
     * @param      string $name  Variable name
     * @param      string $value Variable value
     */
    public function add($name, $value): void
    {

        $this->result[$name] = $value;
    }

    /**
     * Adds player variable to output
     *
     * @param       string $name  Variable name
     * @param       string $value Variable value
     */
    public function addPlayer($name, $value): void
    {

        $this->addSub('players', $name, $value);
    }

    /**
     * Adds player variable to output
     *
     * @param       string $name  Variable name
     * @param       string $value Variable value
     */
    public function addTeam($name, $value): void
    {

        $this->addSub('teams', $name, $value);
    }

    /**
     * Add a variable to a category
     *
     * @param  $sub    string  The category
     * @param  $key    string  The variable name
     * @param  $value  string  The variable value
     */
    public function addSub($sub, $key, $value): void
    {

        // Nothing of this type yet, set an empty array
        if (!isset($this->result[$sub]) || !is_array($this->result[$sub])) {
            $this->result[$sub] = [];
        }

        // Find the first entry that doesn't have this variable
        $found = false;
        for ($i = 0; $i !== count($this->result[$sub]); $i++) {
            if (!isset($this->result[$sub][$i][$key])) {
                $this->result[$sub][$i][$key] = $value;
                $found = true;
                break;
            }
        }

        // Not found, create a new entry
        if (!$found) {
            $this->result[$sub][][$key] = $value;
        }
    }

    /**
     * Return all stored results
     *
     * @return  array  All results
     */
    public function fetch()
    {

        return $this->result;
    }

    /**
     * Return a single variable
     *
     * @param   string $var The variable name
     *
     * @return  mixed   The variable value
     */
    public function get($var)
    {

        return $this->result[$var] ?? null;
    }
}
