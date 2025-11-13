import Menu from './components/Menu';
import FindBank from './components/FindBank';
import NewsListBlock from './components/NewsListBlock';
import EasyToReadBlock from './components/EasyToReadBlock';

(function () {
  'use strict';

  /* eslint-disable no-new */

  Array.from(document.getElementsByClassName('main-menu-wrapper')).forEach(
    (elem) => {
      new Menu(elem);
    }
  );

  Array.from(document.getElementsByClassName('news-list-block')).forEach(
    (elem) => {
      new NewsListBlock(elem);
    }
  );

  Array.from(document.getElementsByClassName('fb-easy-to-read')).forEach(
    (elem) => {
      new EasyToReadBlock(elem);
    }
  );

  Array.from(document.getElementsByClassName('findbank-wrapper')).forEach(
    (elem) => {
      new FindBank(elem);
    }
  );
})();
