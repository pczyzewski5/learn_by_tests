<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Category;

use App\BaseEnum;

class CategoryEnum extends BaseEnum
{
    const ALL = 'wszystkie';
    const UNASSIGNED = 'bez kategorii';
    const ZJ = 'ŻJ';
    const JSM = 'JSM';
    const NAVIGATION = 'nawigacja';
    const REGULATIONS = 'przepisy';
    const PILOT = 'locja';
    const SIGNALLING = 'sygnalizacja';
    const METEOROLOGY = 'meteorologia';
    const SAR = 'SAR';
}

