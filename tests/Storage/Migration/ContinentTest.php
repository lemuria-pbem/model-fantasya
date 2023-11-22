<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Storage\Migration\Continent;

class ContinentTest extends Migration
{
	/**
	 * @type array<string, mixed>
	 */
	public final const array DATA = [
		'id'           => 1,
		'name'         => 'Lemuria Alpha',
		'description'  => 'Eine große Landmasse erhebt sich inmitten des unendlichen Ozeans.',
		'landmass'     => [],
		'names'        => [],
		'descriptions' => []
	];

	#[Before]
	protected function initIndex(): void {
		$this->index = $this->getIndices(self::DATA);
	}

	#[Test]
	public function construct(): Continent {
		$unit = new Continent();

		$this->assertNotNull($unit);

		return $unit;
	}

	#[Test]
	#[Depends('construct')]
	public function getDefaultNames(Continent $continent): void {
		$this->assertSame([], $continent->getDefault('names'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
