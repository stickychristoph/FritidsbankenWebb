/* global
 settings, XMLHttpRequest,  */

/* eslint-disable no-new */

class NewsListBlock {
  constructor(elem) {
    this.elem = elem;
    this.loadMoreBtn = this.elem.querySelectorAll('#load-more-news')[0];
    this.newsItems = this.elem.querySelectorAll('#news-items')[0];
    this.insertBefore = this.elem.querySelectorAll('#insert-news-before')[0];
    this.newsRequest = null;

    this.init();
  }

  init() {
    console.log('LOAD news - init');

    this.loadMoreBtn.addEventListener('click', (evt) => {
      console.log('LOAD news - click');
      evt.preventDefault();

      this.loadMoreNews(this.onNewsLoaded, this);
    });
  }

  loadMoreNews(callback, scope) {
    this.loadMoreBtn.classList.add('loading');
    this.newsRequest = new XMLHttpRequest();

    this.newsRequest.open('POST', settings.ajaxurl, true);
    this.newsRequest.setRequestHeader(
      'Content-Type',
      'application/x-www-form-urlencoded; charset=UTF-8'
    );

    this.newsRequest.onload = function () {
      callback.call(scope, this.response);
    };

    this.newsRequest.onerror = function () {
      // Connection error
    };

    const o = this.newsItems.querySelectorAll('.news-list-item:not(.filler)')
      .length;
    this.newsRequest.send('action=moreNews&o=' + o);
  }

  onNewsLoaded(data) {
    this.loadMoreBtn.classList.remove('loading');
    data = JSON.parse(data);

    if (data.itemsLeft <= 0) {
      this.loadMoreBtn.style.dispay = 'none';
    }
    this.insertBefore.insertAdjacentHTML('beforebegin', data.html);
    // this.newsItems.innerHTML = this.newsItems.innerHTML + data.html;
  }
}
export default NewsListBlock;
