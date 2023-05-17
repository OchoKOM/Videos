var video = document.getElementById("vid"),
bar = document.querySelector(".bar"),
juice = document.querySelector(".juice"),
btn = document.getElementById("play-pause"),
playBtn = document.querySelector(".play-icon"),
pauseBtn = document.querySelector(".pause-icon"),
volumeRange = document.querySelector(".range"),
volume_high = document.querySelector(".volume-high-icon"),
volume_low = document.querySelector(".volume-low-icon"),
volume_muted = document.querySelector(".volume-muted-icon");

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
    volume_muted.style.display = "block";
    volume_low.style.display = "none";
    volume_high.style.display = "none";
  } else if (video.volume >= 0.5) {
    volumeRange.value = video.volume * 100;
    volume_muted.style.display = "none";
    volume_low.style.display = "none";
    volume_high.style.display = "block";
  } else {
    volumeRange.value = video.volume * 100;
    volume_muted.style.display = "none";
    volume_low.style.display = "block";
    volume_high.style.display = "none";
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
