// =============================================================================
// Modules: Scroll
// =============================================================================
// Establishes custom scrolling functionality allowing for anything from smooth
// scrolling to parallax elements right out of the box with use of 'Mighty Scroll'

// Import dependencies
// =============================================================================
import { module as es6Module } from 'modujs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Register plugins
// =============================================================================
gsap.registerPlugin(ScrollTrigger);

// Global ScrollTrigger configuration
ScrollTrigger.config({
  limitCallbacks: true,     // Limits the frequency of callbacks to improve performance
  ignoreMobileResize: true  // Prevents re-calculation of trigger positions on mobile resize
});

// Set default function and extend it ontop of our imported 'module'
// =============================================================================
export default class extends es6Module {

  constructor(m) {
    super(m);
  }

  // Init module
  // ===========================================================================
  init() {
    // Select all direct children with the attribute [data-scroll-trigger]
    const sections = this.el.querySelectorAll('[data-scroll-trigger]');

    // Loop through each section and create a ScrollTrigger for each
    sections.forEach(el => {
      // Initial state
      gsap.fromTo(el, {
          opacity: 0,
          y: 36
        }, {
          opacity: 1,
          y: 0,
          // stagger: 1, // Stagger the animation by 1 seconds for each `el`
          duration: 0.4, // Equals `$speed-slow` variable
          scrollTrigger: {
            trigger: el, // Each section triggers its own animation
            start: 'top 80%', // Start when the top of the section hits 80% of the viewport height
            end: 'bottom 20%', // End when the bottom of the section hits 20% of the viewport height
            toggleActions: 'play none none none' // Play on enter, reverse on leave
          }
        }
      );
    });
  }

}
