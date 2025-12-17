
<svg viewBox="0 0 80 180" width="auto" height="auto" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="linearGradient" x1="0%" y1="0%" x2="100%" y2="0%" gradientunits="userSpaceOnUse">
            <stop offset="0%" stop-color="#002627ff"/>
            <stop offset="50%" stop-color="#023031"/>
            <stop offset="100%" stop-color="#94d4bdff"/>
        </linearGradient>

        <linearGradient id="rattleGradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="#023031"/>
            <stop offset="100%" stop-color="#00A86B"/>
        </linearGradient>
    </defs>
  <!-- Tail + rattles as a single unit -->
  <g id="snake-tail" transform="translate(0,0)">
    <!-- Tail segments -->
    <line class="seg" x1="40" y1="50" x2="40" y2="65" stroke="url(#linearGradient)" stroke-width="11" stroke-linecap="round"/>
    <line class="seg" x1="40" y1="65" x2="41" y2="80" stroke="url(#linearGradient)" stroke-width="12" stroke-linecap="round"/>
    <line class="seg" x1="41" y1="80" x2="41" y2="95" stroke="url(#linearGradient)" stroke-width="13" stroke-linecap="round"/>
    <line class="seg" x1="41" y1="95" x2="40.5" y2="110" stroke="url(#linearGradient)" stroke-width="14" stroke-linecap="round"/>
    <line class="seg" x1="40.5" y1="110" x2="41" y2="125" stroke="url(#linearGradient)" stroke-width="15" stroke-linecap="round"/>
    <line class="seg" x1="41" y1="125" x2="40" y2="140" stroke="url(#linearGradient)" stroke-width="16" stroke-linecap="round"/>
    <line class="seg" x1="40" y1="140" x2="40" y2="155" stroke="url(#linearGradient)" stroke-width="17" stroke-linecap="round"/>

    <!-- Rattles -->
    <g id="rattles" transform="translate(0,0)">
      <rect x="34" y="44" width="6" height="6" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="44" width="6" height="6" fill="url(#rattleGradient)" rx="1"/>
      <rect x="34.5" y="40" width="5.5" height="5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="40" width="5.5" height="5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="35" y="36" width="5" height="5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="36" width="5" height="5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="35.5" y="32" width="4.5" height="4.5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="32" width="4.5" height="4.5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="36" y="28.5" width="4" height="4.5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="28.5" width="4" height="4.5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="36.5" y="25" width="3.5" height="4" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="25" width="3.5" height="4" fill="url(#rattleGradient)" rx="1"/>
      <rect x="37" y="21.4" width="3" height="4" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="21.4" width="3" height="4" fill="url(#rattleGradient)" rx="1"/>
      <rect x="37.5" y="19" width="2.5" height="3.5" fill="url(#rattleGradient)" rx="1"/>        
      <rect x="40" y="19" width="2.5" height="3.5" fill="url(#rattleGradient)" rx="1"/>
      <rect x="38" y="16.5" width="2" height="3" fill="url(#rattleGradient)" rx="1"/>
      <rect x="40" y="16.5" width="2" height="3" fill="url(#rattleGradient)" rx="1"/>
    </g>
  </g>

  <style>
    /* smooth snake wave */
    .seg {
      transform-origin: center bottom;
      animation: slither 0.65s infinite ease-in-out;
    }

    /* delay per segment to make rolling wave from base to rattles */

    .seg:nth-child(1) { animation-delay: 0.30s; }
    .seg:nth-child(2) { animation-delay: 0.24s; }
    .seg:nth-child(3) { animation-delay: 0.18s; }
    .seg:nth-child(4) { animation-delay: 0.12s; }
    .seg:nth-child(5) { animation-delay: 0.06s; }
    .seg:nth-child(6) { animation-delay: 0.03s; }
    .seg:nth-child(7) { animation-delay: 0s; }

    /* rattles move with the last segment, no separate anim */
    #rattles {
      transform-origin: center bottom;
      animation: slither .65s infinite ease-in-out;
      animation-delay: 0.30s; /* synced with smallest tail segment */
    }

    @keyframes slither {
      0%   { transform: rotate(0deg); }
      25%  { transform: rotate(1.4deg); }
      50%  { transform: rotate(-1.4deg); }
      75%  { transform: rotate(0.9deg); }
      100% { transform: rotate(0deg); }
    }
  </style>
</svg>
