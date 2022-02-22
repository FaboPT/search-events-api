<?php

namespace App\Traits\Utils;

use Carbon\Carbon;

trait DateUtil
{
    public function parseDate($date): Carbon
    {
        return Carbon::parse($date);
    }
}
