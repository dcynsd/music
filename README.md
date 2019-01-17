<h1 align="center"> Music </h1>

<p align="center"> 一个简易的获取网易云音乐歌单的扩展.</p>


## 安装

```
$ composer require dcynsd/music -vvv
```

## 配置

在使用本扩展之前，你需要去 网易云音乐 获取到需要的 歌单 ID。

## 使用

```
use Dcynsd\Music\Music;

$music = new Music();

$songList = $music->getSongList('168176594');
```

示例：

```
{
    {
        "id": 65766,
        "name": "富士山下",
        "artist": "陈奕迅",
        "url": "https:\/\/music.163.com\/song\/media\/outer\/url?id=65766.mp3",
        "cover": "http:\/\/p1.music.126.net\/PcJq6i7zMcPgudejdn1yeg==\/109951163256302356.jpg",
        "lrc": null
    },
    {
        "id": 33162226,
        "name": "悟空",
        "artist": "戴荃",
        "url": "https:\/\/music.163.com\/song\/media\/outer\/url?id=33162226.mp3",
        "cover": "http:\/\/p1.music.126.net\/gn4pPKc_Wk3EyByfi86lUQ==\/3333719255417035.jpg",
        "lrc": null
    },
    {
        "id": 36990266,
        "name": "Faded",
        "artist": "Alan Walker,Iselin Solheim",
        "url": "https:\/\/music.163.com\/song\/media\/outer\/url?id=36990266.mp3",
        "cover": "http:\/\/p1.music.126.net\/8dzD62VK8jLDbhEqkmpIAg==\/18277181788626198.jpg",
        "lrc": null
    }
}
```

## 参数说明

```
getSongList(string $song_list_id, bool $lrc = false)

1. $song_list_id：歌单 ID
2. $lrc：是否需要歌词
```

## 在 Laravel 中使用

可以用两种方式来获取 Dcynsd\Music\Music 实例：

### 方法参数注入

```
.
.
.
public function index(Music $music) 
{
    $response = $music->getSongList('168176594');
}
.
.
.
```

### 服务名访问

```
.
.
.
public function index() 
{
    $response = app('music')->getSongList('168176594');
}
.
.
.
```

## License

MIT