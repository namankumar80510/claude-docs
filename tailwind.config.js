/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.{html,js,php,phtml,twig}',
    './templates/**/*.phtml',
    './templates/*.phtml',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Roboto', 'sans-serif'],
      },
    },
  },
  plugins: [require('@tailwindcss/typography')],
}
