<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage;

use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use function Lemuria\getNamespace;
use Lemuria\Entity;
use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Storage\Migration\AbstractModel;

class Migration
{
	protected AbstractModel $model;

	public function __construct(Entity|string $model) {
		$namespace = getNamespace(AbstractModel::class);
		$name      = getClass($model);
		$migration = $namespace . '\\' . $name;
		if (class_exists($migration)) {
			$this->model = new $migration();
		} else {
			throw new LemuriaException('No migration implemented for model ' . $model . '.');
		}
	}

	#[Pure] public function isUpToDate(array $model): bool {
		return empty($this->model->getMissing($model));
	}

	public function migrate(array $model): array {
		$migrated = [];
		$missing  = $this->model->getMissing($model);
		$keys     = array_keys($model);
		$n        = count($keys);
		$total    = $n + count($missing);
		$i        = 0;
		$k        = 0;
		while ($i < $total) {
			if (array_key_exists($i, $missing)) {
				$key   = $missing[$i];
				$value = $this->model->getDefault($key);
			} else {
				$key   = $keys[$k++];
				$value = $model[$key];
			}
			$migrated[$key] = $value;
			$i++;
		}
		return $migrated;
	}
}
