<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Combat;

enum BattleRow : int
{
	case AGGRESSIVE = 6;

	case FRONT = 5;

	case CAREFUL = 4;

	case BACK = 3;

	case DEFENSIVE = 2;

	case BYSTANDER = 1;

	case REFUGEE = 0;
}
