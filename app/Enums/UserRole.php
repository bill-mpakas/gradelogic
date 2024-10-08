<?php

namespace App\Enums;

enum RolesEnum: string
{
        // case NAMEINAPP='name-in-database' ;

    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case ORGANIZATION = 'organization';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::STUDENT => 'Students',
            static::TEACHER => 'Teachers',
            static::ORGANIZATION => 'Organizations',
        };
    }
}
