<?php

/*
 * This file is part of the Keygen package.
 *
 * (c) Glad Chinda <gladxeqs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace System\Keygen\Generators;

use System\Keygen\Generator;

class AlphaNumericGenerator extends Generator
{
	/**
     * Generates a random key.
     *
     * @param numeric $length
     */
    protected function keygen($length): string
	{
		$key = '';
		$chars = array_merge(range(0, 9), range('a', 'z'), range(0, 9), range('A', 'Z'), range(0, 9));
		shuffle($chars);

		$chars = str_shuffle(str_rot13(implode('', $chars)));
		$split = ceil($length / 5);
		$size = strlen($chars);

		$splitSize = ceil($size / $split);
		$chunkSize = $splitSize + mt_rand(1, 5);
		$chunkArray = [];

		while ($split != 0) {
			$strip = substr($chars, mt_rand(0, $size - $chunkSize), $chunkSize);
			$chunkArray[] = strrev($strip);
			$split--;
		}

		foreach ($chunkArray as $set) {
			$adjust = ((($length - strlen($key)) % 5) == 0) ? 5 : ($length - strlen($key)) % 5;
			$setSize = strlen($set);
			$key .= substr($set, mt_rand(0, $setSize - $adjust), $adjust);
		}
		
		return str_rot13(str_shuffle($key));
	}
}
