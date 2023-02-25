<?php
namespace App\Enums;

enum UserCategoryEnum: string
{
    case DISTRIBUTOR = '1';
    case CUSTOMER = '2';

    public function label(): string
    {
        return match($this) {
            self::DISTRIBUTOR => 'distributor',
            self::CUSTOMER => 'customer',
        };
    }
}
