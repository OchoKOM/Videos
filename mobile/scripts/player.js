const videoPlayer = document.querySelector(".videoPlayer");
const videoId = document.getElementById('video_id').value;
videoPlayer.innerHTML = `${videoPlayer.innerHTML}
<span class="ochovid" title="Voir sur OchoVid" data-link="time" data-url="time">
    <a href="./watch?v=${videoId}" target="_blank"></a>
</span>
<svg class="loader" viewBox="25 25 50 50" stroke-width="5">
  <circle cx="50" cy="50" r="20" />
</svg>
<svg  class="webicon" style="height: 65px;"  viewBox="0 0 512 512">
    <path fill="#c6deff" d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm74.77 217.3l-114.45 69.14a10.78 10.78 0 01-16.32-9.31V186.87a10.78 10.78 0 0116.32-9.31l114.45 69.14a10.89 10.89 0 010 18.6z"></path>
</svg>

<div class="counter">
  <div class="count">
    <div class="next-video">
      <div class="next-poster">
        <p>Prochaine video</p>
        <img src="" alt="">
      </div>
      <div class="next-title">
        <h3> Titre Titre Titre Titre Titre </h3>
        <h4> User </h4>
      </div>
    </div>
    <div class="nxtBtns">
        <input type="button" class="btn" value="Annuler" onclick="replay()">
        <input type="button" class="btn btn-dark" value="Regarder" onclick="next()">
    </div>
  </div>
</div>
<div class="caption_text"></div>
<div class="controls active">
  <div class="overlay"></div>
  <div class="controls-top">
    <div class="volume-container">
      <p class="vol">Reactiver le son</p>
      <button class="volume">
        <svg class="volume-high-icon" viewBox="0 0 48 48">
            <path fill="currentColor" d="M28 41.45v-3.1q4.85-1.4 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4 10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24 8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27 32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>
        </svg> 
        <svg class="volume-muted-icon" viewBox="0 0 45 45">
            <path fill="currentColor" d="m40.65 45.2-6.6-6.6q-1.4 1-3.025 1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425 2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8 43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2 1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2 1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3 14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
        </svg>
      </button>
    </div>
    
    <div class="btns-top">
      <div class="autoplay-btn">
        <span class="fa autoplay"></span>
      </div>
      <button class="icon closed-caption">
        <svg  class="fabtn nocaption" id="captionOff" viewBox="0 0 48 48" style="width: 100%">
            <path fill="currentColor" d="M9 40q-1.2 0-2.1-.9Q6 38.2 6 37V11q0-1.2.9-2.1Q7.8 8 9 8h30q1.2 0 2.1.9.9.9.9 2.1v26q0 1.2-.9 2.1-.9.9-2.1.9Zm0-3h30V11H9v26Zm4.5-7.05h7.1q.65 0 1.075-.425.425-.425.425-1.075v-2.1h-2.5v1.1h-5.1v-6.9h5.1v1.1h2.5v-2.1q0-.65-.425-1.075-.425-.425-1.075-.425h-7.1q-.65 0-1.075.425Q12 18.9 12 19.55v8.9q0 .65.425 1.075.425.425 1.075.425Zm13.95 0h7.1q.6 0 1.05-.45.45-.45.45-1.05v-2.1h-2.5v1.1h-5.1v-6.9h5.1v1.1h2.5v-2.1q0-.6-.45-1.05-.45-.45-1.05-.45h-7.1q-.6 0-1.05.45-.45.45-.45 1.05v8.9q0 .6.45 1.05.45.45 1.05.45ZM9 37V11v26Z"/>
          </svg>
        </i>
    </button>
    <button class="settingsBtn little">
        <i>
        <svg viewBox="0 0 48 48" class="settings-btn">
          <path
            fill="currentColor"
            d="m19.4 44-1-6.3q-.95-.35-2-.95t-1.85-1.25l-5.9 2.7L4 30l5.4-3.95q-.1-.45-.125-1.025Q9.25 24.45 9.25 24q0-.45.025-1.025T9.4 21.95L4 18l4.65-8.2 5.9 2.7q.8-.65 1.85-1.25t2-.9l1-6.35h9.2l1 6.3q.95.35 2.025.925Q32.7 11.8 33.45 12.5l5.9-2.7L44 18l-5.4 3.85q.1.5.125 1.075.025.575.025 1.075t-.025 1.05q-.025.55-.125 1.05L44 30l-4.65 8.2-5.9-2.7q-.8.65-1.825 1.275-1.025.625-2.025.925l-1 6.3ZM24 30.5q2.7 0 4.6-1.9 1.9-1.9 1.9-4.6 0-2.7-1.9-4.6-1.9-1.9-4.6-1.9-2.7 0-4.6 1.9-1.9 1.9-1.9 4.6 0 2.7 1.9 4.6 1.9 1.9 4.6 1.9Zm0-3q-1.45 0-2.475-1.025Q20.5 25.45 20.5 24q0-1.45 1.025-2.475Q22.55 20.5 24 20.5q1.45 0 2.475 1.025Q27.5 22.55 27.5 24q0 1.45-1.025 2.475Q25.45 27.5 24 27.5Zm0-3.5Zm-2.2 17h4.4l.7-5.6q1.65-.4 3.125-1.25T32.7 32.1l5.3 2.3 2-3.6-4.7-3.45q.2-.85.325-1.675.125-.825.125-1.675 0-.85-.1-1.675-.1-.825-.35-1.675L40 17.2l-2-3.6-5.3 2.3q-1.15-1.3-2.6-2.175-1.45-.875-3.2-1.125L26.2 7h-4.4l-.7 5.6q-1.7.35-3.175 1.2-1.475.85-2.625 2.1L10 13.6l-2 3.6 4.7 3.45q-.2.85-.325 1.675-.125.825-.125 1.675 0 .85.125 1.675.125.825.325 1.675L8 30.8l2 3.6 5.3-2.3q1.2 1.2 2.675 2.05Q19.45 35 21.1 35.4Z"
          />
        </svg>
        </i>
    </button>
    <button class="close-controls little">
        <i>
        <svg viewBox="0 0 48 48" class="close-btn">
          <path  fill="currentColor" d="m12.45 37.65-2.1-2.1L21.9 24 10.35 12.45l2.1-2.1L24 21.9l11.55-11.55 2.1 2.1L26.1 24l11.55 11.55-2.1 2.1L24 26.1Z"/>
        </svg>
        </i> 
    </button>
    </div>
  </div>
  <div class="controls-center">
    <button class="prev-btn little dk">
        <svg class="prev-icon" viewBox="0 0 48 48">
            <path fill="currentColor" d="M11 36V12h3v24Zm26 0L19.7 24 37 12Zm-3-12Zm0 6.25v-12.5L24.95 24Z"/>
        </svg>
    </button>
    <button class="replay-10 little dk" style="--sk:-80px;">
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
    <button class="skip-10 little dk" style="--sk:calc(100vw - 160px);">
        <svg class="skip-icon" viewBox="0 0 48 48">
            <path fill="currentColor" d="M18 32.5V21.9h-2.7v-2.45h5.2V32.5Zm7.35 0q-.95 0-1.575-.625T23.15 30.3v-8.65q0-.95.625-1.575t1.575-.625h4.15q.95 0 1.575.625t.625 1.575v8.65q0 .95-.625 1.575T29.5 32.5Zm.3-2.5h3.55v-8.1h-3.55V30ZM24 44q-3.75 0-7.025-1.4-3.275-1.4-5.725-3.85Q8.8 36.3 7.4 33.025 6 29.75 6 26q0-3.75 1.4-7.025 1.4-3.275 3.85-5.725 2.45-2.45 5.725-3.85Q20.25 8 24 8h1.05l-3.9-3.9 2.05-2.05 7.35 7.35-7.35 7.35-2.05-2.05 3.7-3.7H24q-6.25 0-10.625 4.375T9 26q0 6.25 4.375 10.625T24 41q6.25 0 10.625-4.375T39 26h3q0 3.75-1.4 7.025-1.4 3.275-3.85 5.725-2.45 2.45-5.725 3.85Q27.75 44 24 44Z"/>
        </svg>
    </button>
    <button class="next-btn little dk">
        <svg class="next-icon" viewBox="0 0 48 48">
            <path fill="currentColor" d="M34 36V12h3v24Zm-23 0V12l17.3 12Zm3-12Zm0 6.25L23.05 24 14 17.75Z"/>
        </svg>
    </button>
  </div>
  <div class="controls-bottom">
    <div class="bt-top">
      <div class="vd-time">
        <span class="current">0:00</span>
        <span class="current">/</span>
        <span class="duration">0:00</span>
      </div>
      <div class="vd-c">
        <button class="volume" style="width:30px;height:30px;">
          <svg class="volume-high-icon" viewBox="0 0 48 48">
              <path fill="currentColor" d="M28 41.45v-3.1q4.85-1.4 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4 10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24 8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27 32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>
          </svg> 
          <svg class="volume-muted-icon" viewBox="0 0 45 45">
              <path fill="currentColor" d="m40.65 45.2-6.6-6.6q-1.4 1-3.025 1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425 2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8 43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2 1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2 1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3 14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
          </svg>
        </button>
        <button class="fullscreen-btn little">
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
    <div class="bar">
        <div class="thumbnail"></div>
        <div class="progressAreaTime">0:00</div>
        <div class="juice"></div>
        <canvas class="bufferedBar"></canvas>
    </div>
  </div>
  </div>
</div>
  <div class="context-menu">
<div class="wrapper">
<div class="cls"></div>
  <ul class="context-menu-bar">
  <li class="loop-line">
    <div class="icon myicons">
      <span id="loopToggle">
        <svg class="fabtn noloop" id="loopOff" viewBox="0 0 48 48" style="width: 100%">
          <path fill="currentColor" d="m14 44-8-8 8-8 2.1 2.2-4.3 4.3H35v-8h3v11H11.8l4.3 4.3Zm9.3-14.1v-9.45h-2.8V18h5.25v11.9ZM10 21.5v-11h26.2l-4.3-4.3L34 4l8 8-8 8-2.1-2.2 4.3-4.3H13v8Z"></path>
        </svg>
        <svg class="fabtn loop" id="loopOn" viewBox="0 0 48 48">
          <path fill="currentColor" d="M5 46q-1.2 0-2.1-.9Q2 44.2 2 43V5q0-1.2.9-2.1Q3.8 2 5 2h38q1.2 0 2.1.9.9.9.9 2.1v38q0 1.2-.9 2.1-.9.9-2.1.9Zm9-2 2.1-2.2-4.3-4.3H38v-11h-3v8H11.8l4.3-4.3L14 28l-8 8Zm9.3-14.1h2.45V18H20.5v2.45h2.8ZM10 21.5h3v-8h23.2l-4.3 4.3L34 20l8-8-8-8-2.1 2.2 4.3 4.3H10Z"></path>
        </svg>
      </span>
    </div>
    Lire en boucle
  </li>
    <li class="copy-link" >
      <div class="icon myicons">
        <span>
          <svg class="fabtn" viewBox="0 96 960 960">
            <path  fill="currentColor" d="M450 776H280q-83 0-141.5-58.5T80 576q0-83 58.5-141.5T280 376h170v60H280q-58.333 0-99.167 40.765-40.833 40.764-40.833 99Q140 634 180.833 675q40.834 41 99.167 41h170v60ZM325 606v-60h310v60H325Zm185 170v-60h170q58.333 0 99.167-40.765 40.833-40.764 40.833-99Q820 518 779.167 477 738.333 436 680 436H510v-60h170q83 0 141.5 58.5T880 576q0 83-58.5 141.5T680 776H510Z"/>
          </svg>
        </span>
      </div>
      Copier l'URL de la vidéo
    </li>
    <li class="copy-seq" >
      <div class="icon myicons">
        <span>
          <svg class="fabtn" viewBox="0 96 960 960">
            <path  fill="currentColor" d="M450 776H280q-83 0-141.5-58.5T80 576q0-83 58.5-141.5T280 376h170v60H280q-58.333 0-99.167 40.765-40.833 40.764-40.833 99Q140 634 180.833 675q40.834 41 99.167 41h170v60ZM325 606v-60h310v60H325Zm185 170v-60h170q58.333 0 99.167-40.765 40.833-40.764 40.833-99Q820 518 779.167 477 738.333 436 680 436H510v-60h170q83 0 141.5 58.5T880 576q0 83-58.5 141.5T680 776H510Z"/>
          </svg>
        </span>
      </div>
      Copier l'URL de la séquence
    </li>
    <li class="copy-iframe" >
      <div class="icon myicons">
        <span>
          <svg class="fabtn" viewBox="0 96 960 960">
            <path fill="currentColor" d="M320 814 80 574l242-242 43 43-199 199 197 197-43 43Zm318 2-43-43 199-199-197-197 43-43 240 240-242 242Z"/>
          </svg>
        </span>
      </div>
      Copier le code d'intégration
    </li>
  </ul>
  
  </div>
  
</div>
  <div class="settings">
    <div class="wrapper">
        <div class="cls"></div>
      <ul class="menu-bar">
        <li class="quality-item drop-item" data-drop="quality-drop">
          <div class="icon myicons">
            <span >
              <svg class="fabtn" viewBox="0 0 48 48">
                <path fill="currentColor" d="M21.35 42V30.75h3v4.15H42v3H24.35V42ZM6 37.9v-3h12.35v3Zm9.35-8.3v-4.1H6v-3h9.35v-4.2h3v11.3Zm6-4.1v-3H42v3Zm8.3-8.25V6h3v4.1H42v3h-9.35v4.15ZM6 13.1v-3h20.65v3Z"/>
              </svg>
            </span>
          </div>
          Qualité
          <div class="icon arrow">
            <svg viewBox="0 0 48 48">
              <path
                fill="currentColor"
                d="m15.2 43.9-2.8-2.85L29.55 23.9 12.4 6.75l2.8-2.85 20 20Z"
              />
            </svg>
          </div>
        </li>
        <li class="quality-item drop-item" data-drop="captions-drop">
          <div class="icon myicons">
            <span >
            <svg  class="fabtn nocaption" id="captionOff" viewBox="0 0 48 48" style="width: 100%">
              <path fill="currentColor" d="M9 40q-1.2 0-2.1-.9Q6 38.2 6 37V11q0-1.2.9-2.1Q7.8 8 9 8h30q1.2 0 2.1.9.9.9.9 2.1v26q0 1.2-.9 2.1-.9.9-2.1.9Zm0-3h30V11H9v26Zm4.5-7.05h7.1q.65 0 1.075-.425.425-.425.425-1.075v-2.1h-2.5v1.1h-5.1v-6.9h5.1v1.1h2.5v-2.1q0-.65-.425-1.075-.425-.425-1.075-.425h-7.1q-.65 0-1.075.425Q12 18.9 12 19.55v8.9q0 .65.425 1.075.425.425 1.075.425Zm13.95 0h7.1q.6 0 1.05-.45.45-.45.45-1.05v-2.1h-2.5v1.1h-5.1v-6.9h5.1v1.1h2.5v-2.1q0-.6-.45-1.05-.45-.45-1.05-.45h-7.1q-.6 0-1.05.45-.45.45-.45 1.05v8.9q0 .6.45 1.05.45.45 1.05.45ZM9 37V11v26Z"/>
            </svg>
            </span>
          </div>
          Sous-titres
          <div class="icon arrow">
            <svg viewBox="0 0 48 48">
              <path
                fill="currentColor"
                d="m15.2 43.9-2.8-2.85L29.55 23.9 12.4 6.75l2.8-2.85 20 20Z"
              />
            </svg>
          </div>
        </li>
        <li class="loop-line">
          <div class="icon myicons">
          <span id="loopToggle">
          <svg class="fabtn noloop" id="loopOff" viewBox="0 0 48 48" style="width: 100%">
            <path fill="currentColor" d="m14 44-8-8 8-8 2.1 2.2-4.3 4.3H35v-8h3v11H11.8l4.3 4.3Zm9.3-14.1v-9.45h-2.8V18h5.25v11.9ZM10 21.5v-11h26.2l-4.3-4.3L34 4l8 8-8 8-2.1-2.2 4.3-4.3H13v8Z"></path>
          </svg>
          <svg class="fabtn loop" id="loopOn" viewBox="0 0 48 48">
            <path fill="currentColor" d="M5 46q-1.2 0-2.1-.9Q2 44.2 2 43V5q0-1.2.9-2.1Q3.8 2 5 2h38q1.2 0 2.1.9.9.9.9 2.1v38q0 1.2-.9 2.1-.9.9-2.1.9Zm9-2 2.1-2.2-4.3-4.3H38v-11h-3v8H11.8l4.3-4.3L14 28l-8 8Zm9.3-14.1h2.45V18H20.5v2.45h2.8ZM10 21.5h3v-8h23.2l-4.3 4.3L34 20l8-8-8-8-2.1 2.2 4.3 4.3H10Z"></path>
          </svg>
        </span>
          </div>
          Lecture en boucle
        </li>
        <li class="speed-item drop-item" data-drop="speed-drop">
          <div class="icon myicons">
            <span id="loopToggle">
              <svg class="fabtn" viewBox="0 0 48 48">
                <path
                  fill="currentColor"
                  d="M8.3 36.3q-1.9-2.25-2.975-5.025Q4.25 28.5 4.05 25.5h3.1q.25 2.35 1.1 4.55.85 2.2 2.35 4ZM4.05 21.5q.1-3 1.225-5.75T8.3 10.7l2.3 2.25Q9.15 14.85 8.275 17 7.4 19.15 7.15 21.5Zm18 22.05q-2.95-.4-5.7-1.4-2.75-1-5.1-2.75l2.3-2.4q1.9 1.3 4.05 2.225t4.45 1.325ZM13.65 10l-2.4-2.4q2.4-1.8 5.175-2.775Q19.2 3.85 22.2 3.45v3q-2.35.4-4.5 1.275Q15.55 8.6 13.65 10Zm5.7 22.05v-17.1l13.4 8.55Zm6.85 11.5v-3q6.4-.95 10.6-5.775Q41 29.95 41 23.5t-4.2-11.275Q32.6 7.4 26.2 6.45v-3q7.7.75 12.75 6.525T44 23.5q0 7.75-5.05 13.5T26.2 43.55Z"
                />
              </svg>
            </span>
          </div>
          Vitesse de lecture
          <div class="icon arrow">
            <svg viewBox="0 0 48 48">
              <path
                fill="currentColor"
                d="m15.2 43.9-2.8-2.85L29.55 23.9 12.4 6.75l2.8-2.85 20 20Z"
              />
            </svg>
          </div>
        </li>
        <li onclick="seeMore()">
          <div class="icon myicons">
            <span id="loopToggle">
              <svg class="fabtn" viewBox="0 0 48 48">
                <path
                  fill="currentColor"
                  d="M22.65 34h3V22h-3ZM24 18.3q.7 0 1.175-.45.475-.45.475-1.15t-.475-1.2Q24.7 15 24 15q-.7 0-1.175.5-.475.5-.475 1.2t.475 1.15q.475.45 1.175.45ZM24 44q-4.1 0-7.75-1.575-3.65-1.575-6.375-4.3-2.725-2.725-4.3-6.375Q4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Zm.05-3q7.05 0 12-4.975T41 23.95q0-7.05-4.95-12T24 7q-7.05 0-12.025 4.95Q7 16.9 7 24q0 7.05 4.975 12.025Q16.95 41 24.05 41ZM24 24Z"
                />
              </svg>
            </span>
          </div>
          Plus des vidéos de ${document.querySelector('.usrName').innerText}
        </li>
      </ul>
      <div class="drop" id="speed-drop">
        <div class="label">
          <span class="icon back-icon">
            <svg viewBox="0 0 48 48">
              <path
                fill="currentColor"
                d="M24 40 8 24 24 8l2.1 2.1-12.4 12.4H40v3H13.7l12.4 12.4Z"
              />
            </svg>
          </span>
          Vitesse de lecture
        </div>
        <ul>
        <li data-speed="0.25">
          <div class="icon check"></div>
          0.25
        </li>
        <li data-speed="0.5">
          <div class="icon check"></div>
          0.5
        </li>
        <li data-speed="0.75">
          <div class="icon check"></div>
          0.75
        </li>
        <li data-speed="1" class="active">
          <div class="icon check"></div>
          Standard
        </li>
        <li data-speed="1.75">
          <div class="icon check"></div>
          1.75
        </li>
        <li data-speed="2">
          <div class="icon check"></div>
          2
        </li>
      </ul>
      </div>
      <div class="drop" id="quality-drop">
        <div class="label">
          <span class="icon back-icon">
            <svg viewBox="0 0 48 48">
              <path
                fill="currentColor"
                d="M24 40 8 24 24 8l2.1 2.1-12.4 12.4H40v3H13.7l12.4 12.4Z"
              />
            </svg>
          </span>
          Qualité
        </div>
        <ul>
        <li data-quality="" class="active">
          <div class="icon check"></div>
            ${document.getElementById('mainVideo').getAttribute('sizes')}p
          <p></p>
        </li>
      </ul>
      </div>
      <div class="drop" id="captions-drop">
        <div class="label">
          <span class="icon back-icon">
            <svg viewBox="0 0 48 48">
              <path
                fill="currentColor"
                d="M24 40 8 24 24 8l2.1 2.1-12.4 12.4H40v3H13.7l12.4 12.4Z"
              />
            </svg>
          </span>
          Sous-titre
        </div>
        <ul>
          <li class="active" data-track="Off"><div class="icon check"></div> Desactivé </li>
        </ul>
      </div>
    </div>
</div>
`;



let times = document.querySelectorAll('.time');
function timepassed() {
  let times = document.querySelectorAll('.time');
  times.forEach(time => {
    let date1 = time.getAttribute('data-time');
    let date = new Date().getTime() / 1000;
    let difference = date - date1;
    time.innerHTML = `• Il y a  ${formatT(difference)}`
  });
  requestAnimationFrame(timepassed);
}
timepassed();

var imglods = document.querySelectorAll('[data-load]')
var links = document.querySelectorAll('.link')

imglods.forEach(imglod => {
    imglod.addEventListener('load', (event) => {

        document.getElementById("lnkVD" + imglod.getAttribute('data-uniqid')).classList.add('loaded')
    })
    imglod.src = imglod.getAttribute('data-load');
    imglod.src = imglod.src;
});