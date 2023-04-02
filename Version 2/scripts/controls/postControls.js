var video = document.getElementById("vid");
var bar = document.querySelector(".bar");
var juice = document.querySelector(".juice");
var btn = document.getElementById("play-pause");
var playBtn = document.querySelector(".play-icon");
var pauseBtn = document.querySelector(".pause-icon");
var volumeRange = document.querySelector(".range");
var volumeHigh = document.querySelector(".volume-high-icon");
var volumeLow = document.querySelector(".volume-low-icon");
var volumeMuted = document.querySelector(".volume-muted-icon");

video.addEventListener("pause", function () {
  pauseBtn.style.display = "none";
  playBtn.style.display = "block";
});
video.addEventListener("play", function () {
  pauseBtn.style.display = "block";
  playBtn.style.display = "none";
});
video.addEventListener("timeupdate", function () {
  var juicePos = video.currentTime / video.duration;
  juice.style.width = juicePos * 100 + "%";
});
function rangeSlide(value) {
  document.getElementById("vol-value").innerHTML = value + "%";
}
function changeVolume() {
  video.volume = volumeRange.value / 100;
}
volumeRange.addEventListener("change", () => {
  changeVolume();
});
volumeRange.addEventListener("mousemove", () => {
  changeVolume();
});

function scrub(e) {
  const scrubTime = (e.offsetX / bar.offsetWidth) * video.duration;
  video.currentTime = scrubTime;
}

let mousedown = false;
bar.addEventListener("click", scrub);
bar.addEventListener("mousemove", (e) => mousedown && scrub(e));
bar.addEventListener("mousedown", () => (mousedown = true));
bar.addEventListener("mouseup", () => (mousedown = false));

video.addEventListener("volumechange", () => {
  volumeRange.value = video.volume * 100;
  if (video.muted || video.volume === 0) {
    volumeRange.value = 0;
    volumeMuted.style.display = "block";
    volumeLow.style.display = "none";
    volumeHigh.style.display = "none";
  } else if (video.volume >= 0.5) {
    volumeRange.value = video.volume * 100;
    volumeMuted.style.display = "none";
    volumeLow.style.display = "none";
    volumeHigh.style.display = "block";
  } else {
    volumeRange.value = video.volume * 100;
    volumeMuted.style.display = "none";
    volumeLow.style.display = "block";
    volumeHigh.style.display = "none";
  }
});

btn.addEventListener("click", () => {
  const isVideoPaused = video_player.classList.contains("paused");

  isVideoPaused ? pauseVideo() : playVideo();
});
video.addEventListener("click", () => {
  const isVideoPaused = video_player.classList.contains("paused");

  isVideoPaused ? pauseVideo() : playVideo();
});
