<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Combat;

use Lemuria\Model\Fantasya\Combat\BattleRow;

use Lemuria\Tests\Test;

class BattleRowTest extends Test
{
	/**
	 * @test
	 */
	public function battleRowsCannotBeCompared(): void {
		$defensive = BattleRow::Defensive;
		$back = BattleRow::Back;
		$this->assertFalse($defensive < $back);
		$this->assertFalse($defensive == $back);
		$this->assertFalse($defensive > $back);
	}

	/**
	 * @test
	 */
	public function battleRowValuesCanBeCompared(): void {
		$defensive = BattleRow::Defensive->value;
		$back = BattleRow::Back->value;
		$this->assertTrue($defensive < $back);
		$this->assertFalse($defensive == $back);
		$this->assertFalse($defensive > $back);
	}
}
