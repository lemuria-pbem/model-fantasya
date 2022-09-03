<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Storage\Migration\Upgrade\MarketRelation;
use Lemuria\Model\Game;

use Lemuria\Tests\Test;

class MarketRelationTest extends Test
{
	protected const RELATIONS = [
		['agreement' => 2 + 4 + 16 + 32 + 512]
	];

	protected const MIGRATED = [
		['agreement' => 2 + 4 + 16 + 64 + 1024]
	];

	protected function game(bool $withExpects = false): Game {
		$game = $this->createMock(Game::class);
		$game->method('getCalendar')->willReturn(['version' => '1.0.0']);
		$game->method('getParties')->willReturn([
			['diplomacy' => ['relations' => self::RELATIONS]]
		]);
		if ($withExpects) {
			$game->expects($this->once())->method('setParties')->with($this->equalTo([
				['diplomacy' => ['relations' => self::MIGRATED]]
			]));
			$game->expects($this->once())->method('setCalendar')->with($this->equalTo(['version' => '1.1.0']));
		}
		return $game;
	}

	/**
	 * @test
	 */
	public function construct(): MarketRelation {
		$marketRelation = new MarketRelation($this->game());

		$this->assertNotNull($marketRelation);

		return $marketRelation;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function isPending(MarketRelation $marketRelation): void {
		$this->assertFalse($marketRelation->isPending('0.9.9'));
		$this->assertTrue($marketRelation->isPending('1.0.0'));
		$this->assertTrue($marketRelation->isPending('1.0.20'));
		$this->assertFalse($marketRelation->isPending('1.1.0'));
	}

	/**
	 * @test
	 */
	public function upgrade(): void {
		$marketRelation = new MarketRelation($this->game(true));

		$this->assertSame($marketRelation, $marketRelation->upgrade());
	}
}
