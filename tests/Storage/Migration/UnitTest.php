<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Unit;

class UnitTest extends BaseMigrationTest
{
	public final const DATA = [
		'id'           => 812295,
		'name'         => 'Herr der Schatten',
		'description'  => 'Dieser mysteriöse Mann leitet die Geschicke der Lemurianer.',
		'race'         => 'Human',
		'size'         => 1,
		'aura'         => null,
		'health'       => 1.0,
		'isGuarding'   => false,
		'battleRow'    => 4,
		'isHiding'     => true,
		'isLooting'    => true,
		'disguiseAs'   => false,
		'inventory'    => ['Crossbow' => 1],
		'treasury'     => [],
		'knowledge'    => ['Camouflage' => 14400],
		'battleSpells' => null,
		'extensions'   => ['Trades' => []]
	];

	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(self::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Unit {
		$unit = new Unit();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultTreasury(Unit $unit): void {
		$this->assertSame([], $unit->getDefault('treasury'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
