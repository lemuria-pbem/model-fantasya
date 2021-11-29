<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Protection\Mail;

/**
 * A rusty mail.
 */
final class RustyMail extends AbstractRepairable implements Armature
{
	#[Pure] public function Weight(): int {
		return Mail::WEIGHT;
	}

	#[Pure] public function Block(): int {
		return $this->reduceBlock(Mail::BLOCK);
	}

	#[Pure] protected function protection(): string {
		return Mail::class;
	}
}
