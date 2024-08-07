# Getting started
This boilerplate shows a few example techniques and structures, that ease the plugin development and maintenance for the future. This section outlines the technologies and structures used, and the reasoning behind their usage.

## TypeScript [.tsx | .ts]
This boilerplate uses TypeScript as typed programming language, giving us better tooling at scale. Furthermore using TypeScript ensures, that mistakes from wrong Component, Variable or Function usage can be prevented before pushing changes to the development branch.

To learn more about TypeScript and a QuickStart, see https://www.typescriptlang.org
A handy video for a quickstart: https://www.youtube.com/watch?v=ahCwqrYpIuM

## Webpack
For bundling scripts, styles and images, webpack is used. The underlying webpack configuration is imported from @wordpress/scripts, the default WordPress Plugin scaffold script. This boilerplate expands the default configuration, to allow the usage of additional EntryPoints. This allows us to convert traditional .ts and .tsx files that are outside block context, for example to interact with the blockEditor's Stores or to implement other functions, for example usage of the Formatting Toolbar API without Block implementation.

For more information regarding Webpack, see https://webpack.js.org
For more information regarding the @wordpress/scripts package, see https://www.npmjs.com/package/@wordpress/scripts
For more information regarding the RichText API, see https://developer.wordpress.org/block-editor/how-to-guides/format-api/

## WordPress React Components
For Block Development, we use the already existing WordPress React Component Library. WordPress Components offer a wide variety of already existing patterns. Selection fields, Modals and more can be all easily implemented, by importing the required package and using it inside the edit function of a block.

For a complete List of available WordPress components, see: 
- https://wordpress.github.io/gutenberg/?path=/docs/docs-introduction--page

RRZE Elements Blocks also offers a internal Component Library, which includes a dynamic FontAwesome IconPicker with visual preview. See https://github.com/RRZE-Webteam/rrze-elements-blocks/blob/main/src/components/IconPicker.tsx
Further individual built Components include:
- CustomMediaReplaceFlow – A component for image settings / image replacement (for example in the CTA block)
- Input Warning – A component to output a warning ad handy note
- IconPicker

### Why separate Components in a seperate Folder?
I recommend splitting up complicated Functional Parts of the Edit.tsx Files, to make them 1) Easy to use in newly built plugins 2) Easy to read. By using components instead of inline functions, we make our code easy to digest and already built functions or components can be easily copied from other plugins (for example the IconPicker from Elements-Blocks).

## Sass (SCSS)
For preprocessing inside the src-Folder, Sass is used. Webpack automatically converts the scss files to css, once `npm run start` or `npm run build` is executed.

## Testing with Playwright
For Testing, the WordPress Playwright E2E Testing Package can be used. An implementation can be found in the Elements-Blocks plugin. https://github.com/RRZE-Webteam/rrze-elements-blocks/blob/main/playwright.config.ts

That's all. Have fun extending and playing around with the template and example files.