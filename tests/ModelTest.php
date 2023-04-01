<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\ItemSet;
use Lemuria\Lemuria;
use Lemuria\Model\Fantasya\SingletonCatalog;
use Lemuria\Tests\Mock\Model\ConfigMock;
use Lemuria\Tests\Test;

abstract class ModelTest extends Test
{
	public static function setUpBeforeClass(): void {
		parent::setUpBeforeClass();
		Lemuria::init(new ConfigMock());
		Lemuria::Builder()->register(new SingletonCatalog());
	}

	/**
	 * @param array<string, int> $expected
	 */
	public static function assertItemSet(array $expected, ItemSet $actual): void {
		parent::assertSame(count($expected), $actual->count(), 'Item set count is different.');
		foreach ($expected as $class => $count) {
			parent::assertTrue($actual->offsetExists($class), 'Item set has no ' . getClass($class) . '.');
			parent::assertSame($count, $actual[$class]->Count(), 'Item set does not have ' . $count . ' ' . getClass($class) . '.');
		}
		foreach ($actual as $item) {
			$class = get_class($item->getObject());
			parent::assertTrue(isset($expected[$class]), 'Item set has unexpected ' . $item . '.');
		}
	}
}
