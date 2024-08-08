// =============================================================================
// Modules: Fitty.js
// =============================================================================
// Scales up (or down) text so it fits perfectly to its parent container.
// Ideal for flexible and responsive websites.

// Import dependencies
// =============================================================================
import { module as es6Module } from 'modujs';
import fitty from 'fitty';

// Set default function and extend it ontop of our imported 'module'
// =============================================================================
export default class extends es6Module {

  // Set initial values
  // =========================================================================
  constructor(m) {
    super(m);

    // Default
    this.headline = null;
  }

  // Init module
  // =========================================================================
  init() {
    // Assign stretched headline
    this.headline = this.el;

    // Stretch
    fitty(this.headline);
  }

  // Destroy
  // =========================================================================
  destroy() {}
}
