<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use SATHub\PHPUnit\Base;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Storage\Migration;
use Lemuria\Model\Fantasya\Unit;

use Lemuria\Tests\Model\Fantasya\Storage\Migration\UnitTest;

class MigrationTest extends Base
{
	#[Test]
	public function construct(): Migration {
		$migration = new Migration(Unit::class);

		$this->assertNotNull($migration);

		return $migration;
	}

	#[Test]
	public function constructThrowsException(): void {
		$this->expectException(LemuriaException::class);

		new Migration(self::class);
	}

	#[Test]
	#[Depends('construct')]
	public function isUpToDate(Migration $migration): void {
		$this->assertTrue($migration->isUpToDate(UnitTest::DATA));
	}

	#[Test]
	#[Depends('construct')]
	public function isUpToDateFindsMissing(Migration $migration): void {
		$data = UnitTest::DATA;
		unset($data['aura']);

		$this->assertFalse($migration->isUpToDate($data));
	}

	#[Test]
	#[Depends('construct')]
	public function migrate(Migration $migration): void {
		$data = UnitTest::DATA;
		unset($data['health']);
		unset($data['treasury']);
		$migrated = $migration->migrate($data);

		$this->assertArray($migrated, count($data) + 2);
		$this->assertArrayHasKey('health', $migrated);
		$this->assertSame(1.0, $migrated['health']);
		$this->assertArrayHasKey('treasury', $migrated);
		$this->assertSame([], $migrated['treasury']);
	}

	#[Test]
	#[Depends('construct')]
	public function migrateDoesNothing(Migration $migration): void {
		$this->assertSame(UnitTest::DATA, $migration->migrate(UnitTest::DATA));
	}
}
