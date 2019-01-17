<?php

/*
 * This file is part of the dcynsd/music.
 *
 * (c) dcynsd <dcynsd@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dcynsd\Music;

use Dcynsd\Music\Exceptions\HttpException;
use Dcynsd\Music\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;

class Music
{
    // 歌单 API 地址
    const PLAY_LIST_URL = 'https://music.163.com/api/playlist/detail?id=%s';

    // 歌曲 API 地址
    const SONG_URL = 'https://music.163.com/song/media/outer/url?id=%s.mp3';

    // 歌词 API 地址
    const SONG_LRC_URL = 'https://music.163.com/api/song/lyric?os=pc&id=%s&lv=-1&kv=-1&tv=-1';

    protected $guzzleOptions = [];

    /**
     * 获取歌单列表.
     *
     * @param      $song_list_id 歌单 ID
     * @param bool $lrc          是否需要歌词
     *
     * @return array
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getSongList($song_list_id, $lrc = false)
    {
        if (!$song_list_id || !is_numeric($song_list_id) || !is_string($song_list_id)) {
            throw new InvalidArgumentException('Invalid song_list_id value');
        }

        if (!is_bool($lrc)) {
            throw new InvalidArgumentException('Invalid lrc value');
        }

        $result = $this->postResponse(sprintf(self::PLAY_LIST_URL, $song_list_id));

        if (200 !== $result['code']) {
            throw new InvalidArgumentException('no resource');
        }

        return $this->formatSongList($result['result']['tracks'], $lrc);
    }

    /**
     * 获取歌词.
     *
     * @param $song_id   歌曲 ID
     *
     * @return string
     *
     * @throws HttpException
     */
    public function getSongLrc($song_id)
    {
        if (!$song_id || !is_numeric($song_id) || !is_string($song_id)) {
            throw new InvalidArgumentException('Invalid song_id value');
        }

        $result = $this->postResponse(sprintf(self::SONG_LRC_URL, $song_id));

        return $result['lrc']['lyric'] ?? '';
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    protected function formatArtists($artists)
    {
        return implode(',', array_map(function ($artist) {
            return $artist['name'];
        }, $artists));
    }

    protected function formatSongList(array $songList, bool $lrc)
    {
        return array_map(function ($song) use ($lrc) {
            return [
                'id' => $song['id'],
                'name' => $song['name'],
                'artist' => $this->formatArtists($song['artists']),
                'url' => sprintf(self::SONG_URL, $song['id']),
                'cover' => $song['album']['picUrl'],
                'lrc' => true === $lrc ? $this->getSongLrc($song['id']) : null,
            ];
        }, $songList);
    }

    protected function postResponse(string $url)
    {
        try {
            return \json_decode($this->getHttpClient()->post($url)->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
