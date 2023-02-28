<?php

declare(strict_types = 1);

namespace App\Entities\Embed;

use App\Constants\AppConstant;
use Carbon\Carbon;

trait TimestampTrait
{
    /**
     * @param string $format
     * 
     * @return string
     */
    public function getCreatedAt(string $format = AppConstant::DATE_FORMAT): string
    {
        return Carbon::parse($this->timestamp->createdAt)
                ->format($format);
    }

    /**
     * @param string $format
     * 
     * @return string
     */
    public function getUpdatedAt(string $format = AppConstant::DATE_FORMAT): string
    {
        return Carbon::parse($this->timestamp->createdAt)
                ->format($format);
    }

    /**
     * @param string $format
     * 
     * @return string
     */
    public function getDeletedAt(string $format = AppConstant::DATE_FORMAT): string
    {
        return Carbon::parse($this->timestamp->createdAt)
                ->format($format);
    }
}