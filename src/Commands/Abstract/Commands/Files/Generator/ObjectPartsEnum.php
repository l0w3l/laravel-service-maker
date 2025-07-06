<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Generator;

enum ObjectPartsEnum
{
    case NAMESPACE;
    case CLASSNAME;
    case USE;
    case EXTENDS;
    case IMPLEMENTS;
    case FUNCTION;

}
