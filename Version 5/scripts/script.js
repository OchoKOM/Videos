function mobile() {
    const toMatch = [
      /Android/i,
      /webOr/i,
      /iPad/i,
      /iPod/i,
      /BlackBerry/i,
      /Windows Phone/i,
    ];
    return toMatch.some(item=>{
      return navigator.userAgent.match(item);
    })
  }
onresize = function () {
    const first = navigator.userAgent
    setTimeout(() => {
        let second = navigator.userAgent;
        if (first != second) {
            return location.reload();
        }
    }, 500);
}



//! La barre de navigation 

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
if (inputBox != null) {
    inputBox.onkeyup = e=>{
    if (suggestBox != null) {
        setInterval(() => {
            if (e.target.value === "" || e.target.value === " ") {
                suggestBox.innerHTML = ""
            }
        }, 1);
        let xhr = new XMLHttpRequest();
        
        if (inputBox === document.querySelector("input[name=vs]")) {
        if (location.href.includes("picture/")) {
            xhr.open('GET','../php/duration.php?searchUser');
        }else{
            xhr.open('GET','./php/duration.php?searchUser');
        }
        }else{
        if (location.href.includes("edit_video/")) {
            xhr.open('GET','../php/duration.php?search');
        }else{
            xhr.open('GET','./php/duration.php?search');
        }
        }
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
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
//todo Lecture automatique à l'accueil
const mini_players = document.querySelectorAll('.thumbNails'),
all_button = document.querySelectorAll('button:not(.sound)'),
all_videos = document.querySelectorAll('video'),
volumebutton = document.querySelectorAll(".sound"),
volumeMuted = document.querySelectorAll(".volume-muted-icon"),
volumeHigh = document.querySelectorAll(".volume-high-icon");
var init = function() {
    document.addEventListener('touchstart', handler, true);
    document.addEventListener('touchmove', handler, true);
    document.addEventListener('touchend', handler, true);
    document.addEventListener('touchcancel', handler, true);        
};
var handler = function touch(event) {
    var touch = event.changedTouches[0],
        simulatedEvent = document.createEvent('MouseEvent');

    simulatedEvent.initMouseEvent(
        { touchstart: 'mousedown', touchmove: 'mousemove', touchend: 'mouseup' } [event.type],
        true, true, window, 1, 
        touch.screenX, touch.screenY, touch.clientX, touch.clientY,
        false, false, false, false, 0, null);

    touch.target.dispatchEvent(simulatedEvent);
};
document.body.addEventListener('click', ()=>{
    all_button.forEach(button =>{
        button.classList.remove('active');
    })
    all_videos.forEach(el => {
        if (!el.classList.contains('active')) {
            el.classList.add('active');
        }
        el.classList.add('active');
    });
})
document.onscroll = ()=>{
    mini_players.forEach(mini_player => {
        isVisible(mini_player)
    })
}
document.ontouchmove = ()=>{
    mini_players.forEach(mini_player => {
        isVisible(mini_player)
    })
}

document.addEventListener("touchmove", ()=>{
    if (autoplay) {
        setInterval(autoPlay, 1);
    }
})
mini_players.forEach(mini_player => {
    let mini_poster = mini_player.querySelector("[data-thumbnail]")
    let link = `watch?v=${mini_player.getAttribute('data-mini')}`;
    let mini_video = mini_player.querySelector('video');
    let button = mini_player.querySelector('button:not(.sound)');
    let volume = mini_player.querySelector('.sound');
    let progressBar = mini_player.querySelector('.progress-bar');
    let progress = mini_player.querySelector('.progress');
    if (!volume.classList.contains('on')){mini_video.volume = 0;} 
    mini_video?.addEventListener('play', compteEnRebour(mini_video, button, mini_player, progress))
    mini_video?.addEventListener('waiting', ()=>{
        button?.classList.add('waiting')
    })
    mini_video?.addEventListener('canplay', ()=>{
        button.classList.remove('waiting')
    })
    function scrub(e) {
        let videoDuration = mini_video.duration;
        let progressWidthVal = progressBar.clientWidth;
        let ClickOffsetX = e.offsetX;
        progress.style.width = `${(ClickOffsetX / progressWidthVal) * 100}%`
        mini_video.currentTime = (ClickOffsetX / progressWidthVal) * videoDuration;
    }
    progressBar.addEventListener('touchstart', init, true)
    progressBar.addEventListener('touchmove', (e)=>{
        e.preventDefault();
    })
    progressBar.addEventListener("mousedown", () => {
        progressBar.addEventListener("mousedown", scrub);
        progressBar.addEventListener("mousemove", scrub);
        progressBar.addEventListener("mouseup", () => {
        progressBar.removeEventListener("mousemove", scrub);
    });
    document.addEventListener("mouseup", () => {
        progressBar.removeEventListener("mousemove", scrub);
    });
    });
    mini_video.onclick = ()=>{
        let vidLink = document.createElement('a')
        vidLink.href = link
        mini_video.src = '';
        vidLink.click();
    }
    mini_video.oncontextmenu = (e)=>{
        e.preventDefault()
    }
    let playBtn = mini_player.querySelector('button');
    playBtn.onclick = ()=>{
        let all_videos = document.querySelectorAll('video');
        all_videos.forEach(el => {
            el.classList.add('active');
            mini_video.play();
        });
    }
    volume.addEventListener("click", ()=>{
        volumebutton.forEach(volume => {
            if (volume.classList.contains("on")) {
                volume.classList.remove("on")
                volumeChangeIcon(volume);
            }else{
                volume.classList.add("on");
                volumeChangeIcon(volume);
            }
        })
    });
    mini_poster.addEventListener('mouseenter',()=>{
        const others_players = document.querySelectorAll('.playing');
        mini_player.classList.add('playing');
        removePlayingClasses(others_players)
        mini_video.src = `kom${mini_player.getAttribute('data-mini')}`
        mini_video.poster = mini_player.querySelector('img').src
        mini_video.addEventListener('canplay', ()=>{
            if(mini_video.classList.contains('active'))
                mini_video.play();
        })
        mini_video.addEventListener('play',()=>{
            all_button.forEach(button =>{
                button.classList.remove('active');
            })
            let xhr = new XMLHttpRequest();
            xhr.open('GET',`watch.php?v=${mini_player.getAttribute('data-mini')}`);
            xhr.send();
        })
        mini_player.addEventListener('mouseleave',()=>{
            mini_video.pause();
            mini_video.src = ''
            mini_video.poster = ''
            mini_player.classList.remove('playing');
        })
    })
    mini_poster.addEventListener('touchstart',()=>{
        const others_players = document.querySelectorAll('.playing');
        mini_player.classList.add('playing');
        removePlayingClasses(others_players)
        mini_video.src = `kom${mini_player.getAttribute('data-mini')}`
        mini_video.poster = mini_player.querySelector('img').src
        if(mini_video.classList.contains('active'))
            mini_video.play();
        mini_video.addEventListener('play',()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('GET',`watch?v=${mini_player.getAttribute('data-mini')}`);
            xhr.send();
        })
    }) 
});
// ! Fonction de lecture automatique 
function autoPlay(visible_videos = []) {
    if (mini_players.length == 0) {
        return
    }
    mini_players.forEach(mini_player => {
        if(isInViewport(mini_player)){
            visible_videos.push(mini_player);
        } 
    })
    let mini_player = visible_videos[0];
    let mini_video = mini_player.querySelector('video');
    let progress = mini_player.querySelector('.progress');
    let button = mini_player.querySelector('button:not(.sound)');
    const others_players = document.querySelectorAll('.playing');
    if (others_players.length === 0) {
        mini_player.classList.add('playing');
        mini_video.src = `kom${mini_player.getAttribute('data-mini')}`
        mini_video.poster = mini_player.querySelector('img').src
        if(mini_video.classList.contains('active'))
            mini_video.play();
        mini_video.addEventListener('play',()=>{
            compteEnRebour(mini_video, button, mini_player, progress)
            let xhr = new XMLHttpRequest();
            xhr.open('GET',`watch?v=${mini_player.getAttribute('data-mini')}`);
            xhr.send();
        })
    }
    document.addEventListener("touchend", ()=>{
        visible_videos = [];
    })
}
// ? Vérifier si un élément est visible
function isInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)

    );
}
function isVisible (el){
    const check = isInViewport(el) ? false : true
    if(check) removePlayingClass(el);
} 
// ! Fonction du temps de vidéo à l'accueil

function compteEnRebour(video, play, player, juice) {
    video?.addEventListener('timeupdate', (e)=>{
        let rebour = formatDuration(video.duration - video.currentTime)
        if (rebour == '0:00') {
            rebour = 'Lire'
        }
        play?.setAttribute('data-time', rebour)
        play.title = rebour
        if (Math.floor(video.currentTime) != 0) {
            link = `watch?v=${player.getAttribute('data-mini')}&t=${Math.floor(video.currentTime)}`;
        }
        let currentVideoTime = video.currentTime;
        let videoDuration = video.duration;
        // La barre de progression
        let progressWidth = (currentVideoTime / videoDuration) * 100;
        juice.style.width = `${progressWidth}%`;
    })
    function removeCursor() {
        var cursotTimeout = setTimeout(() => {
            video.style.cursor = "none";
            clearTimeout(cursotTimeout);
        }, 3000);
    }
    video.addEventListener('mousemove', ()=>{
        video.style.cursor = "pointer";
        video?.addEventListener('timeupdate', removeCursor)
    })
    video?.addEventListener('play', removeCursor)
}
function formatDuration(time) {
    if (isNaN(time)) {
        time = 0;
    }
    const seconds = Math.floor(time % 60);
    const minutes = Math.floor(time / 60) % 60;
    const hours = Math.floor(time / 3600);
    if (hours === 0) {
        return `${minutes}:${leadingZeroFormatter.format(seconds)}`;
    } else {
        return `${hours}:${leadingZeroFormatter.format(minutes)}:${leadingZeroFormatter.format(seconds)}`;
    }
}
function removePlayingClasses(players) {
    players.forEach(player =>{
        removePlayingClass(player)
    })
}
function removePlayingClass(player) {
    let mini_video = player.querySelector('video');
    mini_video.pause();
    mini_video.src = ''
    mini_video.poster = ''
    player.classList.remove('playing');
}
function volumeChangeIcon(e) {
  if (e.classList.contains('on')) {
    volumeMuted.forEach(item=>{
      item.style.display = "none";
    })
    volumeHigh.forEach(item=>{
      item.style.display = "block";
    })
    mini_players.forEach(mini_player => {
        let video = mini_player.querySelector('video');
        video.removeAttribute('muted','');
        video.volume = 1;
    })
  }else{
    volumeMuted.forEach(item=>{
      item.style.display = "block";
    })
    volumeHigh.forEach(item=>{
      item.style.display = "none";
    })
    mini_players.forEach(mini_player => {
        let video = mini_player.querySelector('video');
        video.setAttribute('muted','')
        video.volume = 0;
    })
  }
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
  // todo Fonction pour les URL
  function blobVideoUrl(link) {
    const blob = new Blob([link]);
    const url = URL.createObjectURL(blob)
    return url;
  }
  // ? Formatage des nombres inférieur à 10
  const leadingZeroFormatter = new Intl.NumberFormat(undefined, {
    minimumIntegerDigits: 2,
  });
  
  // * Formatage de temps
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