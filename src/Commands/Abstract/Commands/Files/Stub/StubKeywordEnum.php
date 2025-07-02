<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Stub;

enum StubKeywordEnum: string
{
    case CLASSNAME = 'classname';
    case EXTEND_CLASSNAME = 'extend_classname';
    case IMPLEMENT_CLASSNAME = 'implement_classname';
    case EXTENDS_INTERFACE = 'extends_interface';
    case NAMESPACE = 'namespace';
    case EXTEND_USE = 'extend_use';
    case NEW_CLASSNAME = 'new_classname';
    case RETURN_TYPE = 'return_type';

    public function getReg(): string
    {
        return "/{{\s*{$this->value}\s*}}/m";
    }

    public function resolve(string $replaced, string $buffer): string
    {
        switch ($this) {
            case self::EXTEND_CLASSNAME:
                static $extend_classname_flag = false;

                self::EXTEND_USE->resolve($replaced, $buffer);

                if (! $extend_classname_flag) {
                    preg_replace($this->getReg(), "{$replaced}, {{ {$this->value} }}", $buffer, 1);

                } else {
                    preg_replace($this->getReg(), "{$replaced}, {{ {$this->value} }}", $buffer, 1);
                }

                return $buffer;
            case self::IMPLEMENT_CLASSNAME:
                return $replaced;
            case self::EXTENDS_INTERFACE:
                return $replaced;
            case self::EXTEND_USE:
                return preg_replace($this->getReg(), "use {$replaced};\n{{ {$this->value} }}", $buffer, 1);
            case self::NEW_CLASSNAME:
                return $replaced;
            case self::RETURN_TYPE:
                return $replaced;
            default:
                return preg_replace($this->getReg(), $replaced, $buffer, 1);
        }
    }
}
