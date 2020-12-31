<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Lemuria;

use Lemuria\Model\Lemuria\Party;
use Lemuria\Tests\Test;

class PartyTest extends Test
{
	/**
	 * @test
	 */
	public function construct() {
		$party = new Party();
		$this->assertInstanceOf(Party::class, $party);
	}
}
