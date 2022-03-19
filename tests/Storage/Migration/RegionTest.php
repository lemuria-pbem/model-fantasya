<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Region;

class RegionTest extends BaseMigrationTest
{
	public final const DATA = [
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
		'luxuries'    => null
	];

	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(self::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Region {
		$unit = new Region();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultLuxuries(Region $region): void {
		$this->assertNull($region->getDefault('luxuries'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
