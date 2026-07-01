<?php

/*
 * This file is part of fof/formatting.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephyrisle\FormattingPro;

use Flarum\Api\Resource;
use Flarum\Extend;
use Flarum\Frontend\Document;
use Flarum\Settings\Event\Saved;
use s9e\TextFormatter\Configurator;
use Zephyrisle\FormattingPro\Api\ForumResourceFields;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less')
        ->content(function (Document $document) {
            $settings = resolve('flarum.settings');
            $customCss = $settings->get('zephyrisle-formatting-pro.audio_css', '');
            
            if ($customCss) {
                $document->head[] = '<style>' . $customCss . '</style>';
            }
        }),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Formatter())
        ->configure(function (Configurator $configurator) {
            $settings = resolve('flarum.settings');

            // Auto Audio - Convert audio URLs to HTML5 audio players
            if ($settings->get('zephyrisle-formatting-pro.plugin.autoaudio', true)) {
                $configurator->tags->add('AUTOAUDIO')->attributes->add('src');
                $configurator->tags['AUTOAUDIO']->template =
                    '<audio controls="" preload="none" src="{@src}"><a href="{@src}"><xsl:value-of select="@src"/></a></audio>';
                
                $configurator->Preg->match(
                    '((?:https?://)[^\\s<>"\']+\\.(?:mp3|m4a|ogg|wav|flac|aac|opus)(?:\\?[^\\s<>"\']*)?)',
                    'AUTOAUDIO'
                );
            }

            // NetEase Cloud Music
            if ($settings->get('zephyrisle-formatting-pro.plugin.netease', true)) {
                $configurator->MediaEmbed->add(
                    'netease',
                    [
                        'host' => 'music.163.com',
                        'extract' => [
                            "!music\\.163\\.com/#/(?<mode>song|album|playlist)\\?id=(?<id>\\d+)!",
                            "!music\\.163\\.com/m/(?<mode>song|album|playlist)\\?id=(?<id>\\d+)!",
                            "!music\\.163\\.com/(?<mode>song|album|playlist)\\?id=(?<id>\\d+)!",
                            "!music\\.163\\.com/(?<mode>song|album|playlist)/(?<id>\\d+)/?(?:\\?userid=\\d+)?",
                        ],
                        'choose' => [
                            'when' => [
                                [
                                    'test' => "@mode = 'album'",
                                    'iframe' => [
                                        'width' => 380,
                                        'height' => 450,
                                        'src' => 'https://music.163.com/outchain/player?type=1&id={@id}&auto=0&height=430',
                                    ],
                                ],
                                [
                                    'test' => "@mode = 'song'",
                                    'iframe' => [
                                        'width' => 380,
                                        'height' => 86,
                                        'src' => 'https://music.163.com/outchain/player?type=2&id={@id}&auto=0&height=66',
                                    ],
                                ],
                            ],
                            'otherwise' => [
                                'iframe' => [
                                    'width' => 380,
                                    'height' => 450,
                                    'src' => 'https://music.163.com/outchain/player?type=0&id={@id}&auto=0&height=430',
                                ],
                            ],
                        ],
                    ]
                );
            }

            // Bilibili
            if ($settings->get('zephyrisle-formatting-pro.plugin.bilibili', true)) {
                $configurator->MediaEmbed->add(
                    'bilibili',
                    [
                        'host' => ['www.bilibili.com', 'bilibili.com'],
                        'extract' => [
                            "!bilibili\\.com/video/(?<bvid>BV[0-9A-Za-z]+)(?:/?(?:\\?[^#\\s]*?[?&]p=(?<page>\\d+))?)?!",
                            "!bilibili\\.com/video/av(?<aid>\\d+)(?:/?(?:\\?[^#\\s]*?[?&]p=(?<page>\\d+))?)?!",
                        ],
                        'choose' => [
                            'when' => [
                                [
                                    'test' => '@bvid and @page',
                                    'iframe' => [
                                        'width' => 720,
                                        'height' => 405,
                                        'src' => 'https://player.bilibili.com/player.html?bvid={@bvid}&page={@page}',
                                    ],
                                ],
                                [
                                    'test' => '@bvid',
                                    'iframe' => [
                                        'width' => 720,
                                        'height' => 405,
                                        'src' => 'https://player.bilibili.com/player.html?bvid={@bvid}',
                                    ],
                                ],
                                [
                                    'test' => '@aid and @page',
                                    'iframe' => [
                                        'width' => 720,
                                        'height' => 405,
                                        'src' => 'https://player.bilibili.com/player.html?aid={@aid}&page={@page}',
                                    ],
                                ],
                            ],
                            'otherwise' => [
                                'iframe' => [
                                    'width' => 720,
                                    'height' => 405,
                                    'src' => 'https://player.bilibili.com/player.html?aid={@aid}',
                                ],
                            ],
                        ],
                    ]
                );
            }
        }),

    (new Extend\ApiResource(Resource\ForumResource::class))
        ->fields(Api\ForumResourceFields::class),

    (new Extend\Event())
        ->listen(Saved::class, Listeners\ClearCache::class),
];
