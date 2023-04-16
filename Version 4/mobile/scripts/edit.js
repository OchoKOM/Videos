const videoPlayerContainer = document.querySelector(".videoPlayer");
const title = document.getElementById("title");
const vidInput = document.querySelector("#vidBtn");
const imgInput = document.getElementById("imgBtn");
const lnk = document.getElementById("link");
const mainVideo = document.getElementById("mainVideo");
const fileImg = document.getElementById("imgBtn");
const fileVid = document.getElementById("vidBtn");
const videoPlayer = document.querySelector(".vid");
const play_pause = document.getElementById("vid");
const posterPrev = document.querySelector(".posterView");
const instr = document.querySelector(".instruction");
const vd = document.querySelector(".vd");
const im = document.querySelector(".im");
const vidInstr = document.querySelector(".vidInstr");
const modalclose = document.querySelector(".modalClose");
const closeBtn = document.querySelector(".closeBtn");
const modalCancel = document.querySelector(".modalCancel");
const vidname = document.getElementById("v");
const buttons = document.querySelector(".buttons");
const view = document.getElementById("prevw");

let title1 = vidname.innerHTML;
if (title1.length >= 45) {
  title1 = title1.substring(0, 45) + "...";
  vidname.innerHTML = title1;
}

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
  mainVideo.poster = URL.createObjectURL(fileImg.files[0]);
  instr.style.display = "none";
  posterPrev.style.display = "block";
  posterPrev.src = URL.createObjectURL(fileImg.files[0]);
  im.classList.add("active");
}
function previewVid() {
  mainVideo.src = URL.createObjectURL(fileVid.files[0]);
  fileName = fileVid.files[0].name;
  vidType = fileVid.files[0].type;
  let splitExt = vidType.split("/");
  const vidExt = splitExt[1];
  let splitName = fileName.split("." + vidExt);
  let vidName = splitName[0];
  title.value = vidName;

  if (vidName.length >= 40) {
    vidName = vidName.substring(0, 40) + " ...";
  }
  vidname.innerHTML = vidName;
  if (
    vidExt == "mp4" ||
    vidExt == "webm" ||
    vidExt == "mov" ||
    vidExt == "webm"
  ) {
    buttons.classList.add("active");
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="err">Extension non valide</div>`;
    vd.classList.add("active");
    if (buttons.classList.contains("active")) {
      buttons.classList.remove("active");
    }
  }
}
if (view != null) {
  view.onclick = () => {
    controls.classList.add("active");
    mainVideo.pause();
    videoPlayerContainer.classList.toggle("active");
  };
}
