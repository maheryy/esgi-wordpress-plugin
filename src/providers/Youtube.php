<?php

class Youtube
{
    private string $api_secret;

    private string $base_url;

    private string $channel;

    public function __construct(string $channel)
    {
        $this->channel = $channel;
        $this->api_secret = 'YT_SECRET';
        $this->base_url = 'youtube';
    }

    public function getLatestVideos()
    {
    }
    public function getMostLikedVideos()
    {
    }
    public function getMostViewedVideos()
    {
    }
}
