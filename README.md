# FoF Formatting Pro

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/zephyrisle/fof-formatting-pro.svg)](https://packagist.org/packages/zephyrisle/fof-formatting-pro)

A [Flarum](http://flarum.org) extension. Enhanced formatting with audio support, Chinese platforms (NetEase Cloud Music, Bilibili), and custom audio CSS.

## Features

- **Auto Audio**: Convert audio URLs into HTML5 audio players
- **NetEase Cloud Music**: Embed content from NetEase Cloud Music (网易云音乐)
- **Bilibili**: Embed content from Bilibili (哔哩哔哩)
- **Custom Audio CSS**: Customize the appearance of audio players with custom CSS

## Installation

Install with composer:

```sh
composer require zephyrisle/fof-formatting-pro:"*"
```

## Updating

```sh
composer update zephyrisle/fof-formatting-pro
```

## Configuration

After installation, go to the Admin Panel > Extensions > Formatting Pro to configure:

1. **Auto Audio**: Enable to convert audio URLs to HTML5 audio players
2. **NetEase Cloud Music**: Enable to embed NetEase Cloud Music content
3. **Bilibili**: Enable to embed Bilibili content
4. **Custom Audio CSS**: Enter custom CSS to style audio players

## Usage

### Auto Audio
Simply post an audio URL in a post, and it will be automatically converted to an HTML5 audio player:
```
https://example.com/audio.mp3
```

### NetEase Cloud Music
Share NetEase Cloud Music links to embed them in posts:
```
https://music.163.com/#/song?id=123456
```

### Bilibili
Share Bilibili video links to embed them in posts:
```
https://www.bilibili.com/video/BV1xx411c7mD
```

### Custom Audio CSS
Use the custom CSS field to style audio players. Example:
```css
audio {
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  background: #f5f5f5;
}
```

## Links

- [Packagist](https://packagist.org/packages/zephyrisle/fof-formatting-pro)
- [GitHub](https://github.com/Zephyr-Isle/fof-formatting-pro)
- [Flarum Discuss](https://discuss.flarum.org/)

## Requirements

- Flarum 2.0+

## License

MIT

## Credits

Based on [FoF Formatting](https://github.com/FriendsOfFlarum/formatting) by FriendsOfFlarum.

An extension by [zephyrisle](https://github.com/Zephyr-Isle).
