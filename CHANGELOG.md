# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
