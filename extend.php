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
use s9e\TextFormatter\Configurator\Bundles\MediaPack;

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

            foreach (Api\ForumResourceFields::PLUGINS as $plugin) {
                $enabled = $settings->get('zephyrisle-fof-formatting-pro.plugin.'.strtolower($plugin));

                if ($enabled) {
                    if ($plugin == 'NetEase' || $plugin == 'Bilibili') {
                        // Initialize MediaPack for these plugins
                        (new MediaPack())->configure($configurator);
                        
                        if ($plugin == 'NetEase') {
                            $configurator->MediaEmbed->add('music.163.com');
                        } elseif ($plugin == 'Bilibili') {
                            $configurator->MediaEmbed->add('bilibili.com');
                        }
                    } elseif ($plugin == 'AutoAudio') {
                        // Auto Audio - Convert audio URLs to HTML5 audio players
                        $configurator->MediaEmbed->add('audio');
                    }
                }
            }
        }),

    (new Extend\ApiResource(Resource\ForumResource::class))
        ->fields(Api\ForumResourceFields::class),

    (new Extend\Event())
        ->listen(Saved::class, Listeners\ClearCache::class),
];
