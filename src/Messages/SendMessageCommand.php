<?php

namespace Yizen\Chat\Messages;

use Yizen\Chat\Models\Conversation;

class SendMessageCommand
{
    public $senderId;
    public $body;
    public $conversation;
    public $filename;

    /**
     * @param Conversation $conversation The conversation
     * @param string $body The message body
     * @param int $senderId The sender identifier
     * @param string $type The message type
     * @param string $filename The optional filename attached
     */
    public function __construct(Conversation $conversation, $body, $senderId, $type = 'text', $filename = '')
    {
        $this->conversation = $conversation;
        $this->body = $body;
        $this->type = $type;
        $this->senderId = $senderId;
        $this->filename = $filename;
    }
}
