<?php

class Twitch
{
    private string $base_url = 'https://api.twitch.tv/helix/search/channels';

    private string $channel_id;

    public function __construct(string $channel_id)
    {
        $this->channel_id = $channel_id;
    }


    public static function verifyChannel($channel_id)
    {
        // $url = buildUrl('https://api.twitch.tv/helix/search/channels');
        $res = httpRequest("https://api.twitch.tv/kraken/streams", [
            'headers' => [
                'Accept: application/vnd.twitchtv.v5+json',
                'Client-ID: '. TWITCH_CLIENT_ID
            ]
        ]);

        dd($res);
    }

    public function isLive()
    {
        'https://api.twitch.tv/helix/search/channels';
    }

    public function getCurrentLive()
    {
    }
}
