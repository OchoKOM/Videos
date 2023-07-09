const quality = document.getElementById("quality"),
  videoDuration = document.getElementById("duration"),
  formD = document.getElementById("newvideo"),
  uploadProgress = document.querySelector(".upload-progress"),
  progress = document.querySelector(".progress"),
  confirms = document.querySelector(".confirms"),
  edit = document.querySelector(".edit"),
  fileSize = document.querySelector(".file-size"),
  message = document.querySelector(".message"),
  sessName = document.getElementById("sessName").value;
formD.addEventListener("submit", e => {
  e.preventDefault();
  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'php/postAction.php');
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let w = Math.floor((loaded / total) * 100)
    fileSize.classList.add('uploading')
    progress.style.setProperty("--w", `${w}`);
    fileSize.setAttribute("data-progress", `${w}%`) 
    fileSizeText = formatFileSize(loaded) + " / " + formatFileSize(total);
    fileSize.setAttribute("data-upload", fileSizeText) 
    if (loaded === total) {
     
      xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE){
          const result = xhr.response;
          if (Array.isArray(JSON.parse(result))) {
            const videoId = JSON.parse(result)[1]
            edit.href = "edit_video/"+ videoId;
            progress.classList.add("success");
            confirms.classList.add("success");
            setTimeout(() => {
              fileSize.setAttribute("data-progress", `✔`) 
            }, 1000);
          }else{
            progress.classList.add("warning");
            confirms.classList.add("warning");
            fileSize.setAttribute("data-progress", `❌`) 
            fileSize.setAttribute("data-upload", `En entente`) 
            message.innerText = JSON.parse(result);
            message.style.visibility = "visible";
            edit.href = "#";
          }
        }
      }

    }

  })
  let formData = new FormData(formD)
  xhr.send(formData);
})

var q = quality.value;
mainVideo.addEventListener("canplay", () => {
  q = Math.floor(mainVideo.videoHeight);
  if (q > 0) {
    quality.value = q;
    videoDuration.value = Math.floor(mainVideo.duration)
  }
});
mainVideo.addEventListener('canplay', () => {
  if (vid.querySelector('img') != null) {
    vid.querySelector('img').classList.add('active');
  }
})
function addVideo() {
  hideMsg()
  fileSize.classList.remove('uploading')  
  fileSize.setAttribute("data-progress", ``)
  fileSize.setAttribute("data-upload", "Aucun fichier en cours")
  let classes = ["warning", "success"]
  classes.forEach(fclass => {
      confirms.classList.remove(fclass);
      progress.classList.remove(fclass);
  })
  vidInstr.innerHTML = `Cliquez sur <span class="fa fa-video"></span> pour importer une video`
  vd.classList.remove("active");
  vidInput.value = ''
  instr.style.display = "block";
  posterPrev.style.display = "none";
  im.classList.remove("active");
  imgInput.value = ''
  title.value = ""
  view.style.visibility = "hidden";
  mainVideo.src = ""
}
function stopVideo() {
  playBtn.style.display = "block";
  pauseBtn.style.display = "none";
  video_player.classList.remove("paused");
  mainVideo.pause();
}
function hideMsg() {
  message.style.visibility = "hidden";
  message.innerText = "";
  uploadProgress.classList.remove('uploading')
  if (progress.classList.contains("warning")) {
    progress.classList.remove("warning");
    progress.style.setProperty("--w", `0`);
  }
  fileSize.setAttribute("data-upload", "En entente")
}
function link() {
  lnk.click();
}
function formatFileSize(size) {
  var i = size == 0 ? 0 : Math.floor(Math.log(size) / Math.log(1024));
  return (size / Math.pow(1024, i)).toFixed(2) * 1 + ['B', 'kB', 'MB', 'GB', 'TB'][i];
}
function formatNumber(number, lang = "fr") {
  var i = number == 0 ? 0 : Math.floor(Math.log(number) / Math.log(1000));
  var result = (number / Math.pow(1000, i)).toFixed(2) * 1;
  var isResultIntenger = Number.isInteger(result) ? true : false;
  var prefixes = {
    "fr": ['', 'k', 'M', 'Md', 'T'],
    "en": ['', 'k', 'M', 'B', 'T'],
    "es": ['', 'k', 'M', 'MM', 'B'],
    // ajouter d'autres langues ici
  };
  return isResultIntenger ? result + prefixes[lang][i] : result.toFixed(1) + prefixes[lang][i];
}
imgInput.addEventListener('change', previewImg)
vidInput.addEventListener('change', previewVid)
function previewImg() {
  view.style.visibility = "hidden";
  mainVideo.poster = URL.createObjectURL(fileImg.files[0]);
  instr.style.display = "none";
  posterPrev.style.display = "block";
  posterPrev.src = URL.createObjectURL(fileImg.files[0]);
  im.classList.add("active");
  mainVideo.oncanplay = () => {
    view.style.visibility = "visible";
  }
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
  mainVideo.oncanplay = () => {
    view.style.visibility = "visible";
  }
}
function previewVid() {
  view.style.visibility = "hidden";
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
    // buttons.classList.add("active");
    vidInstr.innerHTML = `${vidName}<br><div align=center class="ext">Vidéo ${vidExt}</div>`;
    vd.classList.add("active");
  } else {
    // Affichage d'un message d'erreur si l'extension n'est pas valide
    vidInstr.innerHTML = `${vidName}<br><div align=center class="err">Extension non valide</div>`;
    vd.classList.add("active");
  }
  title.value = vidName;
  mainVideo.src = URL.createObjectURL(fileVid.files[0]);
  mainVideo.oncanplay = () => {
    view.style.visibility = "visible";
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
requestAnimationFrame(() => {
  if (!vid.classList.contains("active")) {
    mainVideo.currentTime = 0;
    pauseVideo()
  }
});