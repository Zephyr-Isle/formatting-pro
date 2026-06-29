<?php

/*
 * This file is part of zephyrisle/fof-formatting-pro.
 *
 * Copyright (c) 2024 zephyrisle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephyrisle\FormattingPro\Listeners;

use Flarum\Settings\Event\Saved;

class ClearCache
{
    public function handle(Saved $event): void
    {
        foreach ($event->settings as $key => $setting) {
            if (str_starts_with($key, 'zephyrisle-fof-formatting-pro.plugin.') || 
                str_starts_with($key, 'zephyrisle-fof-formatting-pro.audio_css')) {
                resolve('flarum.formatter')->flush();

                return;
            }
        }
    }
}
