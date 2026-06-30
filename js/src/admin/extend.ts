import Extend from 'flarum/common/extenders';
import app from 'flarum/admin/app';

export default [
  new Extend.Admin()
    .setting(() => ({
      setting: 'zephyrisle-fof-formatting-pro.plugin.autoaudio',
      label: app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.autoaudio', {}, true),
      type: 'boolean',
    }))
    .setting(() => ({
      setting: 'zephyrisle-fof-formatting-pro.plugin.netease',
      label: app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.netease', {}, true),
      type: 'boolean',
    }))
    .setting(() => ({
      setting: 'zephyrisle-fof-formatting-pro.plugin.bilibili',
      label: app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.bilibili', {}, true),
      type: 'boolean',
    }))
    .setting(() => ({
      setting: 'zephyrisle-fof-formatting-pro.audio_css',
      label: app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css', {}, true),
      help: app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css_help', {}, true),
      type: 'textarea',
    })),
];
