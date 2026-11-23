import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/**
 * STAR CAKE — "KOLOM"
 * Editorial bakery broadsheet. Swiss grid + ink-on-paper + one paprika accent.
 *
 * HARD RULES ENFORCED HERE
 *   1. Radius is 0 everywhere except form controls (2px) and status dots.
 *   2. Every box-shadow in the project resolves to `none` except `hard` / `hard-lg`.
 *   3. No drop-shadows at all.
 *   4. Custom gradient aliases are deleted (gradient-primary / -warm / -glass / -hero).
 *
 * GRADIENT KILL IS PENDING
 *   Tailwind core gradient utilities (`bg-gradient-to-br`, `from-*`) still resolve so
 *   that the 17 gradient usages across 11 legacy views stay legible mid-refactor.
 *   Phase 3 removes every usage; Phase 4 empties `backgroundImage` to hard-ban them.
 */

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                /* ---------- CANONICAL ---------- */
                // Warm uncoated-paper stock. The single tinted neutral.
                paper: {
                    DEFAULT: '#F4F1EA',
                    alt: '#EAE5DA',
                    warm: '#FBF9F5',
                },
                // Warm off-black. Never #000.
                ink: {
                    DEFAULT: '#14110E',
                    70: '#4A443C',
                    40: '#8A8278',
                },
                // Structural + internal hairlines. Supports /opacity modifiers.
                rule: 'rgb(20 17 14 / <alpha-value>)',

                /* ---------- THE ONE ACCENT: PAPRIKA ---------- */
                // Display type, rules, active markers, destructive actions.
                // Accent fills ALWAYS pair with ink text, never white.
                // White text only on accent-700+ (>= 5.3:1).
                accent: {
                    50: '#FDF1EB',
                    100: '#FBE0D4',
                    200: '#F5BFA6',
                    300: '#EF9C74',
                    400: '#EA7E48',
                    500: '#E2571F',
                    DEFAULT: '#E2571F',
                    600: '#C74813',
                    700: '#A83308',
                    800: '#87280A',
                    900: '#6B1F07',
                },

                /* ---------- LEGACY ALIASES — DELETE IN PHASE 4 ----------
                 * Kept so all 31 views restyle without breaking.
                 * Each maps onto paper / ink / accent. Do not extend.
                 */
                primary: {
                    50: '#FDF1EB',
                    100: '#FBE0D4',
                    200: '#F5BFA6',
                    300: '#EF9C74',
                    400: '#EA7E48',
                    500: '#E2571F',
                    DEFAULT: '#E2571F',
                    600: '#C74813',
                    700: '#A83308',
                    800: '#87280A',
                    900: '#6B1F07',
                },
                secondary: {
                    50: '#FDF1EB',
                    100: '#FBE0D4',
                    200: '#F5BFA6',
                    300: '#EF9C74',
                    400: '#EA7E48',
                    DEFAULT: '#E2571F',
                    500: '#E2571F',
                    600: '#C74813',
                    700: '#A83308',
                    800: '#87280A',
                    900: '#6B1F07',
                },
                surface: {
                    50: '#F4F1EA',
                    100: '#EAE5DA',
                    200: '#DCD5C6',
                    300: '#C4BCAB',
                    400: '#A79E8B',
                    500: '#8A8278',
                    600: '#6B6459',
                    700: '#4A443C',
                    800: '#262220',
                    900: '#14110E',
                    DEFAULT: '#F4F1EA',
                },
                navy: {
                    800: '#1A1714',
                    850: '#16130F',
                    900: '#14110E',
                    950: '#0C0A08',
                },
                // Semantic colour is banned. Neutralised so nothing reads "green = good".
                success: {
                    DEFAULT: '#4A443C',
                    50: '#EAE5DA',
                    100: '#DCD5C6',
                    500: '#4A443C',
                    600: '#3A352F',
                    700: '#262220',
                },
                warning: {
                    DEFAULT: '#4A443C',
                    50: '#EAE5DA',
                    100: '#DCD5C6',
                    500: '#4A443C',
                    600: '#3A352F',
                },
            },

            fontFamily: {
                // Grotesque. Swiss-correct, superb at 11px.
                sans: ['Archivo', ...defaultTheme.fontFamily.sans],
                // Editorial serif with optical sizing. Warm, handcrafted, not luxury-generic.
                display: ['Fraunces', ...defaultTheme.fontFamily.serif],
                // Prices, order numbers, timestamps, figures, labels.
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },

            // Line-height and tracking baked into the scale — one source of truth.
            fontSize: {
                'display-xl': ['clamp(3.5rem, 11vw, 9.5rem)', { lineHeight: '0.88', letterSpacing: '-0.030em' }],
                'display-l': ['clamp(2.25rem, 5.5vw, 4.25rem)', { lineHeight: '0.95', letterSpacing: '-0.022em' }],
                'display-m': ['clamp(1.75rem, 3.5vw, 2.75rem)', { lineHeight: '1', letterSpacing: '-0.015em' }],
                'display-s': ['clamp(1.375rem, 2.2vw, 1.75rem)', { lineHeight: '1.1', letterSpacing: '-0.012em' }],
                lede: ['1.0625rem', { lineHeight: '1.6', letterSpacing: '0.005em' }],
                body: ['0.9375rem', { lineHeight: '1.65', letterSpacing: '0.01em' }],
                btn: ['0.8125rem', { lineHeight: '1', letterSpacing: '0.08em' }],
                data: ['0.875rem', { lineHeight: '1.4', letterSpacing: '0' }],
                label: ['0.6875rem', { lineHeight: '1', letterSpacing: '0.16em' }],
                'label-sm': ['0.625rem', { lineHeight: '1', letterSpacing: '0.18em' }],
            },

            maxWidth: {
                measure: '68ch',
                'measure-lg': '62ch',
            },

            // RULE 1: no radius. md→3xl collapse to 0 so every legacy
            // rounded-2xl/rounded-xl in the views squares off immediately.
            borderRadius: {
                none: '0px',
                sm: '2px',
                DEFAULT: '0px',
                md: '0px',
                lg: '0px',
                xl: '0px',
                '2xl': '0px',
                '3xl': '0px',
                // Form controls keep a 2px registration mark, set in app.css.
                full: '9999px',
                card: '0px',
                button: '0px',
            },

            // RULE 5: ring defaults come from the palette. Without this, every
            // bare `ring-1` / `ring-2` in the views inherits Tailwind's blue
            // (#2563eb) from the universal defaults.
            ringColor: {
                DEFAULT: '#14110E',
            },

            ringOffsetColor: {
                DEFAULT: '#F4F1EA',
            },

            // RULE 2: the only shadows in the project. Hard, unblurred, ink.
            boxShadow: {
                none: 'none',
                sm: 'none',
                DEFAULT: 'none',
                md: 'none',
                lg: 'none',
                xl: 'none',
                '2xl': 'none',
                inner: 'none',
                // Legacy names from the old glow system — neutralised.
                soft: 'none',
                card: 'none',
                elevated: 'none',
                glow: 'none',
                'glow-lg': 'none',
                'inner-soft': 'none',
                hard: '4px 4px 0 0 #14110E',
                'hard-lg': '6px 6px 0 0 #14110E',
            },

            // RULE 3: no drop-shadows anywhere.
            dropShadow: {
                none: '0 0 #0000',
                sm: '0 0 #0000',
                DEFAULT: '0 0 #0000',
                md: '0 0 #0000',
                lg: '0 0 #0000',
                xl: '0 0 #0000',
                '2xl': '0 0 #0000',
            },

            // RULE 4: custom gradient aliases deleted. Core utilities still
            // resolve until Phase 4 flips this to an empty object.
            backgroundImage: {
                none: 'none',
            },

            // Restrained. No float, no glow-pulse, no shimmer, no bounce.
            animation: {
                'fade-in': 'fade-in 0.4s ease-out both',
                'slide-up': 'slide-up 0.5s cubic-bezier(0.22, 1, 0.36, 1) both',
                'slide-down': 'slide-down 0.3s cubic-bezier(0.22, 1, 0.36, 1) both',
                'scale-in': 'scale-in 0.2s cubic-bezier(0.22, 1, 0.36, 1) both',
                pop: 'pop 0.2s ease-out both',
                'scale-restraint': 'scale-restraint 0.2s cubic-bezier(0.22, 1, 0.36, 1) both',
            },

            keyframes: {
                'fade-in': {
                    from: { opacity: '0' },
                    to: { opacity: '1' },
                },
                'slide-up': {
                    from: { opacity: '0', transform: 'translateY(8px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
                'slide-down': {
                    from: { opacity: '0', transform: 'translateY(-6px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
                'scale-in': {
                    from: { opacity: '0', transform: 'scale(0.98)' },
                    to: { opacity: '1', transform: 'scale(1)' },
                },
                pop: {
                    from: { opacity: '0' },
                    to: { opacity: '1' },
                },
                // Replaces the old bouncy cart badge. No overshoot.
                'scale-restraint': {
                    from: { opacity: '0', transform: 'scale(0.9)' },
                    to: { opacity: '1', transform: 'scale(1)' },
                },
            },
        },
    },

    plugins: [forms],
};
