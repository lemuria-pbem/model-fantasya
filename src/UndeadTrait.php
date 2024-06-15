<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Commodity\Monster\Zombie;

trait UndeadTrait
{
	public function getUndead(): Monster {
		return self::createMonster(Zombie::class);
	}
}
