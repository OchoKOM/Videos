const videoPlayer = document.querySelector(".vid");

videoPlayer.innerHTML = `${videoPlayer.innerHTML}
<div class="loader"></div>
<svg  class="webicon" style="height: 65px;"  viewBox="0 0 512 512">
    <path fill="#053f97" d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm74.77 217.3l-114.45 69.14a10.78 10.78 0 01-16.32-9.31V186.87a10.78 10.78 0 0116.32-9.31l114.45 69.14a10.89 10.89 0 010 18.6z"></path>
</svg>
<div class="controls">
<div class="overlay"></div>
  <div class="controls-top">
    <div class="volume-container active">
      <p>Reactiver le son</p>
      <button class="volume">
        <svg class="volume-high-icon" viewBox="0 0 48 48" >
            <path fill="currentColor" d="M28 41.45v-3.1q4.85-1.4 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4 10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24 8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27 32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>
        </svg> 
        <svg class="volume-muted-icon" viewBox="0 0 45 45" style="display:none;">
            <path fill="currentColor" d="m40.65 45.2-6.6-6.6q-1.4 1-3.025 1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425 2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8 43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2 1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2 1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3 14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
        </svg>
      </button>
    </div>
    <div class="btns-top">
      <button class="close-controls icon">
          <i>
          <svg viewBox="0 0 48 48" class="close-btn">
            <path  fill="currentColor" d="m12.45 37.65-2.1-2.1L21.9 24 10.35 12.45l2.1-2.1L24 21.9l11.55-11.55 2.1 2.1L26.1 24l11.55 11.55-2.1 2.1L24 26.1Z"/>
          </svg>
          </i>
          
      </button>
    </div>
  </div>
  <div class="controls-center">
    <button class="replay-10 little">
      <svg class="replay-icon" viewBox="0 0 48 48">
        <path fill="currentColor" d="M24 44q-3.75 0-7.025-1.4-3.275-1.4-5.725-3.85Q8.8 36.3 7.4 33.025 6 29.75 6 26h3q0 6.25 4.375 10.625T24 41q6.25 0 10.625-4.375T39 26q0-6.25-4.25-10.625T24.25 11h-1.1l3.65 3.65-2.1 2.1-7.35-7.35 7.35-7.35 2.05 2.05-3.9 3.9H24q3.75 0 7.025 1.4 3.275 1.4 5.725 3.85 2.45 2.45 3.85 5.725Q42 22.25 42 26q0 3.75-1.4 7.025-1.4 3.275-3.85 5.725-2.45 2.45-5.725 3.85Q27.75 44 24 44Zm-6-11.5V21.9h-2.7v-2.45h5.2V32.5Zm7.35 0q-.95 0-1.575-.625T23.15 30.3v-8.65q0-.95.625-1.575t1.575-.625h4.15q.95 0 1.575.625t.625 1.575v8.65q0 .95-.625 1.575T29.5 32.5Zm.3-2.5h3.55v-8.1h-3.55V30Z"/>
      </svg>
    </button>
    <button  class="playPause-btn">
        <svg class="play-btn" viewBox="0 0 24 24">
            <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
        </svg>
        <svg class="pause-btn" viewBox="0 0 48 48" style="display:none;">
            <path   fill="currentColor" d="M28.25 38V10H36v28ZM12 38V10h7.75v28Z"/>
        </svg>
        <svg class="replay-btn" viewBox="0 0 48 48" style="display:none;">
            <path   fill="currentColor"  d="M24 44q-3.75 0-7.025-1.4-3.275-1.4-5.725-3.85Q8.8 36.3 7.4 33.025 6 29.75 6 26h3q0 6.25 4.375 10.625T24 41q6.25 0 10.625-4.375T39 26q0-6.25-4.25-10.625T24.25 11H23.1l3.65 3.65-2.05 2.1-7.35-7.35 7.35-7.35 2.05 2.05-3.9 3.9H24q3.75 0 7.025 1.4 3.275 1.4 5.725 3.85 2.45 2.45 3.85 5.725Q42 22.25 42 26q0 3.75-1.4 7.025-1.4 3.275-3.85 5.725-2.45 2.45-5.725 3.85Q27.75 44 24 44Z"/>
        </svg>
    </button>
    <button class="skip-10 little">
        <svg class="skip-icon" viewBox="0 0 48 48">
            <path fill="currentColor" d="M18 32.5V21.9h-2.7v-2.45h5.2V32.5Zm7.35 0q-.95 0-1.575-.625T23.15 30.3v-8.65q0-.95.625-1.575t1.575-.625h4.15q.95 0 1.575.625t.625 1.575v8.65q0 .95-.625 1.575T29.5 32.5Zm.3-2.5h3.55v-8.1h-3.55V30ZM24 44q-3.75 0-7.025-1.4-3.275-1.4-5.725-3.85Q8.8 36.3 7.4 33.025 6 29.75 6 26q0-3.75 1.4-7.025 1.4-3.275 3.85-5.725 2.45-2.45 5.725-3.85Q20.25 8 24 8h1.05l-3.9-3.9 2.05-2.05 7.35 7.35-7.35 7.35-2.05-2.05 3.7-3.7H24q-6.25 0-10.625 4.375T9 26q0 6.25 4.375 10.625T24 41q6.25 0 10.625-4.375T39 26h3q0 3.75-1.4 7.025-1.4 3.275-3.85 5.725-2.45 2.45-5.725 3.85Q27.75 44 24 44Z"/>
        </svg>
    </button>
  </div>
  <div class="controls-bottom">
    <span class="current">0:00</span>
    <div class="bar">
        <div class="thumbnail"></div>
        <div class="progressAreaTime">0:00</div>
        <div class="juice"></div>
        <div class="buffered"></div>
    </div>

    <span class="duration">0:00</span>

    <button class="fullscreen-btn">
      <svg class="open" viewBox="0 0 24 24">
        <path
          fill="currentColor"
          d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"
        />
      </svg>
      <svg class="close" viewBox="0 0 24 24">
        <path
          fill="currentColor"
          d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"
        />
      </svg>
    </button>
  </div>
</div>
`;
