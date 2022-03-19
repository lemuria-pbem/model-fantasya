<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Continent;

class ContinentTest extends BaseMigrationTest
{
	public final const DATA = [
		'id'           => 1,
		'name'         => 'Lemuria Alpha',
		'description'  => 'Eine große Landmasse erhebt sich inmitten des unendlichen Ozeans.',
		'landmass'     => [],
		'names'        => [],
		'descriptions' => []
	];

	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(self::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Continent {
		$unit = new Continent();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultNames(Continent $continent): void {
		$this->assertSame([], $continent->getDefault('names'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
