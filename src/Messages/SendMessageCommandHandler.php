<?php

namespace Yizen\Chat\Messages;

use Yizen\Chat\Commanding\CommandHandler;
use Yizen\Chat\Eventing\EventDispatcher;
use Yizen\Chat\Models\Message;

class SendMessageCommandHandler implements CommandHandler
{
    protected $message;
    protected $dispatcher;

    /**
     * @param EventDispatcher $dispatcher The dispatcher
     * @param Message $message    The message
     */
    public function __construct(EventDispatcher $dispatcher, Message $message)
    {
        $this->dispatcher = $dispatcher;
        $this->message = $message;
    }

    /**
     * Triggers sending the message.
     *
     * @param  $command  The command
     *
     * @return Message
     */
    public function handle($command)
    {
        $message = $this->message->send($command->conversation, $command->body, $command->senderId, $command->type);

        $this->dispatcher->dispatch($this->message->releaseEvents());

        return $message;
    }
}
