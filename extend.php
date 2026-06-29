<?php

/*
 * This file is part of zephyrisle/fof-formatting-pro.
 *
 * Copyright (c) 2024 zephyrisle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephyrisle\FoF\FormattingPro;

use Flarum\Api\Resource;
use Flarum\Extend;
use Flarum\Frontend\Document;
use Flarum\Settings\Event\Saved;
use s9e\TextFormatter\Configurator;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__.'/resources/less/forum.less')
        ->content(function (Document $document) {
            $settings = resolve('flarum.settings');
            $customCss = $settings->get('zephyrisle-fof-formatting-pro.audio_css', '');
            
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
            if ($settings->get('zephyrisle-fof-formatting-pro.plugin.autoaudio')) {
                $configurator->Autoimage;
                $configurator->MediaEmbed->add('audio');
            }

            // NetEase Cloud Music
            if ($settings->get('zephyrisle-fof-formatting-pro.plugin.netease')) {
                $configurator->MediaEmbed->add('netease');
                
                // Configure NetEase Cloud Music embed
                if (isset($configurator->MediaEmbed)) {
                    $configurator->MediaEmbed->add('163.com');
                }
            }

            // Bilibili
            if ($settings->get('zephyrisle-fof-formatting-pro.plugin.bilibili')) {
                $configurator->MediaEmbed->add('bilibili');
                
                // Configure Bilibili embed
                if (isset($configurator->MediaEmbed)) {
                    $configurator->MediaEmbed->add('bilibili.com');
                }
            }
        }),

    (new Extend\ApiResource(Resource\ForumResource::class))
        ->fields(Api\ForumResourceFields::class),

    (new Extend\Event())
        ->listen(Saved::class, Listeners\ClearCache::class),
];
