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
function posterImg() {
  mainVideo.poster = document.getElementById("posterLnk").value;
  instr.style.display = "none";
  posterPrev.style.display = "block";
  posterPrev.src = document.getElementById("posterLnk").value;
  im.classList.add("active");
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
function stopVideo() {
  playBtn.style.display = "block";
  pauseBtn.style.display = "none";
  video_player.classList.remove("paused");
  mainVideo.pause();
}
vidInput.addEventListener("change", () => {
  previewImg();
});
imgInput.addEventListener("change", () => {
  previewVid();
});
vid.addEventListener("mouseover", () => {
  controls.classList.add("active");
});
vid.addEventListener("mouseleave", () => {
  controls.classList.remove("active");
});
imgLnkBtn.addEventListener("click", () => {
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
});

let oldTitleText = oldTitle.innerText;
if (oldTitleText.length >= 40) {
  oldTitleText = oldTitleText.substring(0, 40) + " ...";
}
oldTitle.innerText = oldTitleText;

pview.onclick = () => {
  if (mainVideo.src != "") {
    vid.classList.toggle("active");
    if (!vid.classList.contains("active")) {
      mainVideo.currentTime = 0;
      stopVideo()
    }
  }
};
if (!vid.classList.contains("active")) {
  mainVideo.currentTime = 0;
  mainVideo.pause();
}
var modalBtns = document.querySelectorAll(".modal-op");

modalBtns.forEach(function (btn) {
  btn.onclick = function () {
    var modal = btn.getAttribute("data-modal");

    document.getElementById(modal).classList.add("active");
  };
});

var closeBtns = document.querySelectorAll(".modal-close");

closeBtns.forEach(function (btn) {
  btn.onclick = function () {
    var modal = btn.closest(".modal").classList.remove("active");
  };
});
mainVideo.addEventListener('canplay', ()=>{
  vid.querySelector('img').classList.add('active');
})
