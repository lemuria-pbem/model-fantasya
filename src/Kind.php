<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

enum Kind
{
	case Animal;

	case Herb;

	case Luxury;

	case Material;

	case Potion;

	case Protection;

	case Shield;

	case Transport;

	case Trophy;

	case Weapon;

	public static function forCommodity(Commodity $commodity): ?self {
		return match(true) {
			$commodity instanceof Animal     => self::Animal,
			$commodity instanceof Herb       => self::Herb,
			$commodity instanceof Luxury     => self::Luxury,
			$commodity instanceof Material   => self::Material,
			$commodity instanceof Potion     => self::Potion,
			$commodity instanceof Shield     => self::Shield,
			$commodity instanceof Protection => self::Protection,
			$commodity instanceof Transport  => self::Transport,
			$commodity instanceof Trophy     => self::Trophy,
			$commodity instanceof Weapon     => self::Weapon,
			default                          => null
		};
	}
}
