import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'be-bg':              '#f8f9ff',
                'be-surface':         '#f8f9ff',
                'be-surface-lowest':  '#ffffff',
                'be-surface-low':     '#eff4ff',
                'be-surface-mid':     '#e5eeff',
                'be-surface-high':    '#dce9ff',
                'be-surface-highest': '#d3e4fe',
                'be-surface-variant': '#d3e4fe',
                'be-on-bg':           '#0b1c30',
                'be-on-surface':      '#0b1c30',
                'be-on-surface-var':  '#514348',
                'be-outline':         '#847378',
                'be-outline-var':     '#d6c1c7',
                'be-primary':         '#864461',
                'be-primary-cnt':     '#a35c7a',
                'be-primary-fixed':   '#ffd9e5',
                'be-primary-dim':     '#ffb0ce',
                'be-on-primary':      '#ffffff',
                'be-on-pf':           '#3a0522',
                'be-on-pfv':          '#70324e',
                'be-secondary':       '#665c60',
                'be-secondary-fixed': '#eddfe4',
                'be-secondary-dim':   '#d1c3c8',
                'be-on-sec-cnt':      '#6a6064',
                'be-tertiary':        '#356253',
                'be-tertiary-fixed':  '#bcedda',
                'be-tertiary-dim':    '#a0d1bf',
                'be-on-tert-fv':      '#204f41',
                'be-error':           '#ba1a1a',
                'be-error-fixed':     '#ffdad6',
                'be-inv-surface':     '#213145',
                'be-inv-on-surface':  '#eaf1ff',
            },
        },
    },

    plugins: [forms],
};
