<?php
declare(strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Sorting;

use Lemuria\Model\Fantasya\Commodity\Camel;
use Lemuria\Model\Fantasya\Commodity\Carriage;
use Lemuria\Model\Fantasya\Commodity\Herb\Bugleweed;
use Lemuria\Model\Fantasya\Commodity\Luxury\Gem;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Weapon\Sword;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Quantity;
use Lemuria\Model\Fantasya\Resources;
use Lemuria\Model\Fantasya\Sorting\ByCommodity;
use Lemuria\Tests\Model\Fantasya\Model;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;

class ByCommodityTest extends Model
{
	use BuilderTrait;

	protected const array RESOURCES = [Camel::class => 1, Bugleweed::class => 3, Silver::class => 123, Sword::class => 1, Gem::class => 5, Carriage::class => 1];

	protected const array SORTED = [Silver::class, Carriage::class, Sword::class, Camel::class, Gem::class, Bugleweed::class];

	#[Test]
	public function construct(): ByCommodity {
		$sort = new ByCommodity();

		$this->pass();

		return $sort;
	}

	#[Test]
	#[Depends('construct')]
	public function sort(ByCommodity $sort) {
		$resources = $this->resources();
		$keys      = $sort->sort($resources);

		$this->assertArray($keys, count(self::SORTED), 'string');
	}

	protected function resources(): Resources {
		$this->assertSame(count(self::SORTED), count(self::RESOURCES));

		$resources = new Resources();
		foreach (self::RESOURCES as $commodity => $count) {
			$resources->add(new Quantity(self::createCommodity($commodity), $count));
		}

		$this->assertSame(count(self::RESOURCES), $resources->count());

		return $resources;
	}
}
