/* globals
     
*/
/* eslint-disable no-new */
class EasyToReadBlock {
  constructor(elem) {
    this.elem = elem;
    this.toggleButton = this.elem.querySelector('#content-toggle');
    this.primaryContent = null;
    this.secondaryContent = this.elem.querySelector('#fbSecondaryContent');
    this.toggled = false;
    this.init();
  }

  init() {
    this.primaryContent = document.createElement('div');
    this.primaryContent.id = 'fbPrimaryContent';

    Array.from(this.elem.parentNode.children).forEach((elem) => {
      if (!elem.classList.contains('fb-easy-to-read')) {
        this.primaryContent.appendChild(elem);
      }
    });

    this.elem.parentNode.appendChild(this.primaryContent);

    this.toggleButton.addEventListener('click', () => {
      this.toggleContent();
    });
  }

  toggleContent() {
    this.toggled = !this.toggled;

    if (this.toggled) {
      this.primaryContent.classList.add('hidden');
      this.secondaryContent.classList.remove('hidden');
      this.toggleButton.classList.add('toggled');
    } else {
      this.primaryContent.classList.remove('hidden');
      this.secondaryContent.classList.add('hidden');
      this.toggleButton.classList.remove('toggled');
    }
  }
}

export default EasyToReadBlock;
