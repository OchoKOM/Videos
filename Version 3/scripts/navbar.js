const inputBox = document.querySelector("input[name=q]") || document.querySelector("input[name=vs]"),
suggestBox = document.querySelector(".suggestion"),
menuBtn = document.querySelector(".menu-icon span"),
searchBtn = document.querySelector(".search-icon"),
cancelBtn = document.querySelector(".cancel-icon"),
items = document.querySelector(".nav-items"),
form = document.querySelector("form"),
searchToggles = document.querySelectorAll('.search-toggle'),
topNav = document.querySelector('.top-nav'),
searchBack = document.querySelector('.search-back');
searchToggles.forEach(searchToggle =>{
    searchToggle.addEventListener('click', ()=>{
      inputBox.click()
      topNav?.classList.toggle('search')
    })
})
searchBack?.addEventListener('click', ()=>{
    topNav?.classList.remove('search')
})
menuBtn?.addEventListener('click', ()=>{
  items?.classList.add("active");
  menuBtn?.classList.add("hide");
  searchBtn?.classList.add("hide");
  cancelBtn?.classList.add("show");
});
cancelBtn?.addEventListener('click', ()=>{
  items?.classList.remove("active");
  menuBtn?.classList.remove("hide");
  searchBtn?.classList.remove("hide");
  cancelBtn.classList.remove("show");
  form?.classList.remove("active");
});
searchBtn?.addEventListener('click', ()=>{
  form?.classList.add("active");
  searchBtn.classList.add("hide");
  cancelBtn?.classList.add("show");
});
window.onload = ()=>{
  if (document.querySelector('.search-data')?.value != "") {
    form?.classList.add("active");
    searchBtn?.classList.add("hide");
    cancelBtn?.classList.add("show");
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
  event.addEventListener('click', ()=>{
    if (document.querySelector('video') != null) {
      document.querySelectorAll('video').forEach(video=>{
        video.pause();
        let currentTime = video.currentTime
        video.currentTime = video.duration 
        video.currentTime = currentTime
      })
    }
  })
})
inputBox.onkeyup = e=>{
  if (suggestBox != null) {
    setInterval(() => {
        if (e.target.value === "" || e.target.value === " ") {
            suggestBox.innerHTML = ""
        }
    }, 1);
    let xhr = new XMLHttpRequest();
    if (document.location.href.includes("edit_video")) {
      if (inputBox === document.querySelector("input[name=vs]")) {
        xhr.open('GET','../php/duration.php?searchUser');
      }else{
        xhr.open('GET','../php/duration.php?search');
      }
    }else{
      if (inputBox === document.querySelector("input[name=vs]")) {
        xhr.open('GET','php/duration.php?searchUser');
      }else{
        xhr.open('GET','php/duration.php?search');
      }
    }
    
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
          // console.log(xhr.response);
            let userData = e.target.value
            let emptyArray = [];
            if (userData) {
                const suggestions = JSON.parse(xhr.response);
                emptyArray = suggestions.filter((data)=>{
                    return data.toLocaleLowerCase().includes(userData.toLocaleLowerCase());
                });
                emptyArray = emptyArray.map((data)=>{
                    // passing return data inside li tag
                    let searchValue = inputBox.value;
                    searchValue = searchValue.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")
                    let pattern  = new RegExp(searchValue, "gi")
                    let splitData = data.replace(pattern, match => `<b style="color:#0e26ff;">${match}</b>`)
                    return data = `<li class="option">${splitData}</li>`;
                });
                showSuggestions(emptyArray);
            }
        }
    }
    xhr.send(); 
  }
}
function showSuggestions(list){
    let listData;
    if(!list.length){
      let userValue = inputBox.value;
        listData = `<li class="option">${userValue}</li>`;
    }else{
      listData = list.join('');
    }
    suggestBox.innerHTML = listData;
    let options = suggestBox.querySelectorAll(".option")
    options.forEach(option =>{
        option.addEventListener("click", ()=>{
            inputBox.value = option.innerText
            form.submit()
        })
        splitText(option, 50)
    })
}

// Fonction pour les mots ou les phrases troplongues
function splitText(el, lng) {
  var text = el.innerText
  if (text.length >= lng) {
      text = text.substring(0, lng) + " ...";
      return `${text}`;
  }
  return `${text}`;
}
function blobVideoUrl(link) {
  const blob = new Blob([link]);
  const url = URL.createObjectURL(blob)
  return url;
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