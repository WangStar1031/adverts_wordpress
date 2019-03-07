=== Gutenberg ===
Contributors: matveb, joen, karmatosed
Requires at least: 5.0.0
Tested up to: 5.0
Stable tag: 5.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A new editing experience for WordPress is in the works, with the goal of making it easier than ever to make your words, pictures, and layout look just right. This is the beta plugin for the project.

== Description ==

Gutenberg is more than an editor. While the editor is the focus right now, the project will ultimately impact the entire publishing experience including customization (the next focus area).

<a href="https://wordpress.org/gutenberg">Discover more about the project</a>.

= Editing focus =

> The editor will create a new page- and post-building experience that makes writing rich posts effortless, and has “blocks” to make it easy what today might take shortcodes, custom HTML, or “mystery meat” embed discovery. — Matt Mullenweg

One thing that sets WordPress apart from other systems is that it allows you to create as rich a post layout as you can imagine -- but only if you know HTML and CSS and build your own custom theme. By thinking of the editor as a tool to let you write rich posts and create beautiful layouts, we can transform WordPress into something users _love_ WordPress, as opposed something they pick it because it's what everyone else uses.

Gutenberg looks at the editor as more than a content field, revisiting a layout that has been largely unchanged for almost a decade.This allows us to holistically design a modern editing experience and build a foundation for things to come.

Here's why we're looking at the whole editing screen, as opposed to just the content field:

1. The block unifies multiple interfaces. If we add that on top of the existing interface, it would _add_ complexity, as opposed to remove it.
2. By revisiting the interface, we can modernize the writing, editing, and publishing experience, with usability and simplicity in mind, benefitting both new and casual users.
3. When singular block interface takes center stage, it demonstrates a clear path forward for developers to create premium blocks, superior to both shortcodes and widgets.
4. Considering the whole interface lays a solid foundation for the next focus, full site customization.
5. Looking at the full editor screen also gives us the opportunity to drastically modernize the foundation, and take steps towards a more fluid and JavaScript powered future that fully leverages the WordPress REST API.

= Blocks =

Blocks are the unifying evolution of what is now covered, in different ways, by shortcodes, embeds, widgets, post formats, custom post types, theme options, meta-boxes, and other formatting elements. They embrace the breadth of functionality WordPress is capable of, with the clarity of a consistent user experience.

Imagine a custom “employee” block that a client can drag to an About page to automatically display a picture, name, and bio. A whole universe of plugins that all extend WordPress in the same way. Simplified menus and widgets. Users who can instantly understand and use WordPress  -- and 90% of plugins. This will allow you to easily compose beautiful posts like <a href="http://moc.co/sandbox/example-post/">this example</a>.

Check out the <a href="https://wordpress.org/gutenberg/handbook/reference/faq/">FAQ</a> for answers to the most common questions about the project.

= Compatibility =

Posts are backwards compatible, and shortcodes will still work. We are continuously exploring how highly-tailored metaboxes can be accommodated, and are looking at solutions ranging from a plugin to disable Gutenberg to automatically detecting whether to load Gutenberg or not. While we want to make sure the new editing experience from writing to publishing is user-friendly, we’re committed to finding  a good solution for highly-tailored existing sites.

= The stages of Gutenberg =

Gutenberg has three planned stages. The first, aimed for inclusion in WordPress 5.0, focuses on the post editing experience and the implementation of blocks. This initial phase focuses on a content-first approach. The use of blocks, as detailed above, allows you to focus on how your content will look without the distraction of other configuration options. This ultimately will help all users present their content in a way that is engaging, direct, and visual.

These foundational elements will pave the way for stages two and three, planned for the next year, to go beyond the post into page templates and ultimately, full site customization.

Gutenberg is a big change, and there will be ways to ensure that existing functionality (like shortcodes and meta-boxes) continue to work while allowing developers the time and paths to transition effectively. Ultimately, it will open new opportunities for plugin and theme developers to better serve users through a more engaging and visual experience that takes advantage of a toolset supported by core.

= Contributors =

Gutenberg is built by many contributors and volunteers. Please see the full list in <a href="https://github.com/WordPress/gutenberg/blob/master/CONTRIBUTORS.md">CONTRIBUTORS.md</a>.

== Frequently Asked Questions ==

= How can I send feedback or get help with a bug? =

We'd love to hear your bug reports, feature suggestions and any other feedback! Please head over to <a href="https://github.com/WordPress/gutenberg/issues">the GitHub issues page</a> to search for existing issues or open a new one. While we'll try to triage issues reported here on the plugin forum, you'll get a faster response (and reduce duplication of effort) by keeping everything centralized in the GitHub repository.

= How can I contribute? =

We’re calling this editor project "Gutenberg" because it's a big undertaking. We are working on it every day in GitHub, and we'd love your help building it.You’re also welcome to give feedback, the easiest is to join us in <a href="https://make.wordpress.org/chat/">our Slack channel</a>, `#core-editor`.

See also <a href="https://github.com/WordPress/gutenberg/blob/master/CONTRIBUTING.md">CONTRIBUTING.md</a>.

= Where can I read more about Gutenberg? =

- <a href="http://matiasventura.com/post/gutenberg-or-the-ship-of-theseus/">Gutenberg, or the Ship of Theseus</a>, with examples of what Gutenberg might do in the future
- <a href="https://make.wordpress.org/core/2017/01/17/editor-technical-overview/">Editor Technical Overview</a>
- <a href="https://wordpress.org/gutenberg/handbook/reference/design-principles/">Design Principles and block design best practices</a>
- <a href="https://github.com/Automattic/wp-post-grammar">WP Post Grammar Parser</a>
- <a href="https://make.wordpress.org/core/tag/gutenberg/">Development updates on make.wordpress.org</a>
- <a href="https://wordpress.org/gutenberg/handbook/">Documentation: Creating Blocks, Reference, and Guidelines</a>
- <a href="https://wordpress.org/gutenberg/handbook/reference/faq/">Additional frequently asked questions</a>


== Changelog ==

Bug fixes in 5.1.1:

- Fixes a Firefox regression causing block content to be deleted.

Features:

- Add a new Search block.
- Add a new Calendar block.
- Add a new Tag Cloud block.

Enhancements:

- Add micro-animations to the editor UI:
  - Opening Popovers.
  - Opening Sidebars.
- Restore the block movers for the floated blocks.
- Consistency in alignment options between archives and categories blocks.
- Set the minimum size for form fields on mobile.
- Disable the block navigation in the code editor mode.
- Consistency for the modal styles.
- Improve the FormToggle styling when used outside of WordPress context.
- Use the block icons in the media placeholders.
- Fix rounded corners for the block svg icons.
- Improve the CSS specificity of the paragraph block styles.
- Require an initial click on embed previews before being interactive.
- Improve the disabled block switcher styles.
- Do not split paragraph line breaks when transforming multiple paragraphs to a list.
- Enhance the Quote block styling for different text alignments.
- Remove the left padding from the Quote block when it’s centered.
- A11y:
  - Improve the permalink field label.
  - Improve the region navigation styling.
- Remove the 3 keywords limit for the block registration.
- Add consistent background colors to the hovered menu items.
- Allow the editor notices to push down the content.
- Rename the default block styles.

Bug Fixes:

- Fix a number of formatting issues:
  - Multiple formats.
  - Flashing backgrounds when typing.
  - Highlighted format buttons.
  - Inline code with backticks.
  - Spaces deleted after formats.
  - Inline boundaries styling issues.
  - Touch Bar format buttons.
- Fix a number of list block writing flow issues:
  - Allow line breaks in list items.
  - Empty items not being removed.
  - Backspace merging list items.
  - Selecting formats at the beginning of list items.
- Fix the color picker styling.
- Set default values for the image dimensions inputs.
- Fix sidebar panels spacing.
- Fix wording of the nux tip nudging about the sidebar settings.
- Fix the translator comments pot extraction.
- Fix the plugins icons color overriding.
- Fix conflicting notices styles when using editor styles.
- Fix controls recursion in the redux-routine package.
- Fix the generic embed block when using Giphy as provider.
- Fix the i18n message used in the Gallery block edit button.
- Fix the icon size of the block switcher menu.
- Fix the loading state of the FlatTermSelector (tags selector).
- Fix the embed placeholders styling.
- Fix incorrectly triggered auto-saves for published posts.
- Fix missing classname in the Latest comments block.
- Fix HTML in shortcodes breaking block validation.
- Fix JavaScript errors when typing quickly and creating undo levels.
- Fix issue with mover colors in dark themes.
- Fix internationalisation issue with permalink slugs.

Various:

- Implement the inline format boundaries without relying on the DOM.
- Introduce the Registry Selectors in the data module.
- Introduce the Registry Controls in the data module.
- Allow extending the latest posts block query by using get_posts.
- Extend the range of allowed years in the DateTime component.
- Allow null values for the DateTime component.
- Do not render the FontSizePicker if no sizes defined.
- Add className prop support to the UrlInput component.
- Add inline image resizing UI.

Chore:

- Update lodash and deasync dependencies.
- Use addQueryArgs consistently to generate WordPress links.
- Remove merged PHP code (partial).
- Disable CSS animations in e2e tests.
- Add ESLint rules to:
  - ensure the consistency of the import groups.
  - protect against invalid sprintf use.
- Add e2e tests for tags creation.
- Add the feature flags setup.
- Implement block editor styles using a filter.

Documentation:

- Add a new tutorial about the editor notices.
- Add JavaScript build tools documentation.
- Enhance the block’s edit/save documentation and code examples.
- Add e2e test utils documentation.

Mobile:

- Add bottom sheet settings for the image block.
- Implement the media upload options sheet.
- Implementing Clear All Settings button on Image Settings.
- Avoid hard-coded font family styling for the image blocks.
- Improve the post title component.
- Fix the bottom sheet styling for RTL layouts.
- Support the placeholder prop in the RichText component.
