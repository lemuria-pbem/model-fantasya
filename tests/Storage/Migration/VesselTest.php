<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Storage\Migration\Vessel;

class VesselTest extends Migration
{
	/**
	 * @type array<string, mixed>
	 */
	public final const array DATA = [
		'id'          => 1,
		'name'        => 'Alpha Primus',
		'description' => 'Die Alpha Primus ist eigentlich nur das Ergebnis eines Testaufbaus von Schiffbauer Jon.',
		'anchor'      => null,
		'port'        => null,
		'ship'        => 'Boat',
		'completion'  => 1.0,
		'passengers'  => [],
		'treasury'    => []
	];

	#[Before]
	protected function initIndex(): void {
		$this->index = $this->getIndices(self::DATA);
	}

	#[Test]
	public function construct(): Vessel {
		$unit = new Vessel();

		$this->assertNotNull($unit);

		return $unit;
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultPort(Vessel $vessel): void {
		$this->assertNull($vessel->getDefault('port'));
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultTreasury(Vessel $vessel): void {
		$this->assertSame([], $vessel->getDefault('treasury'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
