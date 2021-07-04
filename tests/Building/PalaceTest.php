<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building\Palace;
use Lemuria\Model\Fantasya\Building\Tower;
use Lemuria\Tests\Test;

class PalaceTest extends Test
{
	/**
	 * @test
	 */
	public function correctSize() {
		$palace = new Palace();

		$size = Palace::MAX_SIZE - 5;
		$this->assertSame($size, $palace->correctSize($size));

		$size = Tower::MAX_SIZE;
		$this->assertSame($palace->MinSize(), $palace->correctSize($size));

		$size = Palace::MAX_SIZE + 5;
		$this->assertSame($palace->MaxSize(), $palace->correctSize($size));
	}
}
