<?php

namespace Yizen\Chat\Eventing;

use Illuminate\Events\Dispatcher;
use Yizen\Chat\Chat;

class EventDispatcher
{
    protected $event;

    public function __construct(Dispatcher $event)
    {
        $this->event = $event;
    }

    public function dispatch(array $events)
    {
        if (Chat::broadcasts()) {
            foreach ($events as $event) {
                $eventName = $this->getEventName($event);
                $this->event->dispatch($eventName, $event);
            }
        }
    }

    public function getEventName($event)
    {
        return str_replace('\\', '.', get_class($event));
    }
}
