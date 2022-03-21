<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Vessel;

class VesselTest extends BaseMigrationTest
{
	public final const DATA = [
		'id'          => 1,
		'name'        => 'Alpha Primus',
		'description' => 'Die Alpha Primus ist eigentlich nur das Ergebnis eines Testaufbaus von Schiffbauer Jon.',
		'anchor'      => null,
		'port'        => null,
		'ship'        => 'Boat',
		'completion'  => 1.0,
		'passengers'  => []
	];

	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(self::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Vessel {
		$unit = new Vessel();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultPort(Vessel $vessel): void {
		$this->assertNull($vessel->getDefault('port'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
