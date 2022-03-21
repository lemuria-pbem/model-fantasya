<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Storage\Migration\AbstractModel;

use Lemuria\Tests\Test;

abstract class BaseMigrationTest extends Test
{
	protected array $index;

	/**
	 * @test
	 */
	abstract public function construct(): AbstractModel;

	/**
	 * @test
	 * @depends construct
	 */
	public function getDataMissingForCompleteModel(AbstractModel $model): void {
		$this->assertSame([], $model->getMissing($this->getCompleteModel()));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultForInvalidKey(AbstractModel $model): void {
		$this->expectException(LemuriaException::class);

		$model->getDefault('I-DO-NOT-EXIST');
	}

	abstract protected function getCompleteModel(): array;

	protected function getDataMissing(array $data, string ...$missing): array {
		foreach ($missing as $key) {
			unset($data[$key]);
		}
		return $data;
	}

	protected function getIndices(array $data): array {
		$keys    = array_keys($data);
		$indices = array_keys($keys);
		return array_combine($keys, $indices);
	}
}
