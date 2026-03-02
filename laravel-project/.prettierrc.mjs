import prettierPluginBlade from 'prettier-plugin-blade';

/** @type {import("prettier").Config} */
export default {
    plugins: [prettierPluginBlade],
    overrides: [
        {
            files: ['*.blade.php'],
            options: {
                parser: 'blade',
            },
        },
    ],
    tabWidth: 4,
    singleQuote: true,
    printWidth: 100,
};
