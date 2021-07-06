<?php

class Twitch
{
    private string $api_secret;

    private string $base_url;

    private string $channel;

    public function __construct(string $channel)
    {
        $this->channel = $channel;
        $this->api_secret = 'TWITCH_SECRET';
        $this->base_url = 'twitch';
    }

    public function isLive()
    {
    }

    public function getCurrentLive()
    {
    }
}
