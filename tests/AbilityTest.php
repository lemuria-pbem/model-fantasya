<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model;

use Lemuria\Model\Lemuria\Ability;
use Lemuria\Tests\Test;

class AbilityTest extends Test
{
	/**
	 * @test
	 */
	public function getExperience() {
		$this->assertSame(0, Ability::getExperience(0));
		$this->assertSame(100, Ability::getExperience(1));
		$this->assertSame(400, Ability::getExperience(2));
		$this->assertSame(900, Ability::getExperience(3));
		$this->assertSame(1600, Ability::getExperience(4));
		$this->assertSame(2500, Ability::getExperience(5));
	}

	/**
	 * @test
	 */
	public function getLevel() {
		$this->assertSame(0, Ability::getLevel(0));
		$this->assertSame(0, Ability::getLevel(99));
		$this->assertSame(1, Ability::getLevel(100));
		$this->assertSame(1, Ability::getLevel(399));
		$this->assertSame(2, Ability::getLevel(400));
		$this->assertSame(2, Ability::getLevel(899));
		$this->assertSame(3, Ability::getLevel(900));
		$this->assertSame(3, Ability::getLevel(1599));
		$this->assertSame(4, Ability::getLevel(1600));
		$this->assertSame(4, Ability::getLevel(2499));
		$this->assertSame(5, Ability::getLevel(2500));
	}
}
