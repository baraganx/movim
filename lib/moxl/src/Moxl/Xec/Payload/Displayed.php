<?php

namespace Moxl\Xec\Payload;

class Displayed extends Payload
{
    public function handle($stanza, $parent = false)
    {
        $message = \App\User::me()->messages()
                                  ->where('replaceid', (string)$stanza->attributes()->id)
                                  ->where('jidfrom', explodeJid((string)$parent->attributes()->to)['jid'])
                                  ->first();

        if ($message) {
            $message->displayed = gmdate('Y-m-d H:i:s');
            $message->save();

            $this->pack($message);
            $this->deliver();
        }
    }
}
