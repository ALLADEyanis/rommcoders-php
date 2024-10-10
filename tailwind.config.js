/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./node_modules/preline/dist/*.js",
    "./includes/*.php",
    "./register.php",
    "*.php",
    "*.html",
  ],
  theme: {
    extend: {
      colors: {
        
      }
    },
  },
  plugins: [require("preline/plugin")],
};

