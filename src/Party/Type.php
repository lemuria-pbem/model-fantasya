<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Party;

enum Type : int
{
	case PLAYER = 0;

	case NPC = 1;

	case MONSTER = 2;
}
