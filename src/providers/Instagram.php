<?php

class Instagram
{
    private string $api_secret;

    private string $base_url;

    private string $account;

    public function __construct(string $account)
    {
        $this->account = $account;
        $this->api_secret = 'INSTA_SECRET';
        $this->base_url = 'instagram';
    }

    public function getLatestPosts()
    {
    }
}
