let thumbnail = video_player.querySelector(".thumbnail");

mainVideo.addEventListener("loadeddata", () => {
  setInterval(() => {
    let bufferedTime = mainVideo.buffered.end(0);
    let duration = mainVideo.duration;
    let width = (bufferedTime / duration) * 100;
    bufferedBar.style.width = `${width}%`;
  }, 500);
});
document.addEventListener("keydown", (e) => {
  document.removeEventListener("keyup", e); 

  if (controls.classList.contains("active")) {
  } else {
    controls.classList.add("active");
  }
  const tagName = document.activeElement.tagName.toLowerCase();
  if (tagName === "input") return;
  switch (e.key.toLowerCase()) {
    case "f":
      toggleFullScreenMode();
      break;
    case "n":
      next();
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
        document.getElementById("vol-value").innerHTML =
          volume_range.value + "%";
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
  if (settings.classList.contains("active")) {
  } else {
    if (mainVideo.paused) {
    } else {
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
  if (!webicon.classList.contains('active')) {
    webicon.classList.add('active');
  }
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
// Fonction pour lire
function playVideo() {
  play.style.display = "none";
  pause.style.display = "block";
  video_player.classList.add("paused");
  play_pause.title = "Pause(k)"
  mainVideo.play();
}
function togglePlayPause() {
  const isVideoPaused = video_player.classList.contains("paused");
  isVideoPaused ? pauseVideo() : playVideo();
}
mainVideo.addEventListener("click", () => {
  if (settingsBtn.classList.contains("active")) {
    removeSettings()
  } else {
    togglePlayPause()
  }
});

// Fonction pause
function pauseVideo() {
  play.style.display = "block";
  pause.style.display = "none";
  video_player.classList.remove("paused");
  play_pause.title = "Lire(k)"
  mainVideo.pause();
}
function replay() {
  if(document.querySelector('.counter').classList.contains('active')){
      document.querySelector('.counter').classList.remove('active')
  }
  controls.classList.add('active')
  rePlay.style.display = "block";
  play.style.display = "none";
  pause.style.display = "none";
}
play_pause.addEventListener("click", () => {
  const isVideoPaused = video_player.classList.contains("paused");
  isVideoPaused ? pauseVideo() : playVideo();
  if (settingsBtn.classList.contains("active")) {
    settings.classList.remove("active");
    settingsBtn.classList.remove("active");
  }
});

mainVideo.addEventListener("play", () => {
  playVideo();
});

mainVideo.addEventListener("pause", () => {
  pauseVideo();
});

// Video suivante
playNext.addEventListener("click", () => {
  next();
});

// La durée totale de la vidéo
mainVideo.addEventListener("loadeddata", () => {
  totalDuration.innerHTML = formatDuration(mainVideo.duration);
});
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
let timeLink = '';
// Le temps de lecture
mainVideo.addEventListener("timeupdate", (e) => {
  current.innerHTML = formatDuration(mainVideo.currentTime);
  let currentVideoTime = e.target.currentTime;
  let videoDuration = e.target.duration;
  if (Math.floor(currentVideoTime) != 0) {
    timeLink = `&t=${Math.floor(currentVideoTime)}`
    document.querySelectorAll('[data-link="time"] a').forEach(a => {
      a.href = `./watch?v=${videoId + timeLink}`
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
const leadingZeroFormat = new Intl.NumberFormat(undefined, {
  minimumIntegerDigits: 2,
});

function formatDuration(time) {
  if (isNaN(time)) {
    time = 0;
  }
  const seconds = Math.floor(time % 60);
  const minutes = Math.floor(time / 60) % 60;
  const hours = Math.floor(time / 3600);
  if (hours === 0) {
    return `${minutes}:${leadingZeroFormat.format(seconds)}`;
  } else {
    return `${hours}:${leadingZeroFormat.format(minutes)}:${leadingZeroFormat.format(seconds)}`;
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
  volume_range.value = mainVideo.volume * 100;
  volumechange();
});
function volumechange() {
  volume_range.value = mainVideo.volume * 100;
  if (mainVideo.muted || mainVideo.volume === 0) {
    volume.title = "Activer le son (m)"
    volume_range.value = 0;
    volumeMuted.style.display = "block";
    volumeLow.style.display = "none";
    volumeHigh.style.display = "none";
  } else if (mainVideo.volume >= 0.5) {
    volume.title = "Couper le son (m)"
    volume_range.value = mainVideo.volume * 100;
    volumeMuted.style.display = "none";
    volumeLow.style.display = "none";
    volumeHigh.style.display = "block";
  } else {
    volume.title = "Couper le son (m)"
    volume_range.value = mainVideo.volume * 100;
    volumeMuted.style.display = "none";
    volumeLow.style.display = "block";
    volumeHigh.style.display = "none";
  }
}

function muteVolume() {
  if (volume_range.value == 0) {
    let getVolume = localStorage.getItem("volume", `${mainVideo.volume}`);
    if (getVolume) {
      volume_range.value = getVolume * 100;
      mainVideo.volume = getVolume;
    } else {
      mainVideo.volume = 0.5;
      volume_range.value = 50;
    }
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
    let x = e.clientX - 80;
    let totalWidth = video_player.clientWidth;
    let titleWidth = title.clientWidth;
    if (x >= totalWidth - titleWidth) {
      x = totalWidth - titleWidth;
    } else if (x <= titleWidth) {
      x = titleWidth - 20;
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
progressArea.addEventListener("mousemove", (e) => {
  var progressWidthVal = progressArea.clientWidth;
  let x = e.offsetX;
  let videoDuration = mainVideo.duration;
  let progressTime = Math.floor((x / progressWidthVal) * videoDuration);
  if (progressTime <= 0) {
    progressTime = 0
  }
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

// Lecture automatique
auto_play.addEventListener("click", () => {
  auto_play.classList.toggle("active");
  if (auto_play.classList.contains("active")) {
    localStorage.setItem('autoplay', 'active');
    auto_play.title = "Lecture automatique activée";
    title.innerHTML = auto_play.title
  } else {
    localStorage.setItem('autoplay', 'off');
    auto_play.title = "Lecture automatique desactivée";
    title.innerHTML = auto_play.title
  }
});
mainVideo.addEventListener("ended", () => {
  if (auto_play.classList.contains("active")) {
    let counter = document.querySelector('.counter');
        let count = 7;
        controls.classList.add('active');
        counter.classList.add('active');
        countDown = document.querySelector('.counter p')
        setInterval(() => {
        countDown.innerHTML = `Prochaine video dans ${count} s`;
        if (counter.classList.contains('active')) {
            count--
            if (count == 0) {
                count = 0
                next();
            }
        }else{
            count = 7;
        }
        }, 1000)
  } else {
    replay()
  }
})
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
settings_item.forEach(function (btn) {
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
let caption = captions.querySelectorAll("ul li");
mainVideo.addEventListener("loadeddata", () => {
  setInterval(() => {
    let bufferedTime = mainVideo.buffered.end(0);
    let duration = mainVideo.duration;
    let width = (bufferedTime / duration) * 100;
    bufferedBar.style.width = `${width}%`;
  }, 500);
});
if (caption.length <= 1) {
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
caption.forEach((event) => {
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

caption[0].onclick = ()=>{
  closed_caption.classList.remove('active')
  caption_text.innerHTML = "";
}
loopToggles.forEach(loopToggle=>{
  loopToggle.addEventListener("click", () => {
    loopToggles.forEach(loopToggle=>{
    loopToggle.classList.toggle("active");
    const loopOn = loopToggle.querySelector("#loopOn"),
    loopOff = loopToggle.querySelector("#loopOff");
    if (loopToggle.classList.contains("active")) {
      loopOn.style.display = "block";
      loopOff.style.display = "none";
      mainVideo.setAttribute("loop", "");
    } else {
      loopOn.style.display = "none";
      loopOff.style.display = "block";
      mainVideo.removeAttribute("loop");
    }})
  });
})
// Image en incrustation
picture_in_picture.addEventListener("click", () => {
  settings.classList.remove("active");
  settingsBtn.classList.remove("active");
  mainVideo.requestPictureInPicture();
});
// Plein écran
function toggleFullScreenMode() {
  if (document.fullscreenElement == null) {
    video_player.requestFullscreen();
  } else {
    document.exitFullscreen();
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
  let video_player_width = video_player.offsetWidth
  let video_player_heigh = video_player.offsetHeight
  let xLeft = e.offsetX;
  let yTop = e.offsetY;
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
  });
  video_player.addEventListener("mouseleave", () => {
    if (video_player.classList.contains("paused")) {
      if (settingsBtn.classList.contains("active")) {
        controls.classList.add("active");
      } else {
        controls.classList.remove("active");
      }
    } else {
      controls.classList.add("active");
    }
  });
} else {
  if (video_player.classList.contains("paused")) {
    if (settingsBtn.classList.contains("active")) {
      controls.classList.add("active");
    } else {
      controls.classList.remove("active");
    }
  } else {
    controls.classList.add("active");
  }
}
window.addEventListener('unload', () => {
  mainVideo.play()
  var VolumeRangeValue = volume_range.value / 100;
  localStorage.setItem("volume", VolumeRangeValue);
  saveDuration(`${mainVideo.currentTime}`, `${mainVideo.getAttribute('src')}`)
  if (autoplay.classList.contains('active')) {
      localStorage.setItem('autoplay', 'active');
      autoplay.title = "Lecture automatique activée";
  } else {
      autoplay.title = "Lecture automatique desactivée";
      localStorage.setItem('autoplay', 'off');
  }
})
window.addEventListener('load', () => {
  load();
  let getVolume = localStorage.getItem('volume', `${mainVideo.volume}`);
  let autoplay = localStorage.getItem('autoplay');
  if (autoplay) {
      auto_play.classList.replace('active', autoplay);
      if (auto_play.classList.contains('active')) {
          mainVideo.setAttribute('autoplay', '');
          auto_play.title = "Lecture automatique activée";
      } else {
          controls.classList.add('active')
          mainVideo.removeAttribute('autoplay');
          auto_play.title = "Lecture automatique desactivée";
      }
  }
  if (getVolume != 0) {
      mainVideo.volume = getVolume;
      volume_range.value = getVolume * 100;
      document.getElementById('vol-value').value = volume_range.value
      document.getElementById('vol-value').innerHTML = document.getElementById('vol-value').value + "%"
  } else {
      mainVideo.volume = 0.5;
      volume_range.value = 50;
      document.getElementById('vol-value').value = volume_range.value
      document.getElementById('vol-value').innerHTML = document.getElementById('vol-value').value + "%"
  }
  volumechange()
})
let thumb = false
var thumbnails = []; 

var thumbnailWidth = 100;
var thumbnailHeight = 60;
var horizontalItemCount = 5;
var verticalItemCount = 5;
let k = mainVideo.querySelector("source");
if(k == null){
  sources = mainVideo.src
}else{
  sources = mainVideo.querySelector("source").src;
}



var thumbnails = [];
var thumbnailWidth = 162;
var thumbnailHeight = 90;
var horizontalItemCount = 5;
var verticalItemCount = 5;

let preview_video = document.createElement('video');
preview_video.preload = "metadata"
preview_video.width = "250"
preview_video.height = "250"
preview_video.controls = true;
preview_video.src = sources;
preview_video.addEventListener("loadeddata", async function () {
  preview_video.pause();
  var count = 1;
  var id = 1;
  var x = 0, y = 0;
  var array = [];
  var duration = parseInt(preview_video.duration);
  for (var i = 1; i <= duration; i++) {
    array.push(i);
  }
  var canvas;
  var i, j;
  for (i = 0, j = array.length; i < j; i += horizontalItemCount) {
    for (var startIndex of array.slice(i, i + horizontalItemCount)) {
      var backgroundPositionX = x * thumbnailWidth;
      var backgroundPositionY = y * thumbnailHeight;
      var item = thumbnails.find((x) => x.id === id);
      if (!item) {
        canvas = document.createElement("canvas");
        canvas.width = thumbnailWidth * horizontalItemCount;
        canvas.height = thumbnailHeight * verticalItemCount;
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
        canvas = item.canvas;
        item.sec.push({
          index: startIndex,
          backgroundPositionX: -backgroundPositionX,
          backgroundPositionY: -backgroundPositionY,
        });
      }
      var context = canvas.getContext("2d");
      preview_video.currentTime = startIndex;
      await new Promise(function (resolve) {
        var event = function () {
          context.drawImage(
            preview_video,
            backgroundPositionX,
            backgroundPositionY,
            thumbnailWidth,
            thumbnailHeight
          );
          x++;
          // removing duplicate events
          preview_video.removeEventListener("canplay", event);
          resolve();
        };
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
      count = 1;
      x = 0;
      y = 0;
      id++;
    }
  }
  // looping through thumbnail list to update thumbnail
  thumbnails.forEach(function (item) {
    // converting canvas to blob to get short url
    item.canvas.toBlob((blob) => (item.data = URL.createObjectURL(blob)),"image/jpeg");
    // deleting unused property
    delete item.canvas;
  });

  thumb = true
});