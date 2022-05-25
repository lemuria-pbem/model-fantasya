<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Protection\Mail;

/**
 * A rusty mail.
 */
final class RustyMail extends AbstractRepairable implements Armature
{
	public function Weight(): int {
		return Mail::WEIGHT;
	}

	public function Block(): int {
		return $this->reduceBlock(Mail::BLOCK);
	}

	protected function protection(): string {
		return Mail::class;
	}
}
