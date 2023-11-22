<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Storage\Migration\Region;

class RegionTest extends Migration
{
	/**
	 * @type array<string, mixed>
	 */
	public final const array DATA = [
		'id'          => 54,
		'name'        => 'Schattental',
		'description' => '',
		'landscape'   => 'Plain',
		'roads'       => null,
		'herbage'     => null,
		'resources'   => [],
		'estate'      => [],
		'fleet'       => [],
		'residents'   => [],
		'luxuries'    => null,
		'treasury'    => []
	];

	#[Before]
	protected function initIndex(): void {
		$this->index = $this->getIndices(self::DATA);
	}

	#[Test]
	public function construct(): Region {
		$unit = new Region();

		$this->assertNotNull($unit);

		return $unit;
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultLuxuries(Region $region): void {
		$this->assertNull($region->getDefault('luxuries'));
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultTreasury(Region $region): void {
		$this->assertSame([], $region->getDefault('treasury'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
