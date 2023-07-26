<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Party;

use Lemuria\Exception\ParseEnumException;

enum Exploring
{
	case Explore;

	case Land;

	case Depart;

	case Not;

	public static function parse(string $name): Exploring {
		foreach (self::cases() as $case) {
			if ($name === $case->name) {
				return $case;
			}
		}
		throw new ParseEnumException(__CLASS__, $name);
	}
}
