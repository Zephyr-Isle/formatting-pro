import app from 'flarum/admin/app';
import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import Button from 'flarum/common/components/Button';
import Switch from 'flarum/common/components/Switch';
import saveSettings from 'flarum/admin/utils/saveSettings';
import Stream from 'flarum/common/utils/Stream';

export default class FormattingProSettingsPage extends ExtensionPage {
  loading = false;
  audioCssStream: Stream<string>;

  oninit(vnode: any) {
    super.oninit(vnode);
    this.audioCssStream = new Stream(app.data.settings['zephyrisle-fof-formatting-pro.audio_css'] || '');
  }

  content() {
    return (
      <div className="FormattingProSettingsPage">
        <div className="container">
          <h2>{app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.title')}</h2>
          
          <div className="Form-group">
            <h3>{app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.plugins')}</h3>
            
            <div className="Checkbox">
              <Switch 
                state={app.data.settings['zephyrisle-fof-formatting-pro.plugin.autoaudio'] || false}
                onchange={(value: boolean) => {
                  app.data.settings['zephyrisle-fof-formatting-pro.plugin.autoaudio'] = value;
                }}
              >
                {app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.autoaudio')}
              </Switch>
            </div>

            <div className="Checkbox">
              <Switch 
                state={app.data.settings['zephyrisle-fof-formatting-pro.plugin.netease'] || false}
                onchange={(value: boolean) => {
                  app.data.settings['zephyrisle-fof-formatting-pro.plugin.netease'] = value;
                }}
              >
                {app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.netease')}
              </Switch>
            </div>

            <div className="Checkbox">
              <Switch 
                state={app.data.settings['zephyrisle-fof-formatting-pro.plugin.bilibili'] || false}
                onchange={(value: boolean) => {
                  app.data.settings['zephyrisle-fof-formatting-pro.plugin.bilibili'] = value;
                }}
              >
                {app.translator.trans('zephyrisle-fof-formatting-pro.admin.plugins.bilibili')}
              </Switch>
            </div>
          </div>

          <div className="Form-group">
            <h3>{app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css')}</h3>
            <textarea 
              className="FormControl"
              bidi={this.audioCssStream}
              placeholder={app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css_placeholder')}
              rows={10}
            />
            <p className="helpText">
              {app.translator.trans('zephyrisle-fof-formatting-pro.admin.settings.audio_css_help')}
            </p>
          </div>

          <div className="Form-group">
            {Button.component({
              type: 'submit',
              className: 'Button Button--primary',
              loading: this.loading,
              onclick: this.onsubmit.bind(this),
            }, app.translator.trans('zephyrisle-fof-formatting-pro.admin.buttons.save'))}
          </div>
        </div>
      </div>
    );
  }

  onsubmit(e: Event) {
    e.preventDefault();
    this.loading = true;

    const settings = {
      'zephyrisle-fof-formatting-pro.plugin.autoaudio': app.data.settings['zephyrisle-fof-formatting-pro.plugin.autoaudio'] || false,
      'zephyrisle-fof-formatting-pro.plugin.netease': app.data.settings['zephyrisle-fof-formatting-pro.plugin.netease'] || false,
      'zephyrisle-fof-formatting-pro.plugin.bilibili': app.data.settings['zephyrisle-fof-formatting-pro.plugin.bilibili'] || false,
      'zephyrisle-fof-formatting-pro.audio_css': this.audioCssStream(),
    };

    saveSettings(settings)
      .then(() => {
        this.loading = false;
        m.redraw();
      })
      .catch(() => {
        this.loading = false;
        m.redraw();
      });
  }
}
