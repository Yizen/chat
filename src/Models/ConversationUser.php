<?php

namespace Yizen\Chat\Models;

use Yizen\Chat\BaseModel;

class ConversationUser extends BaseModel
{
    protected $table = 'conversation_user';

    /**
     * Conversation.
     *
     * @return Relationship
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
}
