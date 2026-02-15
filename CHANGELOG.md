# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.26.0] - 2026-02-09
### Added
- New Modular Components:
    - `spacer.php`: Flexible spacer component with preset sizes, custom pixel values, and optional horizontal lines.
    - `text.php`: Standard text component for paragraph content with flexible HTML tags and styling.
    - `table.php`: Dynamic table component supporting 2-4 columns and multiple styling presets.
- Dynamic Icon System:
    - Integrated `heroicons` via npm.
    - Refactored `civ_add_heroicons_icons` in `inc/acf.php` to dynamically scan and populate icons.
    - Enhanced `civ_icon()` helper in `inc/template-tags.php` for robust SVG attribute injection and group mapping.

### Changed
- Refactored Buttons System:
    - Integrated icon support directly into `button.php`.
    - Refactored `buttons.php` repeater to delegate rendering to the single button component for better DRY compliance.
    - Added proportional icon sizing and customizable icon positioning.
- Optimized `icons_list.php`:
    - Implemented dynamic padding for circled icons based on size.
    - Refactored to use modular icon and typography settings.
- Refined Table Component:
    - Updated `table_title` to use the modular `text.php` component via ACF cloning.

## [1.25.0] - 2026-02-09
### Added
- Hierarchical Breadcrumbs in `page-header.php`:
    - Dynamically detects child pages and inserts a linked parent title into the breadcrumb trail.

### Changed
- Updated `page-header.php` logo sizing to `max-w-96` for better visual consistency.

## [1.24.0] - 2026-02-09
### Added
- Refactored `video.php` component:
    - Integrated with ACF `video` group supporting external and self-hosted sources.
    - Implemented native Tailwind CSS v4 responsive aspect-ratio container.
    - Added stable ID generation for specific element targeting.

### Changed
- Optimized `Visitor Information (Shows)` section:
    - Refined container spacing and padding for better responsive alignment.
- Refined `Component` Flexible Content field group:
    - Cleaned up redundant layouts and standardized naming.
    - Updated `Media Slider` and `Video` layout definitions to align with optimized component architecture.
- Site Header:
    - Updated navigation template part reference.

## [1.23.0] - 2026-02-09
### Added
- Dynamic Visitor Information (Shows) Section:
    - Implemented `visitor_information_shows.php` pulling data from ACF.
    - Integrated Google Maps API support for frontend display.
    - Integrated modular component support for the right column.
- Google Maps Integration:
    - Added `initGoogleMaps` logic in `src/main.js` to automatically render maps for `.acf-map` elements.
    - Added CSS fix for Google Maps images in `src/style.css`.
    - Configured script dependencies in `inc/enqueue.php` to ensure the Maps API is loaded before initialization.

### Changed
- Refined `Interactive Select` template to remove the default placeholder text.
- Enhanced `Featured Gallery` template with unique grouping for Fancybox lightboxes.

## [1.22.0] - 2026-02-09
### Added
- New Modular Components:
    - `background.php`: Centralized component for handling background images, colors, positions, and overlays.
    - `media_slider.php`: Refactored slider component supporting dynamic video (external/self-hosted) and image repeaters.
- New Dynamic Sections:
    - `shows_cards.php`: Fully dynamic grid section for show cards.
    - `subscribe.php`: Two-column subscription section with background and heading integration.
    - `featured_gallery.php`: Dynamic gallery support with unique lightbox grouping.
- Global Settings:
    - Modular background integration in `section-settings.php` using the new background component.

### Changed
- Refactored ACF Field Groups:
    - Standardized naming conventions for all Section and Component groups.
    - Refactored `Two Columns` section settings for improved layout control (ratios and max-width).
    - Added `font_weight` control to the `Heading` component.
- Component Optimizations:
    - `Image`: Updated for Tailwind CSS v4 native aspect-ratio and alignment.
    - `Heading`: Added support for dynamic font-weight mapping.
    - `Content Editor` & `Lead Text`: Enhanced with stable IDs and prose-specific color synchronization.
- JavaScript Enhancements:
    - Transitioned to instance-based initialization for `Media Slider` and `Interactive Select`.
    - Improved modularity by using class-scoped element selection.

## [1.21.0] - 2026-02-09
### Added
- Dynamic Home Hero Slider Section:
    - Fully refactored to use ACF `home_hero_slider` group and repeater.
    - Supports dynamic background images, overlays, and content per slide.
    - Integrated modular `button.php` component with parallax support.
- Dynamic Interactive Select Section:
    - Refactored to pull options and card data from ACF.
    - Implemented a JSON-based data passing mechanism to JavaScript.
    - Support for custom label text and colors.
- Architecture:
    - Updated `src/main.js` to support multiple instances of Interactive Select.
    - Switched from ID-based to class-based scoping in component JS for better modularity.

### Changed
- Enhanced `button.php` component to support custom HTML attributes via `$args['attributes']`.
- Optimized `content_editor.php`, `image.php`, and `lead_text.php` with stable IDs and improved Tailwind CSS v4 implementations.
- Refined `two_columns.php` section with automatic ID generation and improved layout ratios.

## [1.19.0] - 2026-02-09
### Added
- Stable ID generation system for modular components (Accordion, Heading, Buttons) using Post ID and static counters to ensure consistent CSS targeting.
- Advanced Accordion Component:
    - Support for custom colors (header, background, borders, icons) across default and opened states using CSS variables.
    - Improved accessibility and grouping with the `name` attribute.
- Enhanced Buttons Component:
    - Fully refactored for Tailwind CSS v4 (removed DaisyUI dependencies).
    - Support for nested ACF groups: Button Presets and Advanced Custom Styles.
    - New `button_rounded` option for granular control over border-radius.
    - Advanced custom styling with default and hover state color pickers.
    - Optimized layout with vertical alignment (`items-center`) and responsive gap handling.

### Changed
- Updated ACF field groups for Accordion and Buttons to support new design controls.
- Refined `components.php` to remove redundant margins, delegating spacing to sections.
- Updated `heading.php` to support stable element IDs.

## [1.18.0] - 2026-02-09
### Added
- Modular Page Builder system:
    - New `inc/page-builder.php` to handle flexible content rendering logic.
    - Integrated `page-builder.php` into `functions.php`.
    - New `page.php` template using the Page Builder.
    - New Section templates: `one_column.php` and `two_columns.php` in `template-parts/sections/`.
    - New Component system in `template-parts/components/components.php` for modular component rendering within sections.
    - New Heading component in `template-parts/components/heading.php`.
    - New global `section-settings.php` for shared section configurations (backgrounds, padding, etc.).
- Enhanced Background Settings:
    - Added "Background Overlay" color picker to section settings.
    - Support for background images and colors in `section-settings.php`.
- Flexible Column Settings:
    - Implemented alignment and max-width controls for columns in `one_column.php`.

### Changed
- Refactored ACF Flexible Content:
    - Renamed `section` field to `section_builder` for better clarity.
    - Refactored Column Settings into a dedicated group with improved field layout.
    - Updated Heading component to use Tailwind-based color defaults and removed redundant advanced settings.
- Admin UI Improvements:
    - Enhanced ACF Flexible Content styling in `admin-style.css` (better layout handles and active state highlighting).

## [1.17.0] - 2026-01-30
### Added
- Dynamic Header Logo in `template-parts/global/site-header.php` using ACF `header_logo` option field.
- Dynamic Site Navigation in `template-parts/global/site-navigation.php` using ACF `mega_menu` option field.
- Recursive Mega Menu rendering logic supporting:
    - Standard Mega Menus with featured content and dynamic headings.
    - Standard Dropdowns.
    - Dynamic dividers (`|`) between top-level items.

### Changed
- Updated `site-header.php` to use `home_url('/')` for the branding link.
- Refined `site-navigation.php` JS to correctly handle hover states for multiple dynamic menu items.

## [1.16.0] - 2026-01-20
### Added
- Admin Columns for Exhibitors:
    - Added "Exhibitor ID" column (sortable).
    - Added "Shows" column (clickable for filtering).
    - Added "Exhibitor Category" filter dropdown to admin list.
- CSS for admin columns (fixed width for ID).

### Changed
- Updated Exhibitors component (`exhibitors.php` & `card-exhibitor.php`) to match new ACF field structure (`exhibitor_identity`, `exhibitor_description`, `exhibitor_contact`).
- Reordered Exhibitor admin columns for better usability.

## [1.15.0] - 2026-01-20
### Added
- "Reset Filters" button to Exhibitors component.
- `checkFiltersState` logic in `main.js` to conditionally show/hide the reset button.
- Support for `postcss-prefix-selector` to scope ACF layouts.

### Changed
- Migrated admin stylesheets to use granular Tailwind v4 imports (no Preflight).
- Updated `page-header.php` logic for parent post inheritance.

## [1.14.0] - 2026-01-20
### Added
- AJAX "Load More" functionality (`inc/ajax-handlers.php`, `src/main.js`) with support for filtering.
- Reusable `card-exhibitor.php` template part.
- Filters logic for "New to the Show" and "Show Specials" (checking `tags` ACF field).
- Visual feedback (opacity transition) for grid filtering.

### Changed
- Refined Search Filter to target `post_title` only using `posts_search` hook.
- Removed Sub-Category filter dropdown from `exhibitors.php`.
- Corrected ACF field references in `exhibitors.php` (fixed typo in `exhibitor_bio`).

## [1.13.0] - 2026-01-20
### Added
- Dynamic Exhibitors Grid (`template-parts/shows/components/exhibitors.php`) powered by `WP_Query`.
- Frontend filtering logic in `src/main.js` (`initExhibitorFilters`) for dynamic sub-category population.
- Global `window.exhibitorCategories` object injection for category data.

### Changed
- Refactored `exhibitors.php` to use `WP_Query` and ACF fields (`phone_number`, `website_link`, `exhibitor_logo`).

## [1.12.0] - 2026-01-20
### Added
- Pushed full suite of demo images to `assets/images/demo/`.

### Fixed
- Updated `vite.config.js` to automatically delete the `hot` file when running `npm run build`, ensuring production mode is correctly triggered.

## [1.11.0] - 2026-01-20
### Changed
- Dynamic `page-header.php`:
    - Implemented parent-child navigation logic for 'Shows' post type.
    - Added dynamic logo display based on ACF settings.
    - Configured automatic inheritance of header settings (backgrounds, titles) from parent show pages.
    - Added active state styling for the current page in the secondary navigation.
- Refactored `inc/enqueue.php` to handle granular admin styles loading.

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
