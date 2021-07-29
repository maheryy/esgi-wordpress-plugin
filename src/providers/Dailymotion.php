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

        $html = '<div style="width:100%; display: flex; flex-wrap: wrap; justify-content: space-evenly; align-items: flex-start">';
        foreach ($videos['list'] as $key => $video) {
            $max_nb_videos = null;
            if (!empty($options['nb_videos'])) {
                $max_nb_videos = $options['nb_videos'];
            }

            if ($key < $max_nb_videos || $max_nb_videos === null) {
                $html .= '<div style="box-sizing: border-box; padding: 1em .5em;">
                    <iframe frameborder="0" width="280" height="170" 
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

    public function getButton()
    {
        https://www.dailymotion.com/leparisien
    }
}
