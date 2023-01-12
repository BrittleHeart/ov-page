<?php

namespace App\Enum;

enum EnvironmentTypeEnum: string
{
    case TESTING = 'test';
    case PRODUCTION = 'production';
    case DEVELOPMENT = 'dev';
}
