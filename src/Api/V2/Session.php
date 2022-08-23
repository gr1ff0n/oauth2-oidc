<?php

namespace App\Api\V2;

use DateTime;

/**
 * Class Session
 * @package App\Api\V2
 */
class Session
{
    /**
     * @return DateTime
     */
    public function getAuthTime(): DateTime
    {
        return new DateTime();
    }
}
