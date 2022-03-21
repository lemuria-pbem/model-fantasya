<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Storage\Migration;
use Lemuria\Model\Fantasya\Unit;

use Lemuria\Tests\Model\Fantasya\Storage\Migration\UnitTest;
use Lemuria\Tests\Test;

class MigrationTest extends Test
{
	/**
	 * @test
	 */
	public function construct(): Migration {
		$migration = new Migration(Unit::class);

		$this->assertNotNull($migration);

		return $migration;
	}

	/**
	 * @test
	 */
	public function constructThrowsException(): void {
		$this->expectException(LemuriaException::class);

		new Migration(self::class);
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function isUpToDate(Migration $migration): void {
		$this->assertTrue($migration->isUpToDate(UnitTest::DATA));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function isUpToDateFindsMissing(Migration $migration): void {
		$data = UnitTest::DATA;
		unset($data['aura']);

		$this->assertFalse($migration->isUpToDate($data));
	}

	/**
	 * @test
	 * @depends construct
	 */
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

	/**
	 * @test
	 * @depends construct
	 */
	public function migrateDoesNothing(Migration $migration): void {
		$this->assertSame(UnitTest::DATA, $migration->migrate(UnitTest::DATA));
	}
}
