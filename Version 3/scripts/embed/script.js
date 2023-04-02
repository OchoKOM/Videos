const videoPlayer = document.querySelector(".video_player"),
vidId = document.querySelector('.container').id,
main_video = videoPlayer.querySelector("video");
videoPlayer.innerHTML = `${videoPlayer.innerHTML}
<img src="./ico.png" alt="webicon" class="webicon">
<p class="caption_text"></p>
<div class="thumbnail"></div>
<div class="progressAreaTime">0:00</div>
<div class="tut" style="--xd:5%">action</div>

<div class="controls">
    <div class="progress-area">
        <div class="progress-bar">
            <span></span>
        </div>
        <canvas class="bufferedBar"></canvas>
    </div>
    <div class="controls-list">
        <div class="controls-left">
            <button title="Lire" class="icon actions">
                <i class="fatxt play_pause" title="Lire ou pause">
                <svg class="play-icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
                </svg>
                <svg class="pause-icon" viewBox="0 0 48 48" style="display:none;">
                    <path   fill="currentColor" d="M28.25 38V10H36v28ZM12 38V10h7.75v28Z"/>
                </svg>
                <svg class="replay-icon" viewBox="0 0 48 48" style="display:none;">
                    <path   fill="currentColor"  d="M24 44q-3.75 0-7.025-1.4-3.275-1.4-5.725-3.85Q8.8 36.3 7.4 33.025 6 29.75 6 26h3q0 6.25 4.375 10.625T24 41q6.25 0 10.625-4.375T39 26q0-6.25-4.25-10.625T24.25 11H23.1l3.65 3.65-2.05 2.1-7.35-7.35 7.35-7.35 2.05 2.05-3.9 3.9H24q3.75 0 7.025 1.4 3.275 1.4 5.725 3.85 2.45 2.45 3.85 5.725Q42 22.25 42 26q0 3.75-1.4 7.025-1.4 3.275-3.85 5.725-2.45 2.45-5.725 3.85Q27.75 44 24 44Z"/>
                </svg>
                </i>
            </button>
            <div class="volume-container">
                <button class="volume icon actions" title="Couper ou activer le son">
                    <svg class="volume-high-icon" viewBox="0 0 48 48" >
                        <path fill="currentColor" d="M28 41.45v-3.1q4.85-1.4 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4 10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24 8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27 32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>                                </svg>
                    <svg class="volume-low-icon" viewBox="0 0 48 48"  style="display:none;">
                        <path fill="currentColor" d="M10 30V18h8L28 8v32L18 30Zm21 2.4V15.55q2.7.85 4.35 3.2Q37 21.1 37 24q0 2.95-1.65 5.25T31 32.4Zm-6-16.8L19.35 21H13v6h6.35L25 32.45ZM18.9 24Z"/>
                    </svg>
                    <svg class="volume-muted-icon" viewBox="0 0 45 45" style="display:none;">
                        <path fill="currentColor" d="m40.65 45.2-6.6-6.6q-1.4 1-3.025 1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425 2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8 43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2 1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2 1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3 14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
                    </svg>
                </button>
                    <input type="range" name="" class="volume_range" min="0" max="100" value="100" step="1" onchange="rangeSlide(this.value)" onmousemove="rangeSlide(this.value)" title="Volume">
                    <script>
                        function rangeSlide(value) {
                            document.getElementById('vol-value').innerHTML = value +"%"
                        }
                    </script>
                    <span id="vol-value" title="Volume">100%</span>
            </div>
            <div class="timer" id="timer">
                <span class="current">0:00</span><span> / </span><span class="duration">0:00</span>
            </div>
        </div>
        <div class="controls-right">
            <button title="Sous-titres" class="icon closed-caption disabled actions">
                <i class="fatxt" title="Sous-titres">
                <svg viewBox="0 0 55 55">
                  <path fill="currentColor" d="M12 24.5h3v-3h-3Zm0 6h18v-3H12Zm21 0h3v-3h-3Zm-15-6h18v-3H18ZM7 40q-1.2 0-2.1-.9Q4 38.2 4 37V11q0-1.2.9-2.1Q5.8 8 7 8h34q1.2 0 2.1.9.9.9.9 2.1v26q0 1.2-.9 2.1-.9.9-2.1.9Zm0-3h34V11H7v26Zm0 0V11v26Z"/>
                </svg>
                </i>
            </button>
            <button title="Paramètres" class="settingsBtn icon actions">
                <i>
                <svg viewBox="0 0 48 48">
                  <path fill="currentColor"d="m19.4 44-1-6.3q-.95-.35-2-.95t-1.85-1.25l-5.9 2.7L4 30l5.4-3.95q-.1-.45-.125-1.025Q9.25 24.45 9.25 24q0-.45.025-1.025T9.4 21.95L4 18l4.65-8.2 5.9 2.7q.8-.65 1.85-1.25t2-.9l1-6.35h9.2l1 6.3q.95.35 2.025.925Q32.7 11.8 33.45 12.5l5.9-2.7L44 18l-5.4 3.85q.1.5.125 1.075.025.575.025 1.075t-.025 1.05q-.025.55-.125 1.05L44 30l-4.65 8.2-5.9-2.7q-.8.65-1.825 1.275-1.025.625-2.025.925l-1 6.3ZM24 30.5q2.7 0 4.6-1.9 1.9-1.9 1.9-4.6 0-2.7-1.9-4.6-1.9-1.9-4.6-1.9-2.7 0-4.6 1.9-1.9 1.9-1.9 4.6 0 2.7 1.9 4.6 1.9 1.9 4.6 1.9Zm0-3q-1.45 0-2.475-1.025Q20.5 25.45 20.5 24q0-1.45 1.025-2.475Q22.55 20.5 24 20.5q1.45 0 2.475 1.025Q27.5 22.55 27.5 24q0 1.45-1.025 2.475Q25.45 27.5 24 27.5Zm0-3.5Zm-2.2 17h4.4l.7-5.6q1.65-.4 3.125-1.25T32.7 32.1l5.3 2.3 2-3.6-4.7-3.45q.2-.85.325-1.675.125-.825.125-1.675 0-.85-.1-1.675-.1-.825-.35-1.675L40 17.2l-2-3.6-5.3 2.3q-1.15-1.3-2.6-2.175-1.45-.875-3.2-1.125L26.2 7h-4.4l-.7 5.6q-1.7.35-3.175 1.2-1.475.85-2.625 2.1L10 13.6l-2 3.6 4.7 3.45q-.2.85-.325 1.675-.125.825-.125 1.675 0 .85.125 1.675.125.825.325 1.675L8 30.8l2 3.6 5.3-2.3q1.2 1.2 2.675 2.05Q19.45 35 21.1 35.4Z"/>
                </svg>
                </i>
            </button>
            <div class="ochovid actions" title="Voir sur OchoVid" data-link="time" data-url="time">
                <a href="./watch?v=${vidId}" target="_blank">OchoVid</a>
            </div>
            <button title="Plein écran" class="toggleFullscreen icon actions">
                <i class="fatxt fa kom fullscreen">
                <svg class="open" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                </svg>
                </i>
                <i class="fatxt fa kom exitFullscreen" style="display:none;">
                <svg class="close" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/>
                </svg>
                </i>
            </button>
        </div>
    </div>
</div>
<div class="loader"></div> 
<div class="context-menu">
<div class="wrapper">
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
</div>
<div class="settings">
<div class="wrapper">
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
        Auto (${main_video?.getAttribute('sizes')}p)
      <p></p>
    </li>
  </ul>
  </div>
  
</div>
</div>`;

// Selection des elements
const video_player = document.querySelector("#video_player"),
  mainVideo = video_player.querySelector("#main-video"),
  loader = video_player.querySelector(".loader"),
  progressAreaTime = video_player.querySelector(".progressAreaTime"),
  action = video_player.querySelectorAll(".actions"),
  title = video_player.querySelector(".tut"),
  webicon = video_player.querySelector(".webicon"),
  controls = video_player.querySelector(".controls"),
  progressArea = video_player.querySelector(".progress-area"),
  progressBar = video_player.querySelector(".progress-bar"),
  bufferedBar = video_player.querySelector(".bufferedBar"),
  fast_rewind = video_player.querySelector(".skip-back"),
  play_pause = video_player.querySelector(".play_pause"),
  pause = video_player.querySelector(".pause-icon"),
  play = video_player.querySelector(".play-icon"),
  rePlay = video_player.querySelector(".replay-icon"),
  fast_forward = video_player.querySelector(".skip-fore"),
  volume = video_player.querySelector(".volume"),
  volumeHigh = video_player.querySelector(".volume-high-icon"),
  volumeLow = video_player.querySelector(".volume-low-icon"),
  volumeMuted = video_player.querySelector(".volume-muted-icon"),
  volume_range = video_player.querySelector(".volume_range"),
  current = video_player.querySelector(".current"),
  totalDuration = video_player.querySelector(".duration"),
  auto_play = video_player.querySelector(".auto-play"),
  closed_caption = document.querySelector('.closed-caption'),
  settingsBtn = video_player.querySelector(".settingsBtn"),
  settings = video_player.querySelector(".settings"),
  menu_bar = document.querySelector(".menu-bar"),
  home_items = document.querySelectorAll(".drop-item"),
  settings_item = document.querySelectorAll(".drop-item"),
  back_icon = document.querySelectorAll(".back-icon"),
  loopToggle = video_player.querySelector(".loop-line"),
  playback = video_player.querySelectorAll("#speed-drop li"),
  qualities = video_player.querySelectorAll("source[sizes]"),
  quality_ul = video_player.querySelector("#quality-drop ul"),
  captions_labels = video_player.querySelector("#captions-drop ul"),
  captions = video_player.querySelector("#captions-drop"),
  captionToggle = document.querySelector(".caption-line"),
  tracks = video_player.querySelectorAll("track"),
  contextMenu = video_player.querySelector(".context-menu"),
  copyURL = video_player.querySelector(".copy-link"),
  copySequence = video_player.querySelector(".copy-seq"),
  copyIframe = video_player.querySelector(".copy-iframe"),
  picture_in_picture = video_player.querySelector(".picture_in_picture"),
  fullscreen = video_player.querySelector(".fullscreen"),
  exitFullscreen = video_player.querySelector(".exitFullscreen");

//? Les controls
document.querySelectorAll('.ochovid a').forEach(link=>{
  link.onclick = ()=> mainVideo.pause()
})
let thumbnail = video_player.querySelector(".thumbnail");
let thumb = false

document.addEventListener("keydown", (e) => {
  document.removeEventListener("keyup", e);
  if (!controls.classList.contains("active")) {
    if (e.key.toLowerCase() === "f" || e.key.toLowerCase() === "k"  || 
    e.key.toLowerCase() === "m"  || e.key.toLowerCase() === " " ||
    e.key.toLowerCase() === "arrowup"  || e.key.toLowerCase() === "arrowdown"  || 
    e.key.toLowerCase() === "arrowleft" || e.key.toLowerCase() === "j"  || 
    e.key.toLowerCase() === "arrowright"  || e.key.toLowerCase() === "l"  || e.key.toLowerCase() === "c" || 
    e.key.toLowerCase() === "c" || e.key.toLowerCase() === "i" ) {
      controls.classList.add("active");
    }
  }
  const tagName = document.activeElement.tagName.toLowerCase();
  if (tagName === "input") return;
  switch (e.key.toLowerCase()) {
    case "f":
      toggleFullScreenMode();
      break;
    case " ":
      e.preventDefault();
    case "k":
      var isVideoPaused = video_player.classList.contains("paused");
      isVideoPaused ? pauseVideo() : playVideo();
      break;

    case "m":
      if (volume_range.value != 0) {
        var VolumeRangeValue = volume_range.value / 100;
        let setVolume = localStorage.setItem("volume", VolumeRangeValue);
      }
      muteVolume();
      break;
    case "arrowup":
      e.preventDefault();
      if (numRoundMultiple(mainVideo.volume, 0.05)) {
        let volValue = numRoundMultiple(mainVideo.volume, 0.05);
        mainVideo.volume = volValue + 0.05;
        volume_range.value = volValue * 100 + 5;
        document.getElementById("vol-value").innerHTML = volume_range.value + "%";
      }
      break;
    case "arrowdown":
      e.preventDefault();
      if (mainVideo.volume > 0.06) {
        if (numRoundMultiple(mainVideo.volume, 0.05)) {
          let volValue = numRoundMultiple(mainVideo.volume, 0.05);
          mainVideo.volume = volValue - 0.05;
          volume_range.value = volValue * 100 - 5;
          document.getElementById("vol-value").innerHTML =
            volume_range.value + "%";
        }
      }
      break;
    case "arrowleft":
    case "j":
      mainVideo.currentTime -= 5;
      break;
    case "arrowright":
    case "l":
      mainVideo.currentTime += 5;
      break;
    case "c":
      closed_caption.click()
      break;
    case "i":
      if (settings.classList.contains("active")) {
        settings.classList.remove("active");
        settingsBtn.classList.remove("active");
      }
      mainVideo.requestPictureInPicture();
      break;
  }
});
document.addEventListener("keyup", (e) => {
  document.removeEventListener("keydown", e);
  if (!settings.classList.contains("active")) {
    if (!mainVideo.paused) {
      let count = 1;
      setInterval(() => {
        count--;
        if (count == 0) {
          controls.classList.remove("active");
        }
      }, 1000);
    }
  }
});

mainVideo.addEventListener("waiting", () => {
  loader.style.display = "block";
  controls.classList.add("active");
});
mainVideo.addEventListener("canplay", () => {
  loader.style.display = "none";
});
// Fonction de copie dans le presse papier
function copyToClipboard(text) {
  const input = document.createElement('input');
  input.setAttribute('value', text);
  document.body.appendChild(input);
  input.select();
  document.execCommand('copy');
  document.body.removeChild(input);
  alert("Copié")
}
// Fonction d'arrondissement
function numRoundMultiple(x, y) {
  return Math.round(x / y) * y;
}
fast_rewind?.addEventListener('click', ()=>{
    mainVideo.currentTime -= 10
})
fast_forward?.addEventListener('click', ()=>{
    mainVideo.currentTime += 10
})
let xhr = new XMLHttpRequest();
xhr.open('GET','video.php?location=' + vidId);
xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let xhr2 = new XMLHttpRequest();
          xhr2.open('GET',`${xhr.response}`);
          xhr2.responseType = "arraybuffer"
          xhr2.onload = ()=>{
              if(xhr2.readyState === XMLHttpRequest.DONE){
                  if(xhr2.status === 200){
                    mainVideo.src =  blobVideoUrl(xhr2.response)
                  }
              }
          }
          xhr2.send();
        }
    }
}
xhr.send();
mainVideo.addEventListener("click", () => {
  if (settingsBtn.classList.contains("active")) {
    removeSettings()
  } else {
    const isVideoPaused = video_player.classList.contains("paused");
    isVideoPaused ? pauseVideo() : playVideo();
  }
});
var init = function() {
  document.addEventListener('touchstart', handler, true);
  document.addEventListener('touchmove', handler, true);
  document.addEventListener('touchend', handler, true);
  document.addEventListener('touchcancel', handler, true);        
  };
  var handler = function touch(event) {
      var touch = event.changedTouches[0],
          simulatedEvent = document.createEvent('MouseEvent');
  
      simulatedEvent.initMouseEvent(
          { touchstart: 'mousedown', touchmove: 'mousemove', touchend: 'mouseup' } [event.type],
          true, true, window, 1, 
          touch.screenX, touch.screenY, touch.clientX, touch.clientY,
          false, false, false, false, 0, null);
  
      touch.target.dispatchEvent(simulatedEvent);
  };
// Fonction play
function playVideo() {
  play.parentNode.parentNode.title = "Pause"
  play.style.display = "none";
  pause.style.display = "block";
  video_player.classList.add("paused");
  mainVideo.play();
}
// Fonction pause
function pauseVideo() {
  play.parentNode.parentNode.title = "Lire"
  play.style.display = "block";
  pause.style.display = "none";
  video_player.classList.remove("paused");
  mainVideo.pause();
}

play_pause.addEventListener("click", () => {
  const isVideoPaused = video_player.classList.contains("paused");

  isVideoPaused ? pauseVideo() : playVideo();
});

mainVideo.addEventListener("play", () => {
  playVideo();
  let xhr = new XMLHttpRequest();
      xhr.open('GET','php/embedAction.php?n='+document.querySelector('.container')?.id);
      xhr.send();
});

mainVideo.addEventListener("pause", () => {
  pauseVideo();
});


// La durée totale de la vidéo
mainVideo.addEventListener("loadeddata", () => {
  totalDuration.innerHTML = formatDuration(mainVideo.duration);
});

// Le temps de lecture
let timeLink = '';
mainVideo.addEventListener("timeupdate", (e) => {
  current.innerHTML = formatDuration(mainVideo.currentTime);
  let currentVideoTime = e.target.currentTime;
  let videoDuration = e.target.duration;
  if (Math.floor(currentVideoTime) != 0) {
    timeLink = `&t=${Math.floor(currentVideoTime)}`
    document.querySelectorAll('[data-link="time"] a').forEach(a => {
      a.href = `./watch?v=${document.querySelector('.container')?.id + timeLink}`
    });
  }
  // La barre de progression
  let progressWidth = (currentVideoTime / videoDuration) * 100;
  progressBar.style.width = `${progressWidth}%`;
});
copyURL.addEventListener("click", () => {
  let link =  document.querySelector('[data-url="time"] a').href.split("&t=")[0];
  copyToClipboard(link)
});
copySequence.addEventListener("click", () => {
  let link =  document.querySelector('[data-url="time"] a').href.split("&t=")[0];
  copyToClipboard(link + timeLink)
}) ;
copyIframe.addEventListener("click", () => {
  let link =  document.querySelector('[data-url="time"] a').href.split("&t=")[0];
  link = link.replace('watch', 'embed');
  let iframe = `<iframe style="width: 100%;height: 100%;aspect-ratio: 16/9;border: none;" src="${link}" allowfullscreen></iframe>`;
  copyToClipboard(iframe)
});
const leadingZeroFormatter = new Intl.NumberFormat(undefined, {
  minimumIntegerDigits: 2,
});
function formatDuration(time) {
  const seconds = Math.floor(time % 60);
  const minutes = Math.floor(time / 60) % 60;
  const hours = Math.floor(time / 3600);
  if (hours === 0) {
    return `${minutes}:${leadingZeroFormatter.format(seconds)}`;
  } else {
    return `${hours}:${leadingZeroFormatter.format(
      minutes
    )}:${leadingZeroFormatter.format(seconds)}`;
  }
}
// Mettre à jour la durée de la vidéo en fonction de la longueur de la barre de progression
function scrub(e) {
  let videoDuration = mainVideo.duration;
  let progressWidthVal = progressArea.clientWidth;
  let ClickOffsetX = e.offsetX;
  progressBar.style.width = `${(ClickOffsetX / progressWidthVal) * 100}%`
  mainVideo.currentTime = (ClickOffsetX / progressWidthVal) * videoDuration;
}

progressArea.addEventListener("pointerdown", () => {
  progressArea.addEventListener("click", scrub);
  progressArea.addEventListener("mousemove", scrub);
  progressArea.addEventListener("pointerup", () => {
    progressArea.removeEventListener("mousemove", scrub);
  });
  video_player.addEventListener("pointerup", () => {
    progressArea.removeEventListener("mousemove", scrub);
  });
});

// Le changement de volume
mainVideo.addEventListener("volumechange", () => {
  volumechange();
});
function volumechange() {
  volume_range.value = mainVideo.volume * 100;
  if (mainVideo.muted || mainVideo.volume === 0) {
    volume.title = "Activer le son"
    volume_range.value = 0;
    volumeMuted.style.display = "block";
    volumeLow.style.display = "none";
    volumeHigh.style.display = "none";
  } else if (mainVideo.volume >= 0.5) {
    volume.title = "Couper le son"
    volume_range.value = mainVideo.volume * 100;
    volumeMuted.style.display = "none";
    volumeLow.style.display = "none";
    volumeHigh.style.display = "block";
  } else {
    volume.title = "Couper le son"
    volume_range.value = mainVideo.volume * 100;
    volumeMuted.style.display = "none";
    volumeLow.style.display = "block";
    volumeHigh.style.display = "none";
  }
}

function muteVolume() {
  if (volume_range.value == 0) {
    mainVideo.volume = 0.8;
    volume_range.value = 80;
  } else {
    volume_range.value = 0;
    mainVideo.volume = 0;
  }
  document.getElementById("vol-value").value = volume_range.value;
  document.getElementById("vol-value").innerHTML =
    document.getElementById("vol-value").value + "%";
}
function rangeSlide(value) {
  document.getElementById("vol-value").innerHTML = value + "%";
}
volume_range.addEventListener("mousemove", () => {
  mainVideo.volume = volume_range.value / 100;
});
volume_range.addEventListener("click", () => {
  mainVideo.volume = volume_range.value / 100;
});
volume.addEventListener("click", () => {
  if (volume_range.value != 0) {
    var VolumeRangeValue = volume_range.value / 100;
    localStorage.setItem("volume", VolumeRangeValue);
  }
  muteVolume();
});

// Le survol de la souris
action.forEach((event)=>{
  event.addEventListener("click", ()=>{
    if (!event.classList.contains("settingsBtn") && settings.classList.contains("active")) {
      removeSettings()
    }
  })
  event.addEventListener("mouseover", (e)=>{
    let x = e.clientX;
    let totalWidth = progressArea.clientWidth;
    if (x >= totalWidth - 90) {
      x = totalWidth - 90;
    } else if (x <= 45) {
      x = 45;
    } 
    title.classList.add('on');
    title.innerHTML = event.title
    title.style.setProperty("--xd", `${x}px`);
  })
  event.addEventListener("mouseleave", ()=>{
    title.classList.remove('on');
  })
})
// Le temps au survol de la souris
progressArea.addEventListener("touchstart",init, true)
progressArea.addEventListener("mousemove", (e) => {
  controls.classList.add("active");
  clearTimeout(touchTimeout)
  var progressWidthVal = progressArea.clientWidth;
  let x = e.offsetX;
  let videoDuration = mainVideo.duration;
  let progressTime = Math.floor((x / progressWidthVal) * videoDuration);
  let progressWidthValue = progressArea.clientWidth;
  if (thumb) {
    if (x >= progressWidthValue - 22) {
      x = progressWidthValue - 22;
    } else if (x <= 18) {
      x = 18;
    } else {
      x = e.offsetX;
    }
  }else{
    if (x >= progressWidthValue - 25) {
      x = progressWidthValue - 25;
    } else if (x <= 21) {
      x = 21;
    } else {
      x = e.offsetX;
    }
  }
  
  progressAreaTime.style.setProperty("--x", `${x}px`);
  progressAreaTime.style.display = "block";
  if (x >= progressWidthValue - 95) {
    x = progressWidthValue - 95;
  } else if (x <= 74) {
    x = 74;
  } else {
    x = e.offsetX;
  }
  if (isNaN(progressTime)) progressTime = 0
  progressAreaTime.innerHTML = `${formatDuration(progressTime)}`;
  thumbnail.style.setProperty("--x", `${x}px`);
  if (thumb) {
    thumbnail.style.display = "block";
    progressAreaTime.classList.add('thumb')
  }
  

  for (var item of thumbnails) {
    //
    var data = item.sec.find((x1) => x1.index === Math.floor(progressTime));

    // thumbnail found
    if (data) {
      if (item.data != undefined) {
        thumbnail.setAttribute(
          "style",
          `background-image: url(${item.data});background-position-x: ${data.backgroundPositionX}px;background-position-y: ${data.backgroundPositionY}px;--x: ${x}px;display: block;`
        );
        return;
      }
    }
  }
});
progressArea.addEventListener("mouseleave", () => {
  thumbnail.style.display = "none";
  progressAreaTime.style.display = "none";
});
progressArea.addEventListener("mouseup", () => {
  thumbnail.style.display = "none";
  progressAreaTime.style.display = "none";
});

// La lecture automatique
auto_play?.addEventListener("click", () => {
  auto_play.classList.toggle("active");
  if (auto_play.classList.contains("active")) {
    auto_play.title = "La lecture automatique est activée";
  } else {
    auto_play.title = "La lecture automatique est desactivée";
  }
});
function replay() {
    controls.classList.add('active')
    if (track.length != 0) {
      caption_text.classList.remove("active")
    }    rePlay.style.display = "block";
    play.style.display = "none";
    pause.style.display = "none";
}

// Paramètres
function removeSettings() {
  settings.classList.remove("active");
  settingsBtn.classList.remove("active");
  let drop = document.querySelectorAll('.drop')
  if (!settings.classList.contains("active")) {
    drop.forEach((event)=>{
      if (event.classList.contains('active')) {
        event.classList.remove('active')
        menu_bar.style.marginLeft = "0";
      }
    })
  }
}
settingsBtn.onclick = () => {
  settings.classList.toggle("active");
  settingsBtn.classList.toggle("active");
  let drop = document.querySelectorAll('.drop')
  if (!settings.classList.contains("active")) {
     drop.forEach((event)=>{
      if (event.classList.contains('active')) {
        event.classList.remove('active')
        menu_bar.style.marginLeft = "0";
      }
    })
  }
};
settings_item.forEach( btn=> {
  btn.onclick = () => {
    menu_bar.style.marginLeft = "-220px";
    var drop = btn.getAttribute("data-drop");
    var sets_items = document.getElementById(drop);
    sets_items.classList.add("active");
  };
});
back_icon.forEach(function (btn) {
  btn.onclick = () => {
    let bk = btn.parentNode;
    let sets_items = bk.parentNode;
    menu_bar.style.marginLeft = "0";
    sets_items.classList.remove("active");
  };
});
playback.forEach((event) => {
  event.addEventListener("click", () => {
    if (removeActiveClasses(playback)) {
      event.classList.add("active");
    } else {
      event.classList.add("active");
      let speed = event.getAttribute("data-speed");
      mainVideo.playbackRate = speed;
    }
  });
});

qualities.forEach(event=>{
  let qualitie_html = `<li data-quality="${event.getAttribute('sizes')}"> <div class="icon check"></div> ${event.getAttribute('sizes')}p </li>`;
  if (event.getAttribute('sizes') >= 720) {
    qualitie_html = `<li data-quality="${event.getAttribute('sizes')}"> <div class="icon check"></div> ${event.getAttribute('sizes')}p HD </li>`;
  }
  quality_ul.insertAdjacentHTML("afterbegin", qualitie_html)
})

const quality = video_player.querySelectorAll("#quality-drop li");

quality.forEach((event) => {
  event.addEventListener("click", () => {
    let size = event.getAttribute("data-quality");
    removeActiveClasses(quality);
    event.classList.add("active");
    qualities.forEach(event =>{
      if (event.getAttribute('sizes') == size) {
        let video_current_time = mainVideo.currentTime;
        let video_source = event.src;
        mainVideo.src = video_source;
        mainVideo.setAttribute('sizes', event.getAttribute('sizes'));
        mainVideo.currentTime = video_current_time;
        playVideo()
      }
    })
  });
});
if (tracks.length != 0) {
  for (let i = 0; i < tracks.length; i++) {
    trackLi = `<li class="" data-track="${tracks[i].label}"><div class="icon check"></div>${tracks[i].label}</li>`;
    captions_labels.insertAdjacentHTML("beforeend", trackLi)
  }
}
let caption = captions?.querySelectorAll("ul li");
function drawProgress(canvas, buffered, duration) {
  let context = canvas.getContext('2d', { antialias: false });
  context.fillStyle = "#ffffffe6";

  let height = canvas.height;
  let width = canvas.width;
  if (!height || !width) throw "Canva's width or height or not set.";
  context.clearRect(0, 0, width, height);
  for (let i = 0; i < buffered.length; i++) {
    let leadingEdge = buffered.start(i) / duration * width;
    let trailingEdge = buffered.end(i) / duration * width;
    context.fillRect(leadingEdge, 0, trailingEdge - leadingEdge, height)
  }
}

mainVideo.addEventListener('progress', () => {
  drawProgress(bufferedBar, mainVideo.buffered, mainVideo.duration);
})
setInterval(() => {
  mainVideo.removeAttribute('controls', false);
}, 1);
if (caption?.length <= 1) {
  closed_caption.classList.add('disabled');
  captions_labels.innerHTML = `<li class="active" data-track="Off"><div class="icon check"></div> Non disponible </li>`
}
closed_caption.onclick = ()=>{
  closed_caption.classList.toggle('active')
  if (closed_caption.classList.contains('active')) {
    caption[1].click()
  }else{
    caption[0].click()
  }
  
}
caption?.forEach((event) => {
  event.addEventListener("click", () => {
    removeActiveClasses(caption)
    event.classList.add("active")
    closed_caption.classList.add('active')
    changeCaption(event)
  });
});
let track = mainVideo.textTracks;

function changeCaption(lable) {
  let trackLable = lable.getAttribute("data-track");
  for (let i = 0; i < track.length; i++) {
    track[i].mode = "disabled";
    if (track[i].label == trackLable) {
      track[i].mode = "showing";
    }
    
  }
}
function removeActiveClasses(e) {
  e.forEach((event) => {
    event.classList.remove("active");
  });
}
let caption_text = video_player.querySelector(".caption_text")

for (let i = 0; i < track.length; i++) {
  track[i].addEventListener('cuechange', ()=>{
    if (track[i].mode = "showing") {
      if (track[i].activeCues[0]) {
        let span = `<span><mark>${track[i].activeCues[0].text}</mark></span>`
        caption_text.innerHTML = span;
      } else {
        caption_text.innerHTML = "";
      }
    }
  })
}
loopToggle?.addEventListener("click", () => {
  loopToggle.classList.toggle("active");
  if (loopToggle.classList.contains("active")) {
    document.getElementById("loopOn").style.display = "block";
    document.getElementById("loopOff").style.display = "none";
    mainVideo.setAttribute("loop", "");
  } else {
    document.getElementById("loopOn").style.display = "none";
    document.getElementById("loopOff").style.display = "block";
    mainVideo.removeAttribute("loop");
  }
});
// Plein écran
function toggleFullScreenMode() {
  if (document.fullscreenElement == null) {
    video_player.requestFullscreen();
  } else {
    document.exitFullscreen();
  }
}
function countCont() {
  let count = 2;
  count--;
  if (count <= 0 && video_player.classList.contains("openFullScreen")) {
    controls.classList.remove("active");
    video_player.style.cursor ='none'
  }  
}
document.addEventListener('fullscreenchange', ()=> {
  if (document.fullscreenElement == null) {
    if (video_player.classList.contains("openFullScreen")) {
      video_player.classList.remove("openFullScreen");
      fullscreen.style.display = "block";
      exitFullscreen.style.display = "none";
      controls.classList.add("active");
    }
  } else {
    if (!video_player.classList.contains("openFullScreen") && !settings.classList.contains("active")) {
      video_player.classList.add("openFullScreen");
      fullscreen.style.display = "none";
      exitFullscreen.style.display = "block";
       let int = setInterval(countCont, 1000);
      controls.addEventListener('mouseover', ()=>{
        clearInterval(int)
      })
      video_player.addEventListener('mousemove', ()=>{
        video_player.style.cursor ='default'
      })
    }
        
  }
})
mainVideo.addEventListener("dblclick", () => {
  settings.classList.remove("active");
  settingsBtn.classList.remove("active");
  toggleFullScreenMode();
});
fullscreen.addEventListener("click", () => {
  settings.classList.remove("active");
  settingsBtn.classList.remove("active");
  toggleFullScreenMode();
});
exitFullscreen.addEventListener("click", toggleFullScreenMode);


video_player.addEventListener("contextmenu", (e) => {
  e.preventDefault();
  let video_player_width = video_player.clientWidth
  let video_player_heigh = video_player.clientHeight
  let xLeft = e.clientX;
  let yTop = e.clientY
  if (xLeft > (video_player_width - 260)) {
    xLeft = xLeft - 250;
  }
  if (yTop > (video_player_heigh - contextMenu.clientHeight)) {
    yTop = yTop - contextMenu.clientHeight;
  }
  contextMenu.setAttribute(
    "style",
    `--x-left: ${xLeft}px;--y-top: ${yTop}px;`
  );
  contextMenu.classList.add("active");
});
mainVideo.addEventListener("pointerdown", () => {
  if (contextMenu.classList.contains("active")) contextMenu.classList.remove("active");
});
controls.addEventListener("pointerdown", () => {
  if (contextMenu.classList.contains("active")) contextMenu.classList.remove("active");
});
addEventListener("blur", () => {
  if (contextMenu.classList.contains("active")){
    contextMenu.classList.remove("active"); 
  } 
  if (settings.classList.contains("active")){
    removeSettings();
  } 
});

// Survol de la souris
if (!video_player.classList.contains("openFullScreen")) {
  video_player.addEventListener("mouseover", () => {
    controls.classList.add("active");
    if (track.length != 0) {
      caption_text.classList.remove("active")
    }
  });
  video_player.addEventListener("mouseleave", () => {
    if (video_player.classList.contains("paused")) {
      if (settingsBtn.classList.contains("active")) {
        controls.classList.add("active");
        if (track.length != 0) {
      caption_text.classList.remove("active")
    }
      } else {
        controls.classList.remove("active");
        if (track.length != 0) {
          caption_text.classList.add("active")
        }
      }
    } else {
      controls.classList.add("active");
      if (track.length != 0) {
      caption_text.classList.remove("active")
    }
    }
  });
} else {
  if (video_player.classList.contains("paused")) {
    if (settingsBtn.classList.contains("active")) {
      controls.classList.add("active");
      if (track.length != 0) {
      caption_text.classList.remove("active")
    }
    } else {
      controls.classList.remove("active");
      if (track.length != 0) {
        caption_text.classList.add("active")
      }
    }
  } else {
    controls.classList.add("active");
    if (track.length != 0) {
      caption_text.classList.remove("active")
    }
  }
}
function blobVideoUrl(link) {
  const blob = new Blob([link]);
  const url = URL.createObjectURL(blob)
  return url;
}
// Pour les ecrans tactiles
let touchTimeout
video_player.addEventListener("touchstart", () => {
  controls.classList.add("active");
  if (track.length != 0) {
      caption_text.classList.remove("active")
    }
    touchTimeout = setTimeout(() => {
    controls.classList.remove("active");
    if (track.length != 0) {
      caption_text.classList.add("active")
    }
  }, 8000);
});
window.addEventListener('unload', () => {
    mainVideo.play();
})
mainVideo.addEventListener('canplay', () => {
  webicon.classList.add("active");
})
window.addEventListener('load', () => {;
    volumechange()
})
var thumbnails = [];

var thumbnailWidth = 160;
var thumbnailHeight = 90;
var horizontalItemCount = 5;
var verticalItemCount = 5;
let xhreq = new XMLHttpRequest();
let sources = `kom${vidId}`
xhreq.open('GET','video.php?location=' + vidId);
xhreq.onload = ()=>{
    if(xhreq.readyState === XMLHttpRequest.DONE){
        if(xhreq.status === 200){
          let xhreq2 = new XMLHttpRequest();
          xhreq2.open('GET',`${xhreq.response}`);
          xhreq2.responseType = "arraybuffer"
          xhreq2.onload = ()=>{
              if(xhreq2.readyState === XMLHttpRequest.DONE){
                  if(xhreq2.status === 200){
                    sources =  xhreq2.response
                  }
              }
          }
          xhreq2.send();
        }
    }
}
xhreq.send();


let preview_video = document.createElement('video');
preview_video.preload = "metadata"
preview_video.width = "250"
preview_video.height = "250"
preview_video.controls = true
preview_video.src = sources


preview_video.addEventListener("loadeddata", async function () {
  //
  preview_video.pause();

  //
  var count = 1;

  //
  var id = 1;

  //
  var x = 0,
    y = 0;

  //
  var array = [];

  //
  var duration = parseInt(preview_video.duration);

  //
  for (var i = 1; i <= duration; i++) {
    array.push(i);
  }

  //
  var canvas;

  //
  var i, j;

  for (i = 0, j = array.length; i < j; i += horizontalItemCount) {
    //
    for (var startIndex of array.slice(i, i + horizontalItemCount)) {
      //
      var backgroundPositionX = x * thumbnailWidth;

      //
      var backgroundPositionY = y * thumbnailHeight;

      //
      var item = thumbnails.find((x) => x.id === id);

      if (!item) {
        //

        //
        canvas = document.createElement("canvas");

        //
        canvas.width = thumbnailWidth * horizontalItemCount;
        canvas.height = thumbnailHeight * verticalItemCount;

        //
        thumbnails.push({
          id: id,
          canvas: canvas,
          sec: [
            {
              index: startIndex,
              backgroundPositionX: -backgroundPositionX,
              backgroundPositionY: -backgroundPositionY,
            },
          ],
        });
      } else {
        //

        //
        canvas = item.canvas;

        //
        item.sec.push({
          index: startIndex,
          backgroundPositionX: -backgroundPositionX,
          backgroundPositionY: -backgroundPositionY,
        });
      }

      //
      var context = canvas.getContext("2d");

      //
      preview_video.currentTime = startIndex;

      //
      await new Promise(function (resolve) {
        var event = function () {
          //
          context.drawImage(
            preview_video,
            backgroundPositionX,
            backgroundPositionY,
            thumbnailWidth,
            thumbnailHeight
          );

          //
          x++;

          // removing duplicate events
          preview_video.removeEventListener("canplay", event);

          //
          resolve();
        };

        //
        preview_video.addEventListener("canplay", event);
      });

      // 1 thumbnail is generated completely
      count++;
    }

    // reset x coordinate
    x = 0;

    // increase y coordinate
    y++;

    // checking for overflow
    if (count > horizontalItemCount * verticalItemCount) {
      //
      count = 1;

      //
      x = 0;

      //
      y = 0;

      //
      id++;
    }
  }
  // looping through thumbnail list to update thumbnail
  thumbnails.forEach(function (item) {
    // converting canvas to blob to get short url
    item.canvas.toBlob(
      (blob) => (item.data = URL.createObjectURL(blob)),
      "image/jpeg"
    );

    // deleting unused property
    delete item.canvas;
  });

  thumb = true
});
