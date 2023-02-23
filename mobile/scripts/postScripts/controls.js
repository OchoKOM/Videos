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

var launchFullScreen = function (el) {
  if (el.requestFullscreen) {
    el.requestFullscreen();
  } else if (el.mozRequestFullScreen) {
    el.mozRequestFullScreen();
  } else if (el.webkitRequestFullscreen) {
    el.webkitRequestFullscreen();
  } else if (el.msRequestFullscreen) {
    el.msRequestFullscreen();
  }
};

var fullscreenExit = function () {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }
};

// Screen orientation
window.screen.orientation.onchange = function () {
  if (vid.classList.contains("active")) {
    if (this.type.startsWith("landscape")) {
    if (document.fullscreenElement == null) {
      launchFullScreen(video_player);
      controls.classList.add("active");
    }
    } else {
      if (document.fullscreenElement == null) {
      } else {
        fullscreenExit();
        controls.classList.add("active");
      }
    }
  }
};

// Les fonctions

// Fonction play
function playVideo() {
  playBtn.style.display = "none";
  pauseBtn.style.display = "block";
  video_player.classList.add("paused");
  video.play();
}
// Fonction pause
function pauseVideo() {
  playBtn.style.display = "block";
  pauseBtn.style.display = "none";
  video_player.classList.remove("paused");
  video.pause();
}

// Fonction pour formater la durée
function formatDuration(time) {
  const seconds = Math.floor(time % 60);
  const minutes = Math.floor(time / 60) % 60;
  const hours = Math.floor(time / 3600);
  if (hours === 0) {
    return `${minutes}:${leadingZeroFormat.format(seconds)}`;
  } else {
    return `${hours}:${leadingZeroFormat.format(
      minutes
    )}:${leadingZeroFormat.format(seconds)}`;
  }
}
// Fonction plein écran
function toggleFullScreenMode() {
  if (document.fullscreenElement == null) {
    video_player.requestFullscreen();
    screen.orientation.lock('landscape');
  } else {
    screen.orientation.lock('portrait');
    document.exitFullscreen();
  }
}
function removeControls() {
  controls.classList.remove("active")
}
function removeActiveClasses(e) {
  e.forEach((event) => {
    event.classList.remove("active");
  });
}
// Les evenements
video.addEventListener("loadeddata", () => {
  setInterval(() => {
    let bufferedTime = video.buffered.end(0);
    let duration = video.duration;
    let width = (bufferedTime / duration) * 100;
    bufferedBar.style.width = `${width}%`;
  }, 500);
});
video.addEventListener("click", () => {
  controls.classList.add("active");
});
video.addEventListener("canplay", () => {
  webicon.classList.add('active');
});
overlay.addEventListener('touchstart', removeControls)
closeControls.addEventListener("click", removeControls);
volume.addEventListener("click", ()=>{
  volume.classList.toggle('active');
  if (volume.classList.contains('active')) {
    volumeMuted.style.display = "none";
    volumeHigh.style.display = "block";
    video.removeAttribute('muted','');
    video.volume = 1;
  }else{
    volumeMuted.style.display = "block";
    volumeHigh.style.display = "none";
    video.setAttribute('muted','')
    video.volume = 0;
  }
})
skip10.addEventListener("click", ()=>{
  video.currentTime += 10
})
replay10.addEventListener("click", ()=>{
  video.currentTime -= 10
})
progressArea.addEventListener('touchstart', init, true)
progressArea.addEventListener("mousemove", (e) => {
  var progressWidthVal = progressArea.clientWidth;
  let x = e.offsetX;
  let videoDuration = video.duration;
  let progressTime = Math.floor((x / progressWidthVal) * videoDuration);
  progressBar.style.width = `${(x / progressWidthVal) * 100}%`
  progressBar.style.maxWidth ="100%"
  video.currentTime = progressTime
  progressAreaTime.style.setProperty("--x", `${x}px`);
  progressAreaTime.style.display = "block";
  progressAreaTime.innerHTML = `${formatDuration(progressTime)}`;
  if (x < 5) {
     x = 5
  }
  thumbnail.style.setProperty("--x", `${x}px`);
  if (thumb) {
    thumbnail.style.display = "block";
    progressAreaTime.classList.add('thumb')
  }
  progressArea.classList.add('active');
  for (var item of thumbnails) {
    var data = item.sec.find((x1) => x1.index === Math.floor(progressTime));
    if (data) {
      if (item.data != undefined) {
        thumbnail.setAttribute(
          "style",
          `background-image: url(${item.data});
          background-position-x: ${data.backgroundPositionX}px;
          background-position-y: ${data.backgroundPositionY}px;
          --x: ${x}px;
          display: block;`
        );
        return;
      }
    }
  }
  if (progressTime < 0 || x > progressWidthVal) {
    thumbnail.style.display= "none"
    progressAreaTime.style.display = "none";
  }
});
video_player.addEventListener("mouseup", () => {
  thumbnail.style.display= "none"
  progressAreaTime.style.display = "none";
  progressArea.classList.remove('active');
});
playBtn.addEventListener("click", playVideo);
pauseBtn.addEventListener("click", pauseVideo);
replayBtn.addEventListener("click", playVideo);

video.addEventListener("click", () => {
  if (!video.paused ) {
    if (!controls.classList.contains("active")) {
      controls.classList.add("active");
    }
  }
});
video.addEventListener("waiting", () => {
  loader.style.display = "block";
});
video.addEventListener("canplay", () => {
  loader.style.display = "none";
});
video.addEventListener("play", () => {
  playVideo();
});

video.addEventListener("pause", () => {
  pauseVideo();
});
// La durée totale de la vidéo
video.addEventListener("loadeddata", () => {
  duration.innerHTML = formatDuration(video.duration);
});

// Le temps de lecture
video.addEventListener("timeupdate", (e) => {
  current.innerHTML = formatDuration(video.currentTime);
  let currentVideoTime = e.target.currentTime;
  let videoDuration = e.target.duration;
  // La barre de progression
  let progressWidth = (currentVideoTime / videoDuration) * 100;
  progressBar.style.width = `${progressWidth}%`;
});
const leadingZeroFormat = new Intl.NumberFormat(undefined, {
  minimumIntegerDigits: 2,
});

// Plein écran
fullscreenBtn.addEventListener("click", toggleFullScreenMode);

document.addEventListener("fullscreenchange", () => {
  if (document.fullscreenElement == null) {
    video.addEventListener("touchstart", () => {
      controls.classList.add("active");
    });
    if (video_player.classList.contains("openFullScreen")) {
      video_player.classList.remove("openFullScreen");
      fullscreen.style.display = "block";
      exitFullscreen.style.display = "none";
    }
  } else {
    if (!video_player.classList.contains("openFullScreen")) {
      video_player.classList.add("openFullScreen");
      fullscreen.style.display = "none";
      exitFullscreen.style.display = "block";
    }
  }
});

let thumb = false
var thumbnails = [];

var thumbnailWidth = 100;
var thumbnailHeight = 55;
var horizontalItemCount = 5;
var verticalItemCount = 5;
let k = video.querySelector("source");
if(k == null){
  sources = video.src
}else{
  sources = video.querySelector("source").src;
}



let preview_video = document.createElement('video');
preview_video.preload = "metadata"
preview_video.width = "250"
preview_video.height = "250"
preview_video.controls = true
preview_video.src = sources


preview_video.addEventListener("loadeddata", async function () {

  preview_video.pause();

  var count = 1;

  var id = 1;

  var x = 0,
    y = 0;

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
      count = 1;

      x = 0;

      y = 0;

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