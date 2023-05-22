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
    const SRC = 'radiooperator krótkiego zasięgu';
    const SRC_REGULATIONS = 'regulaminy i podstawowe terminy anglojęzyczne stosowane w służbie radiokomunikacyjnej morskiej';
    const SRC_COMMON_WISDOM = 'ogólna wiedza o podsystemach i urządzeniach radiowych gmdss, stosowanych na obszarze morza a1';
    const SRC_RADIO_HANDLING = 'praktyczna obsługa urządzeń radiowych podsystemów gmdss, stosowanych na obszarze morza a1';
    const REGULATIONS = 'przepisy';
    const YACHT_TYPES = 'budowa jachtów';
    const SAILING_THEORY = 'teoria żaglowania';
    const PILOT = 'locja';
    const METEOROLOGY = 'meteorologia';
    const LIFESAVING = 'ratownictwo';
    const CHIEF_WORKS = 'prace bosmańskie';
    const YACHT_MANEUVERS = 'manewrowanie jachtem';
    const SHIP_MARKINGS = 'oznakowanie statków';
    const BEAUFORT_SCALE = 'skala Beauforta';
    const SOUND_SIGNALS = 'sygnały dźwiękowe';
    const SIGNS = 'znaki';
    const RADIO = 'radio';
}

