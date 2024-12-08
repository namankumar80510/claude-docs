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
        mono: ['JetBrains Mono', 'monospace'],
      },
    },
  },
  plugins: [require('@tailwindcss/typography')],
}
