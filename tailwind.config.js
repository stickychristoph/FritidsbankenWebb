// import { colors } from 'tailwindcss/defaultTheme';
const dfTheme = require('tailwindcss/defaultTheme');
const colors = dfTheme.colors;
module.exports = {
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      ...colors,
      green: { 100: '#e4f0e2', 500: '#4D9D34', 700: '#11b300' },
      gray: {
        100: '#eeeeee',
        700: '#757575',
      },
      blue: { 500: '#3796DC', 700: '#1E75B5' },
      magenta: { 500: '#DA1884' },
      orange: { 500: '#E67400' },
    },

    maxWidth: {
      'content-inner': '1200px',
      'content-outer': '1232px',
      text: '632px',
      media: '700px',
    },
    extend: {
      boxShadow: {
        fb: '-2px 2px 0 1px #000',
      },
    },
    screens: {
      sm: '640px',
      // => @media (min-width: 640px) { ... }

      md: '768px',
      // => @media (min-width: 768px) { ... }

      lg: '1024px',
      // => @media (min-width: 1024px) { ... }

      xl: '1240px',
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
