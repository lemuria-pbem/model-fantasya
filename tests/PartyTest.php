<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya;

use Lemuria\Model\Fantasya\Party;
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
