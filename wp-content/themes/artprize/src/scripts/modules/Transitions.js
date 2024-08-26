// =============================================================================
// Modules: Transitions
// =============================================================================
// Page transitions to be integrated with modularLoad

// Import dependencies
// =============================================================================
import { module as es6Module } from 'modujs';
// import modularLoad from 'modularload';

// Set default function and extend it ontop of our imported 'module'
// =============================================================================
export default class extends es6Module {
  // Set initial values
  // =========================================================================
  constructor(m) {
    super(m);
  }

  // Init module
  // =========================================================================
  init() {
    // Animate transition in when the page loads
    this.transitionIn();

    // Attach event listeners to internal links
    this.$links = document.querySelectorAll('a');

    this.$links.forEach(link => {
      link.addEventListener('click', (event) => {
        if (this.isInternalLink(link)) {
          event.preventDefault(); // Prevent the default link behavior

          // Start the transition out animation
          this.transitionOut(link.href);
        }
      });
    });
  }

  // Check if a link is internal
  // =========================================================================
  isInternalLink(link) {
    return link.hostname === window.location.hostname && !link.href.includes('#') && !link.hasAttribute('target');
  }

  // Animate the transition out
  // =========================================================================
  transitionOut(href) {
    const page = document.getElementById('page');
    page.style.transition = 'opacity 0.5s'; // Adjust timing to your needs
    page.style.opacity = '0';

    // Wait for the transition to complete before navigating
    setTimeout(() => {
      window.location.href = href;
    }, 500); // Match this to your transition duration
  }

  // Animate the transition in
  // =========================================================================
  transitionIn() {
    const page = document.getElementById('page');
    page.style.opacity = '0';
    page.style.transition = 'opacity 0.5s'; // Adjust timing to your needs

    setTimeout(() => {
      page.style.opacity = '1';
    }, 100); // Start the fade-in after a short delay
  }

  // Destroy
  // =========================================================================
  destroy() {}
}
