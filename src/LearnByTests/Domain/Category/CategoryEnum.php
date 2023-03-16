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
    const NAVIGATION = 'nawigacja';
    const REGULATIONS = 'przepisy';
    const PILOT = 'locja';
    const RADIO = 'radio';
    const METEOROLOGY = 'meteorologia';
    const SAR = 'SAR';
    const YACHT_TYPES = 'budowa jachtów';
    const LIGHTS = 'światła';
    const PRIORITY = 'pierwszeństwo';
}

