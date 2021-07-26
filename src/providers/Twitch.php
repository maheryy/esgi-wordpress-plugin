<?php

class Twitch
{
    private string $api_secret;

    private string $base_url;

    private string $channel;
    private $allowFullscreen;

    public function __construct(string $channel, $allowFullscreen)
    {
        $this->channel = $channel;
        $this->allowFullscreen = $allowFullscreen;
        $this->api_secret = 'TWITCH_SECRET';
        $this->base_url = 'twitch';
    }

    public function isLive()
    {
    }

    public function getCurrentLive()
    {
        return "<iframe
            src='https://player.twitch.tv/?channel=" . $this->channel . "&parent=localhost'
            parent='localhost'
            width='100%'
            height='480'
            allowfullscreen='" . ($this->allowFullscreen ? 'true' : 'false') . "'
            style='flex: 5;'>
        </iframe>";
    }


    public function getCurrentChat()
    {
        return "<iframe 
            src='https://www.twitch.tv/embed/" . $this->channel . "/chat?parent=localhost'
            width='100%'
            height='480'
            style='flex: 2'>
        </iframe>";
    }
}
