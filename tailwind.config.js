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
        'sans': ['Inter', 'system-ui', 'sans-serif'],
        'serif': ['Crimson Pro', 'Georgia', 'serif'],
      },
    },
  },
  plugins: [require('@tailwindcss/typography')],
}
