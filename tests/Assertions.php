<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\ItemSet;

trait Assertions
{
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
