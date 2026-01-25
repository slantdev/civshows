# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.10.0] - 2026-01-20
### Added
- Installed `postcss-nested` for SCSS-like nesting support.
- Installed `@tailwindcss/typography` plugin.
- Added `postcss.config.js` to manage the CSS pipeline.

### Changed
- Migrated from `@tailwindcss/vite` to `@tailwindcss/postcss` to support custom PostCSS plugins.
- Reorganized `src/style.css` to follow PostCSS `@import` order requirements.

## [1.9.0] - 2026-01-20
### Added
- Exhibit With Us page template (`page-templates/exhibit.php`) and component (`template-parts/components/exhibit-with-us.php`).
- New Show components: `video-slider.php` and `image-text.php`.
- `initVideoSlider` logic in `src/main.js`.
- Entrance animations for Megamenu in `site-navigation.php`.

### Changed
- Refined `Home Hero Slider`: adjusted autoplay speed and layout spacing.
- Refined `Interactive Select`: updated button hover states and background colors.
- Refined `Featured Gallery`: replaced placeholder images with demo assets.
- Refined `What's On`: adjusted typography and date tag positioning.
- Updated `site-header` layout with improved spacing (`gap-x-14`).
- Updated `content-single.php` to dynamically load new show components.

## [1.8.0] - 2026-01-20
### Added
- Single post template for 'Shows' (`single-shows.php`).
- Content template for single shows (`template-parts/shows/content-single.php`).
- Extensive library of Show components in `template-parts/shows/components/`:
    - `page-header.php`
    - `visitor-information.php`
    - `whats-on.php`
    - `exhibitors.php`
    - `exhibitor-detail.php`
    - `exhibitor-special.php`
    - `map-guide.php`
    - `gallery.php`
    - `win.php`
    - `two-columns-1.php`
- New styles in `src/css/components.css`.

### Changed
- Updated `site-navigation.php`.

## [1.7.0] - 2026-01-20
### Added
- CTA Promo component (`template-parts/components/cta-promo.php`).
- Modular Site Navigation (`template-parts/global/site-navigation.php`).
- Modular Site Footer (`template-parts/global/site-footer.php`).

### Changed
- Extracted navigation logic from `site-header.php` to `site-navigation.php`.
- Updated `footer.php` to use `template-parts/global/site-footer.php`.

## [1.6.0] - 2026-01-20
### Added
- Featured Gallery component (`template-parts/components/featured-gallery.php`).
- Integrated `@fancyapps/ui` (Fancybox) for lightbox functionality.
- Added Fancybox CSS import to `src/style.css`.
- Initialized Fancybox in `src/main.js`.

## [1.5.0] - 2026-01-20
### Added
- Subscribe component (`template-parts/components/subscribe.php`).

### Changed
- Updated `template-parts/components/shows-cards-grid.php`.

## [1.4.0] - 2026-01-20
### Added
- Dynamic scroll interaction for `site-header` (shrinking topbar, blurring background, resizing logo).
- ID attributes to header elements for JavaScript targeting.

### Changed
- Refactored `shows-cards-grid.php`:
    - Replaced fixed height `h-72` with dynamic `aspect-5/4`.
    - Repositioned card logos to bottom-left with `w-2/3` width.
    - Updated typography: removed `text-sm/xs`, switched to `font-semibold`.
    - Updated Tailwind syntax to v4 conventions.
- Updated header scroll logic to toggle `main-nav-wrapper` classes.

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
