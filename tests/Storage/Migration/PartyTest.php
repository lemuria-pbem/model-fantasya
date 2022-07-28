<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Party;

class PartyTest extends BaseMigrationTest
{
	public final const DATA = [
		'id'          => 27742,
		'name'        => 'Lemurianer',
		'description' => 'Die Lemurianer streben die Vorherrschaft über den ganzen Kontinent Lemuria an.',
		'type'        => 0,
		'banner'      => 'Banner',
		'uuid'        => '',
		'creation'    => 1609963601,
		'round'       => 0,
		'retirement'  => null,
		'origin'      => 123,
		'race'        => 'Human',
		'diplomacy'   => [],
		'people'      => [],
		'chronicle'   => [],
		'herbalBook'  => [],
		'spellBook'   => [],
		'loot'        => [],
		'presettings' => ['battleRow' => 1, 'isHiding' => true, 'disguiseAs' => false, 'isLooting'=> false]
	];

	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(self::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Party {
		$unit = new Party();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultLoot(Party $party): void {
		$this->assertSame([], $party->getDefault('loot'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
