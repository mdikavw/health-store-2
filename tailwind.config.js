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
                primary: "#1c3144",

                secondary: "#005e7c",
                "secondary-light": "#BDBDBD",
                "secondary-dark": "#616161",

                neutral: "#E5E5E5",
                "neutral-light": "#F1F3F4",
                "neutral-dark": "#3C4043",
            },
        },
    },
    plugins: [],
};
