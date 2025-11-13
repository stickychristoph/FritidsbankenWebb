/**
 * @param module
 * @param exports
 */ (function (modules) {
  // webpackBootstrap
  /******/ // The module cache
  /******/ const installedModules = {}; // The require function
  /**
   * @param moduleId
   */ function __webpack_require__(moduleId) {
    /******/
    /******/ // Check if module is in cache
    /******/ if (installedModules[moduleId]) {
      /******/ return installedModules[moduleId].exports;
      /******/
    } // Create a new module (and put it into the cache)
    /******/ /******/ const module = (installedModules[moduleId] = {
      /******/ i: moduleId,
      /******/ l: false,
      /******/ exports: {},
      /******/
    }); // Execute the module function
    /******/
    /******/ /******/ modules[moduleId].call(
      module.exports,
      module,
      module.exports,
      __webpack_require__
    ); // Flag the module as loaded
    /******/
    /******/ /******/ module.l = true; // Return the exports of the module
    /******/
    /******/ /******/ return module.exports;
    /******/
  } // expose the modules object (__webpack_modules__)
  /******/
  /******/
  /******/ /******/ __webpack_require__.m = modules; // expose the module cache
  /******/
  /******/ /******/ __webpack_require__.c = installedModules; // define getter function for harmony exports
  /**
   * @param exports
   * @param name
   * @param getter
   */ __webpack_require__.d = function (exports, name, getter) {
    /******/ if (!__webpack_require__.o(exports, name)) {
      /******/ Object.defineProperty(exports, name, {
        /******/ configurable: false,
        /******/ enumerable: true,
        /******/ get: getter,
        /******/
      });
      /******/
    }
    /******/
  }; // getDefaultExport function for compatibility with non-harmony modules
  /**
   * @param module
   */ __webpack_require__.n = function (module) {
    /******/ const getter =
      module && module.__esModule
        ? /******/ function getDefault() {
            return module.default;
          }
        : /******/ function getModuleExports() {
            return module;
          };
    /******/ __webpack_require__.d(getter, 'a', getter);
    /******/ return getter;
    /******/
  }; // Object.prototype.hasOwnProperty.call
  /**
   * @param object
   * @param property
   */ __webpack_require__.o = function (object, property) {
    return Object.prototype.hasOwnProperty.call(object, property);
  }; /******/ // __webpack_public_path__
  /******/
  /******/ /******/ /******/ __webpack_require__.p = ''; // Load entry module and return exports
  /******/
  /******/ /******/ return __webpack_require__((__webpack_require__.s = 0));
  /******/
})(
  /************************************************************************/
  /**
   * @param module
   * @param exports
   */ [
    /* 0 */
    /***/ function (module, exports) {
      const __ = wp.i18n.__;
      const registerBlockType = wp.blocks.registerBlockType;
      const PostFeaturedImage = wp.editor.PostFeaturedImage;

      registerBlockType('core/featured-image', {
        title: __('Featured Image'),
        icon: 'format-image',
        category: 'media',
        edit: function edit(_ref) {
          const className = _ref.className;

          return wp.element.createElement(
            'div',
            { className },
            wp.element.createElement(PostFeaturedImage, null)
          );
        },
        save: function save(_ref2) {
          const className = _ref2.className;

          // Doesn't save an data. Defer's to theme's placement of featured image.
          return '';
        },
      });

      /***/
    },
    /******/
  ]
);
