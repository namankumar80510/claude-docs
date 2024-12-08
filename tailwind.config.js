/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.{html,js,php,phtml,twig}',
    './templates/**/**/*.{html,js,php,phtml,twig}',
    './templates/**/*.{html,js,php,phtml,twig}',
    './templates/*.{html,js,php,phtml,twig}',
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
