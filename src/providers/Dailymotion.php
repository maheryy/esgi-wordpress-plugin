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
        $videos = json_decode(file_get_contents('https://api.dailymotion.com/user/' . $this->account . '/videos'), true);

        $html = '<div style="display: flex;">';
        foreach ($videos['list'] as $key => $video) {
            $max_nb_videos = null;
            if (!empty($options['nb_videos'])) {
                $max_nb_videos = $options['nb_videos'];
            }

            if ($key < $max_nb_videos || $max_nb_videos === null) {
                $html .= '<div style="flex: 1;">
                    <iframe frameborder="0" width="640" height="360" 
                        src="https://www.dailymotion.com/embed/video/' . $video['id'] . '" 
                        allowfullscreen 
                        allow="autoplay; fullscreen">
                    </iframe>
                    <p>' . $video['title'] . '</p>
                </div>'; 
            }
        }

        return $html;
    }

    public function getButton()
    {
        https://www.dailymotion.com/leparisien
    }
}
