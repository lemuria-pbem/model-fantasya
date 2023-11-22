<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Storage\Migration\Unicum;

class UnicumTest extends Migration
{
	/**
	 * @type array<string, mixed>
	 */
	public final const array DATA = [
		'id'          => 1,
		'name'        => 'Unicum',
		'description' => '',
		'composition' => 'Scroll',
		'properties'  => []
	];

	#[Before]
	protected function initIndex(): void {
		$this->index = $this->getIndices(self::DATA);
	}

	#[Test]
	public function construct(): Unicum {
		$unit = new Unicum();

		$this->assertNotNull($unit);

		return $unit;
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultNames(Unicum $unicum): void {
		$this->assertSame(null, $unicum->getDefault('properties'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
