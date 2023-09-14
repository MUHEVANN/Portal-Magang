/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        'title' : ['Offside', 'sans-serif']
      }
    },
  },
  plugins: [],
}
