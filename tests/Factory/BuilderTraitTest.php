<?php
declare(strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Factory;

use PHPUnit\Framework\Attributes\Test;

use Lemuria\Exception\SingletonException;
use Lemuria\Model\Fantasya\Commodity\Weapon\Sword;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Talent\Bladefighting;

use Lemuria\Tests\Model\Fantasya\Model;

class BuilderTraitTest extends Model
{
	use BuilderTrait;

	#[Test]
	public function createTalentIsSingleton(): void {
		$bladefighting1 = self::createTalent(Bladefighting::class);
		$bladefighting2 = self::createTalent(Bladefighting::class);

		$this->assertInstanceOf(Bladefighting::class, $bladefighting1);
		$this->assertSame($bladefighting2, $bladefighting1);
	}

	#[Test]
	public function createInvalidTalent(): void {
		$this->expectException(SingletonException::class);

		self::createTalent(Sword::class);
	}
}
