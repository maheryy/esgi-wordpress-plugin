<?php

function dd(...$var)
{
    echo '<pre>';
    foreach ($var as $v) {
        if (is_array($v)) {
            print_r($v);
        } else {
            echo $v . PHP_EOL;
        }
    }
    echo '</pre>';
    die;
}

function prettyNumber($n) {
    return number_format($n, 0, ',', ' ');
}

function sanitize(string $s)
{
    return trim(htmlspecialchars($s));
}

function httpRequest(string $url, array $options = [])
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if (isset($options['post'])) {
        curl_setopt($curl, CURLOPT_POST, true);
    }
    if (isset($options['post_data'])) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $options['post_data']);
    }
    if (isset($options['headers'])) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $options['headers']);
    }

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

function buildUrl(string $url, array $params = [])
{
    return $url . ($params ? '?' . http_build_query($params) : '');
}

/**
 * Load .env file
 *
 * @param string $path
 * @throws Exception
 */
function loadDotEnv(string $path)
{
    if (!file_exists($path)) {
        throw new Exception('Impossible de charger les variables d\'envionnements : le fichier ' . $path . ' n\'existe pas');
    }

    if (empty($env = fopen($path, 'r'))) return;

    while (!feof($env)) {
        $line = trim(fgets($env));
        $preg_results = [];
        if (preg_match('/([^=]*)=([^#]*)/', $line, $preg_results) && !empty($preg_results[1]) && !empty($preg_results[2])) {
            define($preg_results[1], $preg_results[2]);
        }
    }
}
