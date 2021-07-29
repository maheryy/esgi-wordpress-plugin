<?php
require_once __DIR__ . '/../helpers/helpers.php';

class Dailymotion
{
    private string $account;

    public function __construct(string $account)
    {
        $this->account = $account;
    }

    public function getContent($options = [])
    {
        $videos = httpRequest('https://api.dailymotion.com/user/' . $this->account . '/videos');

        $html = '';
        foreach ($videos['list'] as $key => $video) {
            $max_nb_videos = null;
            if (!empty($options['nb_videos'])) {
                $max_nb_videos = $options['nb_videos'];
            }

            if ($key < $max_nb_videos || $max_nb_videos === null) {
                $html .= '<div style="flex: 1; min-width: 50%;">
                    <iframe frameborder="0" width="100%" height="300" 
                        src="https://www.dailymotion.com/embed/video/' . $video['id'] . '" 
                        allowfullscreen 
                        allow="autoplay; fullscreen">
                    </iframe>
                    <p style="width: 280px">' . $video['title'] . '</p>
                </div>'; 
            }
        }

        return $html;
    }
}
