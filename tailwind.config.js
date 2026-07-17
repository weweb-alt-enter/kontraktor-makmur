/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#E8EDF5',
          100: '#C5CFE6',
          200: '#9EAFD1',
          300: '#778FBC',
          400: '#5A77AB',
          500: '#3D5F9A',
          600: '#375792',
          700: '#2E4D88',
          800: '#26437E',
          900: '#1E3A8A',
        },
        accent: {
          50: '#FFF8E1',
          100: '#FFECB3',
          200: '#FFE082',
          300: '#FFD54F',
          400: '#FFCA28',
          500: '#FBBF24',
          600: '#F59E0B',
          700: '#D97706',
          800: '#B45309',
          900: '#92400E',
        },
        text: {
          light: '#9CA3AF',
          DEFAULT: '#4B5563',
          dark: '#1F2937',
        }
      },
      fontFamily: {
        'sans': ['Inter', 'system-ui', 'sans-serif'],
        'heading': ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}