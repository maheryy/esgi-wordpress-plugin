<?php
require_once __DIR__ . '/../helpers/helpers.php';

class Youtube
{
  private string $base_url = 'https://youtube.googleapis.com/youtube/v3/search';

  private string $channel_id;

  private array $params;

  const ORDER_DATE = 'date';
  const ORDER_RATES = 'rating';
  const ORDER_VIEWS = 'viewCount';

  const TYPE_VIDEO = 'video';
  const TYPE_LIVE = 'live';

  public function __construct(string $channel_id)
  {
    $this->channel_id = $channel_id;
  }

  public static function verifyChannel(string $channel)
  {
    $params = [
      'key' => YT_API_KEY,
      'part' => 'id,snippet',
    ];
    # $channel is url
    if (filter_var($channel, FILTER_VALIDATE_URL)) {
      # youtube url can be either id or channel name
      $type = strpos($channel, 'channel/') !== false ? 'id' : 'forUsername';
      $params[$type] = ($s = explode('/', $channel))[count($s) - 1];
    } else {
      # $channel is channel name
      $params['forUsername'] = $channel;
    }

    $res = httpRequest(buildUrl('https://youtube.googleapis.com/youtube/v3/channels', $params));
    return $res['items']
      ? [
        'id' => $res['items'][0]['id'],
        'name' => $res['items'][0]['snippet']['title'],
      ]
      : null;
  }

  public function type(string $type)
  {
    $this->params['type'] = 'video';
    if ($type === self::TYPE_VIDEO) {
      $this->params['videoEmbeddable'] = 'true';
    } else {
      $this->params['eventType'] = 'live';
    }
    return $this;
  }

  public function orderBy(string $order)
  {
    $this->params['order'] = $order;
    return $this;
  }

  public function limit(int $max)
  {
    $this->params['maxResults'] = $max;
    return $this;
  }

  public function getUrl()
  {
    $this->params['channelId'] = $this->channel_id;
    $this->params['key'] = YT_API_KEY;
    return buildUrl($this->base_url, $this->params);
  }

  public function fetch()
  {
    $response = httpRequest($this->getUrl());
    $res = $response['items'] ? array_map(fn ($el) => ['id' => $el['id']['videoId']], $response['items']) : [];
    return $res;
  }

  public function getCurrentLive()
  {
    return $this->type(self::TYPE_LIVE)->fetch();
  }

  public function getLatestVideos(int $max, bool $with_details = true)
  {
    $videos = $this->type(self::TYPE_VIDEO)
      ->orderBy(self::ORDER_DATE)
      ->limit($max)
      ->fetch();

    return $with_details && $videos ? $this->getVideosDetails($videos) : $videos;
  }

  public function getMostLikedVideos(int $max, bool $with_details = true)
  {
    $videos = $this->type(self::TYPE_VIDEO)
      ->orderBy(self::ORDER_RATES)
      ->limit($max)
      ->fetch();

    return $with_details && $videos ? $this->getVideosDetails($videos) : $videos;
  }
  public function getMostViewedVideos(int $max, bool $with_details = true)
  {
    $videos = $this->type(self::TYPE_VIDEO)
      ->orderBy(self::ORDER_VIEWS)
      ->limit($max)
      ->fetch();

    return $with_details && $videos ? $this->getVideosDetails($videos) : $videos;
  }

  private function getVideosDetails(array $videos)
  {
    $res = httpRequest(buildUrl('https://youtube.googleapis.com/youtube/v3/videos', [
      'key' => YT_API_KEY,
      'part' => 'statistics',
      'id' => implode(',', array_map(fn ($el) => $el['id'], $videos))
    ]));

    return $res['items']
      ? array_map(fn ($el) => [
        'id' => $el['id'],
        'views' => prettyNumber($el['statistics']['viewCount']),
        'likes' => prettyNumber($el['statistics']['likeCount']),
        'dislikes' => prettyNumber($el['statistics']['dislikeCount']),
        'favorites' => prettyNumber($el['statistics']['favoriteCount']),
        'comments' => prettyNumber($el['statistics']['commentCount']),
      ], $res['items'])
      : null;
  }
}