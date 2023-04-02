const quality = document.getElementById("quality");
const videoDuration = document.getElementById("duration");
var q = quality.value;
mainVideo.addEventListener("canplay", () => {
  q = Math.floor(mainVideo.videoHeight);
  if (q > 0) {
    quality.value = q;
    videoDuration.value = Math.floor(mainVideo.duration)
  }
});
mainVideo.addEventListener('canplay', ()=>{
  vid.querySelector('img').classList.add('active');
})
function stopVideo() {
  playBtn.style.display = "block";
  pauseBtn.style.display = "none";
  video_player.classList.remove("paused");
  mainVideo.pause();
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
imgInput.addEventListener('change', previewImg)
function previewImg() {
  mainVideo.poster = URL.createObjectURL(fileImg.files[0]);
  instr.style.display = "none";
  posterPrev.style.display = "block";
  posterPrev.src = URL.createObjectURL(fileImg.files[0]);
  im.classList.add("active");
}
function posterImg() {
  mainVideo.poster = document.getElementById("posterLnk").value;
  instr.style.display = "none";
  posterPrev.style.display = "block";
  posterPrev.src = document.getElementById("posterLnk").value;
  im.classList.add("active");
}
function previewLnk() {
  view.style.visibility = "hidden";
  vidName = document.getElementById("lnk").value;
  title.setAttribute("required", "");
  if (vidName.length >= 70) {
    vidName = vidName.substring(0, 70) + " ...";
  }
  vd.classList.add("active");
  mainVideo.src = document.getElementById("lnk").value;
  mainVideo.oncanplay = ()=>{{
    view.style.visibility = "visible";
  }}
}
vidInput.addEventListener('change', previewVid)
function previewVid() {
  fileName = fileVid.files[0].name;
  vidType = fileVid.files[0].type;
  let splitExt = vidType.split("/");
  const vidExt = splitExt[1];
  let splitName = fileName.split("." + vidExt);
  vidName = splitName[0];
  title.value = vidName;

  if (vidName.length >= 70) {
    vidName = vidName.substring(0, 70) + " ...";
  }
  if (
    vidExt == "mp4" ||
    vidExt == "avi" ||
    vidExt == "webm" ||
    vidExt == "mov" ||
    vidExt == "webm"
  ) {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else {
    vidInstr.innerHTML = `${vidName}<br><div align=center class="err">Extension non valide</div>`;
    vd.classList.add("active");
  }
  mainVideo.src = URL.createObjectURL(fileVid.files[0]);
  mainVideo.oncanplay = ()=>{{
    view.style.visibility = "visible";
  }}
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
  view.style.visibility = "hidden";
  previewImg();
});
imgInput.addEventListener("change", () => {
  view.style.visibility = "hidden";
  previewVid();
});
vid.addEventListener("mouseover", () => {
  controls.classList.add("active");
});
vid.addEventListener("mouseleave", () => {
  controls.classList.remove("active");
});
vidLnkBtn.addEventListener("click", () => {
  vidLnkBtn.classList.toggle("active");
  if (vidLnkBtn.classList.contains("active")) {
    vidLnkBtn.value = "Importer un fichier";
    vidLnkFld.removeAttribute("hidden");
    vd.setAttribute("hidden", "");
    vidInstr.setAttribute("hidden", "");
    vidInput.value = "";
  } else {
    vidLnkBtn.value = "Utiliser un URL";
    vidLnkFld.setAttribute("hidden", "");
    vd.removeAttribute("hidden");
    vidInstr.removeAttribute("hidden");
  }
});
imgLnkBtn.addEventListener("click", () => {
  if (imgInput.value === "") {
    imgLnkBtn.classList.toggle("active");
    if (imgLnkBtn.classList.contains("active")) {
      imgLnkBtn.value = "Importer un fichier";
      imgLnkFld.removeAttribute("hidden");
      im.setAttribute("hidden", "");
      instr.innerHTML = `Votre image va s'afficher ici`;
      imgInput.value = "";
    } else {
      imgLnkBtn.value = "Utiliser un URL";
      imgLnkFld.setAttribute("hidden", "");
      im.removeAttribute("hidden");
      instr.innerHTML = `Cliquez sur <span class="fa fa-image"></span> pour importer une miniature`;
    }
  }
});
if (prevInput.value == "" && vid.classList.contains("active")) {
  vid.classList.remove("active");
}
pview.onclick = () => {
  if (mainVideo.src != "") {
    vid.classList.toggle("active");
    if (!vid.classList.contains("active")) {
      mainVideo.currentTime = 0;
      stopVideo()
    }
  }
};
setInterval(() => {
  if (!vid.classList.contains("active")) {
    mainVideo.currentTime = 0;
    pauseVideo()
  }
}, 2000);

