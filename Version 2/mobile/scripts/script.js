const vidInput = document.querySelector("#vidBtn");
const imgInput = document.getElementById("imgBtn");
const lnk = document.getElementById("link");
const mainVideo = document.getElementById("vid");
const fileImg = document.getElementById("imgBtn");
const fileVid = document.getElementById("vidBtn");
const video_player = document.querySelector(".vid");
const play_pause = document.getElementById("vid");
const posterPrev = document.querySelector(".posterView");
const instr = document.querySelector(".instruction");
const vd = document.querySelector(".vd");
const im = document.querySelector(".im");
const vidInstr = document.querySelector(".vidInstr");
const modalclose = document.querySelector(".modalClose");
const closeBtn = document.querySelector(".closeBtn");
const modalCancel = document.querySelector(".modalCancel");

function hideMsg() {
  document.querySelector(".message").style.display = "none";
}
function vidInp() {
  vidInput.click();
}
function imgInp() {
  imgInput.click();
}
function link() {
  lnk.click();
}
function previewImg() {
  instr.style.display = "none";
  posterPrev.style.display = "block";
  posterPrev.src = URL.createObjectURL(fileImg.files[0]);
  im.classList.add("active");
}
function previewVid() {
  fileName = fileVid.files[0].name;
  vidType = fileVid.files[0].type;
  let splitExt = vidType.split("/");
  const vidExt = splitExt[1];
  let splitName = fileName.split("." + vidExt);
  vidName = splitName[0];

  if (vidName.length >= 70) {
    vidName = vidName.substring(0, 70) + " ...";
  }
  if (vidExt == "mp4") {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else if (vidExt == "avi") {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else if (vidExt == "webm") {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else if (vidExt == "mov") {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else if (vidExt == "webm") {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="err">Extension non valide</div>`;
    vd.classList.add("active");
  }
}
// Fonction pour lire
function playVideo() {
  video_player.classList.add("paused");
  mainVideo.play();
}
// Fonction pause
function pauseVideo() {
  video_player.classList.remove("paused");
  mainVideo.pause();
}
vidInput.addEventListener("change", () => {
  previewImg();
});
imgInput.addEventListener("change", () => {
  previewVid();
});
