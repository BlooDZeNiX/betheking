module.exports = {
    content: ["./index.html", "./src/**/*.{html,vue,js,ts,jsx,tsx}"],

    theme: {},
    extend: {},
    plugins: [
        require('@tailwindcss/forms')
    ],
};