<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Commodity\Herb\CobaltFungus;
use Lemuria\Model\Fantasya\Commodity\Herb\Elvendear;
use Lemuria\Model\Fantasya\Commodity\Herb\SpiderIvy;

/**
 * A forest is a plain with many trees.
 */
final class Forest extends Plain
{
	public final const int TREES = 600;

	/**
	 * @type array<string>
	 */
	private const array HERBS = [CobaltFungus::class, Elvendear::class, SpiderIvy::class];

	private static ?array $herbs = null;

	public function Herbs(): array {
		if (!self::$herbs) {
			self::$herbs = $this->createHerbs(self::HERBS);
		}
		return self::$herbs;
	}
}
