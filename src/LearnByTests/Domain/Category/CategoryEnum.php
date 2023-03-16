<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Category;

use App\BaseEnum;

class CategoryEnum extends BaseEnum
{
    const ALL = 'wszystkie';
    const UNASSIGNED = 'bez kategorii';
    const ZJ = 'żeglarz jachtowy';
    const JSM = 'jachtowy sternik morski';
    const REGULATIONS = 'przepisy';
    const YACHT_TYPES = 'budowa jachtów';
    const SAILING_THEORY = 'teoria żaglowania';
    const PILOT = 'locja';
    const METEOROLOGY = 'meteorologia';
    const LIFESAVING = 'ratownictwo';
    const CHIEF_WORKS = 'prace bosmańskie';
    const YACHT_MANEUVERS = 'manewrowanie jachtem';
    const LIGHTS = 'światła';
    const DAY_NIGHT_SHIP_MARKINGS = 'dzienne oraz nocne oznaczenia statków';
}

