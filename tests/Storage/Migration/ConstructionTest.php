<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Storage\Migration\Construction;

class ConstructionTest extends Migration
{
	/**
	 * @type array<string, mixed>
	 */
	public final const array DATA = [
		'id'          => 1,
		'name'        => 'Holzfällerhütte',
		'description' => '',
		'building'    => 'Cabin',
		'size'        => 6,
		'inhabitants' => [],
		'treasury'    => [],
		'extensions'  => []
	];

	#[Before]
	protected function initIndex(): void {
		$this->index = $this->getIndices(self::DATA);
	}

	#[Test]
	public function construct(): Construction {
		$unit = new Construction();

		$this->assertNotNull($unit);

		return $unit;
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultInhabitants(Construction $construction): void {
		$this->assertSame([], $construction->getDefault('inhabitants'));
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultTreasury(Construction $construction): void {
		$this->assertSame([], $construction->getDefault('treasury'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
