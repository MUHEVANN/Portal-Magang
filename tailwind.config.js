/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        'title' : ['Nanum Myeongjo', 'serif']
      },
      screens: {
        sml: '465px',
        '1xl': '1440px'
      },
    },
  },
  plugins: [],
}

