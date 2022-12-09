<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Party;

enum Type : int
{
	case Player = 0;

	case NPC = 1;

	case Monster = 2;
}
