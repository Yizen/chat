<?php

return [
    'user_model' => 'App\User',

    /*
     * This will allow you to broadcast an event when a message is sent
     * Example:
     * Channel: chat-conversation.2,
     * Event: Yizen\Chat\Eventing\MessageWasSent
     */
    'broadcasts' => false,

    /**
     * The event to fire when a message is sent
     * See Musonza\Chat\Eventing\MessageWasSent if you want to customize.
     */
    'sent_message_event' => 'Yizen\Chat\Eventing\MessageWasSent',

    /**
     * Automatically convert conversations with more than two users to public
     */
    'make_three_or_more_users_public' => true,
];
