module.exports = {
    purge: [],
    darkMode: false, // or 'media' or 'class'
    theme: {

        screens: {
            xs: { min: '340px', max: '640px' },
            sm: { min: '640px', max: '767px' },
            md: { min: '768px', max: '1023px' },
            lg: { min: '1024px', max: '1279px' },
            xl: { min: '1280px', max: '1535px' },
            '2xl': { min: '1536px' },
        },
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
};
