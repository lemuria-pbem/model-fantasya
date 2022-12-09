<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Combat;

enum BattleRow : int
{
	case Aggressive = 6;

	case Front = 5;

	case Careful = 4;

	case Back = 3;

	case Defensive = 2;

	case Bystander = 1;

	case Refugee = 0;
}
