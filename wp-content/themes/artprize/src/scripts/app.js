// =============================================================================
// App
// =============================================================================
// This file is the centerpiece of the javascript front end and kicks it all of
// on load.

// Import dependencies
// =============================================================================
import modular from 'modujs';
import modularLoad from 'modularload';
import * as modules from './modules';
import globals from './globals';
import { html } from './utils/environment';

// Run a new modular instance
// =============================================================================
const app = new modular({
  // Set to the modules imported above
  modules: modules
});

// Initialize the modularLoad instance
// =========================================================================
const load = new modularLoad({
  enterDelay: 100, // Adjust this as necessary
  // loadedClass: 'is-loaded',
  // enterClass: 'is-entering'
});

// Init our app
// =========================================================================
window.addEventListener('load', (event) => {
  const $style = document.getElementById('main-css');

  if ($style) {
    init();
  } else {
    $style.addEventListener('load', (event) => {
      init();
    });
  }
});

function init() {
  // Delay site init
  setTimeout(() => {
    globals();
    app.init(app);

    load.init(); // Initialize modularLoad

    // Hide the loader and show the site content
    const loader = document.getElementById('loader');
    const page = document.getElementById('page');

    loader.style.opacity = '0';
    setTimeout(() => {
      loader.style.display = 'none';
      page.style.display = 'block';
      html.classList.add('is-loaded', 'is-ready', 'has-js');
      html.classList.remove('is-loading', 'no-js');
    }, 300);  // Adjust this timeout to match the fade-out duration
  }, 300);
}

// // Optional: Handling new content being loaded dynamically
// load.on('loaded', (container) => {
//   app.init(app, container); // Reinitialize modules within the new container
// });
