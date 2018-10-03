<?php

namespace App\Innote\Core;

interface CreatorListener
{
    public function createSucceeded($instance);

    public function createFailed($message);
}