import Extend from 'flarum/common/extenders';
import FormattingProSettingsPage from './components/FormattingProSettingsPage';

export default [
  new Extend.Admin() //
    .page(FormattingProSettingsPage),
];
