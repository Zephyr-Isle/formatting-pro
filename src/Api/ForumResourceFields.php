<?php

/*
 * This file is part of zephyrisle/fof-formatting-pro.
 *
 * Copyright (c) 2026 zephyrisle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephyrisle\FormattingPro\Api;

use Flarum\Api\Context;
use Flarum\Api\Schema;

class ForumResourceFields
{
    const PLUGINS = [
        'AutoAudio',
        'NetEase',
        'Bilibili',
    ];

    public function __invoke(): array
    {
        return [
            Schema\Arr::make('zephyrisle-fof-formatting-pro.plugins')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(function (object $model, Context $context) {
                    return self::PLUGINS;
                }),
            Schema\Str::make('zephyrisle-fof-formatting-pro.audio_css')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(function (object $model, Context $context) {
                    return resolve('flarum.settings')->get('zephyrisle-fof-formatting-pro.audio_css', '');
                }),
        ];
    }
}
