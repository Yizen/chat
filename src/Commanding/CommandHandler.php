<?php

namespace Yizen\Chat\Commanding;

interface CommandHandler
{
    public function handle($command);
}
