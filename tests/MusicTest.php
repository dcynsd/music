<?php

namespace Dcynsd\Music\Tests;

use Dcynsd\Music\Exceptions\InvalidArgumentException;
use Dcynsd\Music\Music;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class MusicTest extends TestCase
{
    // 检查 空资源
    public function testGetSongListWithNoResource()
    {
        $music = new Music();

        // 断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息为 'no resource'
        $this->expectExceptionMessage('no resource');

        $music->getSongList('123', false);
    }

    // 检查 $lrc 参数
    public function testGetSongListWithInvalidLrc()
    {
        $music = new Music();

        // 断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息为 'Invalid lrc value'
        $this->expectExceptionMessage('Invalid lrc value');

        $music->getSongList('168176594', 1);
    }

    // 检查 $song_list_id 参数
    public function testGetSongListWithInvalidSongListId()
    {
        $music = new Music();

        // 断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息为 'Invalid song_list_id value'
        $this->expectExceptionMessage('Invalid song_list_id value');

        $music->getSongList(true, false);
    }
}