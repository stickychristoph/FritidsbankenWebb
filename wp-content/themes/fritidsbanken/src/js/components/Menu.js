/* globals
     
*/
/* eslint-disable no-new */
class Menu {
  constructor(elem) {
    this.elem = elem;
    this.toggle = this.elem.querySelector('.toggle');
    this.mainMenuContainer = this.elem.querySelector('.main-menu-container');

    this.init();
  }

  init() {
    console.log('MENU - init');
    this.elem.classList.add('no-transitions');

    this.toggle.addEventListener('click', () => {
      this.toggleMenu();
    });

    this.mainMenuContainer.classList.remove('hidden');
  }

  toggleMenu() {
    this.menuVisible = !this.menuVisible;
    if (this.menuVisible) {
      this.elem.classList.remove('no-transitions');
      this.elem.classList.add('menu-visible');
    } else {
      this.hideMenuCompleteHandler = this.hideMenuComplete.bind(this);
      this.elem.addEventListener(
        'transitionend',
        this.hideMenuCompleteHandler,
        false
      );
      this.elem.classList.remove('menu-visible');
    }
  }

  hideMenuComplete() {
    this.elem.removeEventListener(
      'transitionend',
      this.hideMenuCompleteHandler,
      false
    );
    this.elem.classList.add('no-transitions');
  }
}

export default Menu;
