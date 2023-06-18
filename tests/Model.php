<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya;

use PHPUnit\Framework\Attributes\BeforeClass;
use SATHub\PHPUnit\Base;

use Lemuria\Lemuria;
use Lemuria\Model\Fantasya\SingletonCatalog;

use Lemuria\Tests\Assertions;
use Lemuria\Tests\Mock\Model\ConfigMock;

abstract class Model extends Base
{
	use Assertions;

	#[BeforeClass]
	public static function initSingletonCatalog(): void {
		parent::setUpBeforeClass();
		Lemuria::init(new ConfigMock());
		Lemuria::Builder()->register(new SingletonCatalog());
	}
}
