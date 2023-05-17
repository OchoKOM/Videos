// ! Fonction de lecture automatique 
function autoPlay(visible_videos = []) {
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
// ! Fonctions de temps
function times(date, times = document.querySelectorAll('.time')) {
          const timeText = times[0].innerHTML
  for (let i = 0; i < times.length; i++) {
      setInterval(() => {
          var time = times[i];
          let currentDate = new Date().getTime()/1000
          let difference = currentDate - date[i];
          time.innerHTML = `${timeText}  ${formatT(difference)}`
      }, 1000); 
  }
}
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
