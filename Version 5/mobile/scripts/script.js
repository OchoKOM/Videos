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
  // Récupération du nom et du type de la vidéo
  fileName = fileVid.files[0].name;
  vidType = fileVid.files[0].type;

  // Récupération de l'extension de la vidéo
  let splitExt = vidType.split("/");
  const vidExt = splitExt[1];

  // Récupération du nom de la vidéo sans son extension
  let splitName = fileName.split("." + vidExt);
  vidName = splitName[0];

  // Si le nom de la vidéo est trop long, on le raccourcit
  if (vidName.length >= 70) {
    vidName = vidName.substring(0, 70) + " ...";
  }

  // Vérification de l'extension de la vidéo
  const validExt = ["mp4", "webm", "mov", "webm"];
  if (validExt.includes(vidExt)) {
    // Ajout d'une classe CSS aux boutons et affichage du nom de la vidéo avec son extension
    buttons.classList.add("active");
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else {
    // Affichage d'un message d'erreur si l'extension n'est pas valide
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