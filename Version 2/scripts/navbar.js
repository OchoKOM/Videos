const menuBtn = document.querySelector(".menu-icon span");
const searchBtn = document.querySelector(".search-icon");
const cancelBtn = document.querySelector(".cancel-icon");
const items = document.querySelector(".nav-items");
const form = document.querySelector("form");
menuBtn.onclick = () => {
  items.classList.add("active");
  menuBtn.classList.add("hide");
  searchBtn.classList.add("hide");
  cancelBtn.classList.add("show");
};
cancelBtn.onclick = () => {
  items.classList.remove("active");
  menuBtn.classList.remove("hide");
  searchBtn.classList.remove("hide");
  cancelBtn.classList.remove("show");
  form.classList.remove("active");
  cancelBtn.style.color = "#ff3d00";
};
searchBtn.onclick = () => {
  form.classList.add("active");
  searchBtn.classList.add("hide");
  cancelBtn.classList.add("show");
};
window.onload = ()=>{
  if (document.querySelector('.search-data').value != "") {
    form.classList.add("active");
    searchBtn.classList.add("hide");
    cancelBtn.classList.add("show");
  }
}

setInterval(() => {
  if (document.querySelector('video') != null) {
    document.querySelectorAll('video').forEach(event=>{
      event.removeAttribute('controls');
    })
  }
}, 100);
let a = document.querySelectorAll('a[href]:not([href="#"])');
a.forEach(event=>{
  event.onclick = ()=>{
    if (document.querySelector('video') != null) {
      document.querySelectorAll('video').forEach(video=>{
        video.pause();
        let currentTime = video.currentTime
        video.currentTime = video.duration 
        video.currentTime = currentTime
      })
    }
  }
})
// Fonction pour les mots ou les phrases troplongues
function splitText(el, lng) {
  var text = el.innerText
  if (text.length >= lng) {
      text = text.substring(0, lng) + " ...";
      return `${text}`;
  }
  return `${text}`;
}
const leadingZeroFormatter = new Intl.NumberFormat(undefined, {
  minimumIntegerDigits: 2,
});
function formatTime(time) {
  const seconds = Math.floor(time % 60);
  const minutes = Math.floor(time / 60) % 60;
  const hours = Math.floor(time / 3600);
  const day = Math.floor(time / 86400);
  const week = Math.floor(time / 604800);
  const month = Math.floor(time / 2592000);
  const year = Math.floor(time / (3600 * 24 * 365));
  if (hours === 0 && minutes === 0) {
      return `${seconds} sec`;
  } else if (hours === 0) {
      return `${minutes} min et ${leadingZeroFormatter.format(seconds)} sec`;
  } else if (hours >= 24 && month === 0 && week === 0) {
      return `${day}j` 
  }else if (day >= 7) {
    return `${week} sem.` 
  }else if (month <= 12 && day >= 30) {
      return `${month} mois` 
  }else if (day >= 365) {
      return `${year} ans` 
  }else{
      return `${hours}h`;
  }
}
function formatT(time) {
  const seconds = Math.floor(time % 60);
  const minutes = Math.floor(time / 60) % 60;
  const hours = Math.floor(time / 3600);
  const day = Math.floor(time / 86400);
  const week = Math.floor(time / 604800);
  const month = Math.floor(time / 2592000);
  const year = Math.floor(time / (3600 * 24 * 365));
  if (hours === 0 && minutes === 0) {
      return `${seconds} sec`;
  } else if (hours === 0) {
      return `${minutes} min`;
  } else if (hours >= 24 && month === 0 && week === 0) {
      return `${day}j` 
  }else if (day >= 7) {
    return `${week} sem.` 
  }else if (month <= 12 && day >= 30) {
      return `${month} mois` 
  }else if (day >= 365) {
      return `${year} ans` 
  }else{
      return `${hours}h`;
  }
}