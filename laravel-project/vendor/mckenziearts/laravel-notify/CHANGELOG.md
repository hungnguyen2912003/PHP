# Changelog

All notable changes to `laravel-notify` will be documented in this file.

## v3.1 - 2025-12-18

### What's Changed

* feat: Add RTL support and Tailwind class prefixing by @mckenziearts in https://github.com/mckenziearts/laravel-notify/pull/140

**Full Changelog**: https://github.com/mckenziearts/laravel-notify/compare/v3.0...v3.1

## v3.0 - 2025-12-17

### What's Changed

* fix: start Alpine instance conditionally by @akunbeben in https://github.com/mckenziearts/laravel-notify/pull/112
* feat: Enhance notification configuration with theme options, sound support, and localization by @uydevops in https://github.com/mckenziearts/laravel-notify/pull/129
* Increase the stacking order of laravel-notify by @otatechie in https://github.com/mckenziearts/laravel-notify/pull/113
* ⬆️ Bump the js-dependencies group with 2 updates by @dependabot[bot] in https://github.com/mckenziearts/laravel-notify/pull/139
* ⬆️ Bump actions/setup-node from 2 to 6 by @dependabot[bot] in https://github.com/mckenziearts/laravel-notify/pull/138
* ⬆️ Bump stefanzweifel/git-auto-commit-action from 4 to 7 by @dependabot[bot] in https://github.com/mckenziearts/laravel-notify/pull/137
* ⬆️ Bump actions/cache from 4 to 5 by @dependabot[bot] in https://github.com/mckenziearts/laravel-notify/pull/136

### New Contributors

* @akunbeben made their first contribution in https://github.com/mckenziearts/laravel-notify/pull/112
* @uydevops made their first contribution in https://github.com/mckenziearts/laravel-notify/pull/129

**Full Changelog**: https://github.com/mckenziearts/laravel-notify/compare/v2.5...v3.0

## Version 2.2

### Added

- Notify timeout
- Add Support for PHP 7.4

### Updated

- Upgrade to Tailwind v2

## Version 2.1

### Added

- Add Support for Laravel 8

## Version 2.0

Version 2 is Here 🤩 ! Laravel Notify is a package that lets you add custom notifications to your project.
A diverse range of notification design with TailwindCSS and TailwindUI.

### Added

- TailwindCSS & UI
- AlpineJS
- Notify component for Laravel 7

If you are using Laravel 7 you can now add this on your master blade

```html
 <x:notify-messages />


```
### Updated

- Config file, remove all animation stuff
- All notify styles, all built with Tailwindcss
- Demo preview UI

## Version 1.1.2

### Added

- Custom notification title

## Version 1.1.1

### Added

- Preset notification

## Version 1.1

### Added

- Emotify Notification

## Version 1.0.6

### Updated

- Notify height

## Version 1.0.5

### Added

- notification position configuration in `config/notify.php` to set where notification should display.

### Updated

- notify style and javascript

## Version 1.0.4

### Updated

- webpack.mix.js file to set correct path to display assets

## Version 1.0.3

### Removed

- Load unregistred mix asset (/js/app.js) not found

## Version 1.0.2

### Added

- Destroy notification message after rendering

## Version 1.0.1

### Added

- compile asset for production

## Version 1.0

### Added

- Everything
