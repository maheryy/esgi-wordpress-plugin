<?php

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
      'part' => 'id, snippet',
    ];
    if (filter_var($channel, FILTER_VALIDATE_URL)) {
      # $channel is url
      $params['id'] = ($s = explode('/', $channel))[count($s) - 1];
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
    $res = !empty($response['items']) ? array_map(fn ($el) => "https://www.youtube.com/watch?v={$el['id']['videoId']}", $response['items']) : [];
    return $res;
  }

  public function getLatestVideos(int $max = 5)
  {
    return $this->type(self::TYPE_VIDEO)
      ->orderBy(self::ORDER_DATE)
      ->limit($max)
      ->fetch();
  }

  public function getMostLikedVideos(int $max = 5)
  {
    return $this->type(self::TYPE_VIDEO)
      ->orderBy(self::ORDER_RATES)
      ->limit($max)
      ->fetch();
  }
  public function getMostViewedVideos(int $max = 5)
  {
    return $this->type(self::TYPE_VIDEO)
      ->orderBy(self::ORDER_VIEWS)
      ->limit($max)
      ->fetch();
  }

  public function getCurrentLive()
  {
    return $this->type(self::TYPE_LIVE)->fetch();
  }
}

/*

VERIFY

{
  "kind": "youtube#channelListResponse",
  "etag": "qqy9PbVIjOhYoB5XYODkeq6lHjI",
  "pageInfo": {
    "totalResults": 1,
    "resultsPerPage": 5
  },
  "items": [
    {
      "kind": "youtube#channel",
      "etag": "G7hgesNQ52oRQE2uqtZNE6g9Pbk",
      "id": "UCHQda5vLxrH0Ff0I0kMq4zw",
      "snippet": {
        "title": "Konbini",
        "description": "Retrouvez ici les meilleures vidéos de Konbini. \n",
        "customUrl": "konbini",
        "publishedAt": "2006-08-31T01:34:32Z",
        "thumbnails": {
          "default": {
            "url": "https://yt3.ggpht.com/ytc/AKedOLShA8MpLIvPwvRyvzun8c6FMmBKNTLkdMbOl3nOxg=s88-c-k-c0x00ffffff-no-rj",
            "width": 88,
            "height": 88
          },
          "medium": {
            "url": "https://yt3.ggpht.com/ytc/AKedOLShA8MpLIvPwvRyvzun8c6FMmBKNTLkdMbOl3nOxg=s240-c-k-c0x00ffffff-no-rj",
            "width": 240,
            "height": 240
          },
          "high": {
            "url": "https://yt3.ggpht.com/ytc/AKedOLShA8MpLIvPwvRyvzun8c6FMmBKNTLkdMbOl3nOxg=s800-c-k-c0x00ffffff-no-rj",
            "width": 800,
            "height": 800
          }
        },
        "localized": {
          "title": "Konbini",
          "description": "Retrouvez ici les meilleures vidéos de Konbini. \n"
        }
      }
    }
  ]
}


*/

/*

RESPONSE 

{
  "kind": "youtube#searchListResponse",
  "etag": "KqlGnA73cZUXh_Fy9FWJz_viIcE",
  "nextPageToken": "CAMQAA",
  "regionCode": "FR",
  "pageInfo": {
    "totalResults": 2759,
    "resultsPerPage": 3
  },
  "items": [
    {
      "kind": "youtube#searchResult",
      "etag": "hgJfg2JAOVhksjnqdMX-SkYL9Pk",
      "id": {
        "kind": "youtube#video",
        "videoId": "w23MQYC99sY"
      }
    },
    {
      "kind": "youtube#searchResult",
      "etag": "NDZx2Vv9kemaQ-HMg4JJKYSiRUw",
      "id": {
        "kind": "youtube#video",
        "videoId": "FPXlN3x8dcM"
      }
    },
    {
      "kind": "youtube#searchResult",
      "etag": "pyAzAseyJ0wyBGZY29HUsg-28Rg",
      "id": {
        "kind": "youtube#video",
        "videoId": "sr_A6DBkMFk"
      }
    }
  ]
}



*/


/* 

RESPONSE DETAILS

{
  "kind": "youtube#searchListResponse",
  "etag": "fooyqB_CoQj8Q-SXcpX2MPMxVF8",
  "nextPageToken": "CAMQAA",
  "regionCode": "FR",
  "pageInfo": {
    "totalResults": 2759,
    "resultsPerPage": 3
  },
  "items": [
    {
      "kind": "youtube#searchResult",
      "etag": "_zB8aoqcZ0znP38QbrmgGdamYpA",
      "id": {
        "kind": "youtube#video",
        "videoId": "w23MQYC99sY"
      },
      "snippet": {
        "publishedAt": "2021-07-23T16:30:05Z",
        "channelId": "UCHQda5vLxrH0Ff0I0kMq4zw",
        "title": "De scorpions tueurs à leur personnage, le casting de Kaamelott nous parle du tournage | Konbini",
        "description": "On voulait absolument connaître tous leurs secrets de tournage, alors on a posé nos meilleures questions au cast de Kaamelott. Et voilà ce que ça a donné.",
        "thumbnails": {
          "default": {
            "url": "https://i.ytimg.com/vi/w23MQYC99sY/default.jpg",
            "width": 120,
            "height": 90
          },
          "medium": {
            "url": "https://i.ytimg.com/vi/w23MQYC99sY/mqdefault.jpg",
            "width": 320,
            "height": 180
          },
          "high": {
            "url": "https://i.ytimg.com/vi/w23MQYC99sY/hqdefault.jpg",
            "width": 480,
            "height": 360
          }
        },
        "channelTitle": "Konbini",
        "liveBroadcastContent": "none",
        "publishTime": "2021-07-23T16:30:05Z"
      }
    },
    {
      "kind": "youtube#searchResult",
      "etag": "9-839iEqtCpaK3gj-SvM2uPeFCc",
      "id": {
        "kind": "youtube#video",
        "videoId": "FPXlN3x8dcM"
      },
      "snippet": {
        "publishedAt": "2021-07-22T16:30:01Z",
        "channelId": "UCHQda5vLxrH0Ff0I0kMq4zw",
        "title": "Simone Hérault est LA voix de la SNCF depuis 40 ans | Konbini",
        "description": "C'est LA voix de la SNCF : Simone Hérault raconte comment elle a été choisie et dévoile les coulisses de son travail unique en France (et oui, elle paye ses ...",
        "thumbnails": {
          "default": {
            "url": "https://i.ytimg.com/vi/FPXlN3x8dcM/default.jpg",
            "width": 120,
            "height": 90
          },
          "medium": {
            "url": "https://i.ytimg.com/vi/FPXlN3x8dcM/mqdefault.jpg",
            "width": 320,
            "height": 180
          },
          "high": {
            "url": "https://i.ytimg.com/vi/FPXlN3x8dcM/hqdefault.jpg",
            "width": 480,
            "height": 360
          }
        },
        "channelTitle": "Konbini",
        "liveBroadcastContent": "none",
        "publishTime": "2021-07-22T16:30:01Z"
      }
    },
    {
      "kind": "youtube#searchResult",
      "etag": "DIX2XhnRpEPMZgBV7e-KmfBZQkY",
      "id": {
        "kind": "youtube#video",
        "videoId": "sr_A6DBkMFk"
      },
      "snippet": {
        "publishedAt": "2021-07-21T16:40:24Z",
        "channelId": "UCHQda5vLxrH0Ff0I0kMq4zw",
        "title": "Video club : Alexandre Astier nous parle d&#39;Asterix, de Tolkien et évidemment de Kaamelott | Konbini",
        "description": "A l'occasion de la sortie de Kaamelott au cinéma, on a visité notre célèbre video-club avec Alexandre Astier. Le roi Arthur a son avis tranché sur le cinéma avec ...",
        "thumbnails": {
          "default": {
            "url": "https://i.ytimg.com/vi/sr_A6DBkMFk/default.jpg",
            "width": 120,
            "height": 90
          },
          "medium": {
            "url": "https://i.ytimg.com/vi/sr_A6DBkMFk/mqdefault.jpg",
            "width": 320,
            "height": 180
          },
          "high": {
            "url": "https://i.ytimg.com/vi/sr_A6DBkMFk/hqdefault.jpg",
            "width": 480,
            "height": 360
          }
        },
        "channelTitle": "Konbini",
        "liveBroadcastContent": "none",
        "publishTime": "2021-07-21T16:40:24Z"
      }
    }
  ]
}
*/