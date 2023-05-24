<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Building;

use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Building\Palace;
use Lemuria\Model\Fantasya\Building\Tower;

use Lemuria\Tests\Base;

class PalaceTest extends Base
{
	#[Test]
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
