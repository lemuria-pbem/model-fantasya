<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Combat;

use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Combat\BattleRow;

use Lemuria\Tests\Base;

class BattleRowTest extends Base
{
	#[Test]
	public function battleRowsCannotBeCompared(): void {
		$defensive = BattleRow::Defensive;
		$back = BattleRow::Back;
		$this->assertFalse($defensive < $back);
		$this->assertFalse($defensive == $back);
		$this->assertFalse($defensive > $back);
	}

	#[Test]
	public function battleRowValuesCanBeCompared(): void {
		$defensive = BattleRow::Defensive->value;
		$back = BattleRow::Back->value;
		$this->assertTrue($defensive < $back);
		$this->assertFalse($defensive == $back);
		$this->assertFalse($defensive > $back);
	}
}
