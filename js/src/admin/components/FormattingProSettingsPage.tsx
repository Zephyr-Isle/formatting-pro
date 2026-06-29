import app from 'flarum/admin/app';
import ExtensionPage from 'flarum/admin/components/ExtensionPage';

export default class FormattingProSettingsPage extends ExtensionPage {
  oninit(vnode: any) {
    super.oninit(vnode);

    this.audioCssSetting = this.setting('zephyrisle-fof-formatting-pro.audio_css', '');
  }

  content() {
    return (
      <div className="FormattingProSettingsPage">
        <div className="container">
          <h2>{app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.title')}</h2>

          <div className="Form-group">
            <h3>{app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.plugins')}</h3>

            {this.buildSettingComponent({
              setting: 'zephyrisle-fof-formatting-pro.plugin.autoaudio',
              label: app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.autoaudio'),
              type: 'boolean',
            })}

            {this.buildSettingComponent({
              setting: 'zephyrisle-fof-formatting-pro.plugin.netease',
              label: app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.netease'),
              type: 'boolean',
            })}

            {this.buildSettingComponent({
              setting: 'zephyrisle-fof-formatting-pro.plugin.bilibili',
              label: app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.bilibili'),
              type: 'boolean',
            })}
          </div>

          <div className="Form-group">
            <h3>{app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css')}</h3>
            <textarea
              className="FormControl"
              bidi={this.audioCssSetting}
              placeholder={app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css_placeholder')}
              rows={10}
            />
            <p className="helpText">
              {app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css_help')}
            </p>
          </div>

          <div className="Form-group">{this.submitButton()}</div>
        </div>
      </div>
    );
  }
}
