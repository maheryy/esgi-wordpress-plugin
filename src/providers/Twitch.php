<?php

class Twitch
{
    private string $api_secret;

    private string $base_url;

    private string $channel;
    private $options;

    public function __construct(string $channel, $options)
    {
        $this->channel = $channel;
        $this->options = $options;
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
            allowfullscreen='" . $this->getOptionValue('twitch_autoplay', 'true') . "'
            autoplay='" . $this->getOptionValue('twitch_autoplay', 'true') . "'
            muted='" . $this->getOptionValue('twitch_muted', 'false') . "'
            style='flex: 5;'>
        </iframe>";
    }

    private function getOptionValue($nameOption, $defaultValue)
    {
        return !empty($this->options[$nameOption])
            ? $this->options[$nameOption]
            : $defaultValue;
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
