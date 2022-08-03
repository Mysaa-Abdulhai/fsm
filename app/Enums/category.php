<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class category extends Enum
{
    const natural =   0;
    const human =   1;
    const pets = 2;
    const others = 3;
}
