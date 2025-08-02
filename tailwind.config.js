/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./assets/**/*.jsx"
  ],
  theme: {
    extend: {
      colors: {
        darkBlueFccn: '#1A2424',
        blueFccn: '#13336E',
        redFccn: '#C30404'
      },
      fontFamily: {
        'quicksand': ['Quicksand', 'sans-serif'],
        'tahoma': ['Tahoma', 'Arial', 'sans-serif'],
      }
    },
  },
  plugins: [],
}

