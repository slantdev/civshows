# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.3.0] - 2026-01-20
### Added
- Interactive Select component (`template-parts/components/interactive-select.php`) with dynamic Swiper content.
- Integrated `initInteractiveSelect` logic into `src/main.js`.
- Added styles for interactive select pagination to `src/css/components.css`.

### Changed
- Refactored `interactive-select.php` to remove inline scripts and styles.

## [1.2.0] - 2026-01-20
### Added
- Home Hero Slider component (`template-parts/components/home-hero-slider.php`) with Swiper.js integration.
- `src/css/components.css` for component-specific styles.
- Roboto font from Google Fonts.

### Changed
- Disabled Gutenberg Block Editor in `inc/setup.php` (reverted to Classic Editor).
- Refactored component styles out of `src/style.css`.
- Updated `src/main.js` to initialize Home Hero slider logic.

## [1.1.0] - 2026-01-20
### Added
- Modular header system in `template-parts/global/site-header.php`.
- Theme setup in `inc/setup.php` with support for custom menus, custom logos, and title tags.

### Changed
- Enhanced Vite configuration with BrowserSync for PHP auto-reload and `hot` file for dynamic dev server detection.
- Updated `inc/enqueue.php` to handle `hot` file logic and simplified production enqueuing (unhashed assets).
- Switched Vite dev port to `5174` to avoid local conflicts.

## [1.0.1] - 2026-01-20
### Added
- Custom Tailwind CSS color palette (Blue, Orange, Green, Yellow, Purple, Red) with graded steps (50-950) in `src/css/theme.css`.

### Changed
- Refactored `functions.php` by moving enqueue logic to `inc/enqueue.php`.
- Updated `vite.config.js` and `package.json` to prevent deletion of `assets/images/` during build.
- Replaced `file_get_contents` with `wp_remote_get` for safer Vite server checks.
- Enforced 2-space indentation rule in project documentation.

## [1.0.0] - 2026-01-20
### Added
- Initial project boilerplate.
- Vite v7 configuration with Tailwind CSS v4.
- WordPress theme structure (`style.css`, `functions.php`, `index.php`, `header.php`, `footer.php`).
- AJAX handler architecture in `inc/ajax-handlers.php`.
- Asset compilation to `assets/`.
- Development proxy setup.
