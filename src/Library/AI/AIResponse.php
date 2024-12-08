<?php

namespace App\Library\AI;

use Dikki\Claude\Claude;

/**
 * Right now, this class is using v0.0.2 of the claude sdk.
 * This is a temporary implementation until the sdk is updated to support v1 of the API.
 */
class AIResponse
{
    private $ai;

    public function __construct()
    {
        $this->ai = new Claude(getenv('CLAUDE_API_KEY'));
    }

    public function getResponse($prompt)
    {
        return $this->ai->getTextResponse($prompt);
    }
}
