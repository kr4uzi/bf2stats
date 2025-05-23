<?php

/*
 * This file is part of the Keygen package.
 *
 * (c) Glad Chinda <gladxeqs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace System\Keygen;

use InvalidArgumentException;

/**
 * @method static Generator token(\int $length)
 * @method static Generator numeric(\int $length)
 * @method static Generator alphanum(\int $length)
 * @method static Generator bytes(\int $length)
 */
class Keygen extends AbstractGenerator
{
	/**
     * Creates a new generator instance of the given type.
     *
     * @param string $type Generator type
     * @param mixed $length
     * @return Generator
     *
     * @throws InvalidArgumentException
     */
    protected function newGenerator($type, $length = null)
	{
		$generator = GeneratorFactory::create($type)->mutate($this)->length($length ?: $this->length);

		if ($this->prefix !== null) {
			$generator->prefix($this->prefix);
		}

		if ($this->suffix !== null) {
			$generator->suffix($this->suffix);
		}

		return $generator;
	}

	/**
     * Creates a new generator instance from the given alias.
     *
     * @param string $alias Generator type alias
     * @param mixed $length
     * @return Generator | null
     *
     * @throws InvalidArgumentException
     */
    protected function newGeneratorFromAlias($alias, $length = null)
	{
		$generatorAliases = [
			'numeric' => 'numeric',
			'alphanum' => 'alphaNumeric',
			'token' => 'token',
			'bytes' => 'randomByte'
		];

		if (array_key_exists($alias, $generatorAliases)) {
			return $this->newGenerator($generatorAliases[$alias], $length);
		}

		return null;
	}

	/**
	 * Overload the __call method
	 */
	public function __call($method, $args)
	{
		$_method = strtolower((string) $method);
		$generator = $this->newGeneratorFromAlias($_method, $args[0] ?? null);

		if ($generator instanceof Generator) {
			return $generator;
		}

		return parent::__call($method, $args);
	}
}
