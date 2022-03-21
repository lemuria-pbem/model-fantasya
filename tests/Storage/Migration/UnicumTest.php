<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Unicum;

class UnicumTest extends BaseMigrationTest
{
	public final const DATA = [
		'id'          => 1,
		'name'        => 'Unicum',
		'description' => '',
		'composition' => 'Scroll',
		'properties'  => []
	];

	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(self::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Unicum {
		$unit = new Unicum();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultNames(Unicum $unicum): void {
		$this->assertSame(null, $unicum->getDefault('properties'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
