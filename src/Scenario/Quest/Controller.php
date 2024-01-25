<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Scenario\Quest;

use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Scenario\Payload;
use Lemuria\Model\Fantasya\Scenario\Quest;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Singleton;

interface Controller extends Singleton
{
	/**
	 * Create a new payload object.
	 */
	public function createPayload(): Payload;

	/**
	 * Set Quest payload for next controller action.
	 */
	public function setPayload(Quest $quest): static;

	/**
	 * Check if the quest is available for a unit or parry.
	 */
	public function isAvailableFor(Party|Unit $subject): bool;

	/**
	 * Check if the quest can now be finished by a player unit.
	 */
	public function canBeFinishedBy(Unit $unit): bool;

	/**
	 * Check if a quest has been assigned to a player unit.
	 */
	public function isAssignedTo(Unit $unit): bool;

	/**
	 * Check if a quest has been completed by a player unit (and can be removed).
	 */
	public function isCompletedBy(Unit $unit): bool;

	/**
	 * Call the controller from a player unit.
	 *
	 * This should either assign the quest to a player unit or finish an assigned quest, if applicable.
	 */
	public function callFrom(Unit $unit): static;
}
