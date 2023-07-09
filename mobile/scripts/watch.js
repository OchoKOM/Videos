// Les fonctions
const auth = document.getElementById('user_auth').value == 1 ? true : false
const user_id = document.getElementById('user_id').value,
  video_id = document.getElementById('video_id').value,
  date1 = document.getElementById('video_date').value

function prevSave () {
  const next_id = document.getElementById('next_id').value
  auth
    ? sessionStorage.setItem(`prev_${user_id}_${next_id}`, video_id)
    : sessionStorage.setItem(`prev${next_id}`, video_id)
}
const counterImg = document.querySelector('.counter img')
counterImg.src = document.getElementById('next_poster').value
function saveDuration (e, f) {
  auth
    ? localStorage.setItem(`duration_${user_id}_${video_id}`, e)
    : localStorage.setItem(`duration${video_id}`, e)
  localStorage.setItem(`src${video_id}`, f)
}
let durationGet = auth
  ? localStorage.getItem(
      `duration_${user_id}_${video_id}`,
      `${mainVideo.currentTime}`
    )
  : localStorage.getItem(`duration${video_id}`, `${mainVideo.currentTime}`)
let getPrev = auth
  ? sessionStorage.getItem(`prev_${user_id}_${video_id}`)
  : sessionStorage.getItem(`prev${video_id}`)
if (durationGet) {
  const time_seek_link = location.href.split('&t=')[1]
  let url = location.href.split('&t=')[0]
  if (time_seek_link != undefined) {
    const time_seek_input = time_seek_link.split('s')[0]
    if (time_seek_input != '') {
      const time_seek = parseInt(time_seek_input.match(/\d+/)[0], 10)
      video.currentTime = time_seek
      location.replace(url)
    } else {
      location.replace(url)
    }
  } else {
    video.currentTime = durationGet
  }
} else {
  const time_seek_link = location.href.split('&t=')[1]
  let url = location.href.split('&t=')[0]
  if (time_seek_link != undefined) {
    const time_seek_input = time_seek_link.split('s')[0]
    if (time_seek_input != '') {
      const time_seek = parseInt(time_seek_input.match(/\d+/)[0], 10)
      auth
        ? localStorage.setItem(`duration_${user_id}_${video_id}`, time_seek)
        : localStorage.setItem(`duration${video_id}`, time_seek)
      location.replace(url)
    } else {
      location.replace(url)
    }
  }
}
function load () {
  let getautoplay = localStorage.getItem('autoplay')
  let getPrevious = getPrev
  autoplay.classList.add(getautoplay)
  if (autoplay.classList.contains('active')) {
    video.autoplay
    autoplay.title = 'La lecture automatique est activée'
  } else {
    video.removeAttribute('autoplay')
    autoplay.title = 'La lecture automatique est desactivée'
  }
  if (getPrevious) {
    prevBtn.classList.add('active')
  } else {
    prevBtn.classList.remove('active')
  }
  document.querySelector('.counter').classList.add('active')
  let counterImg = document.querySelector('.counter img')
  let counterTitle = document.querySelector('.counter .next-title h3')
  let counterUsr = document.querySelector('.counter .next-title h4')
  counterTitle.innerText = document.getElementById('next_name').value
  counterTitle.innerHTML = splitText(counterTitle, 50)
  counterUsr.innerText = document.getElementById('next_user').value
  counterImg.src = document.getElementById('next_poster').value
  document.querySelector('.counter').classList.remove('active')
}
function next () {
  const next_id = document.getElementById('next_id').value
  location.replace('watch?v=' + next_id)
}

//! Fonction pour les ecrans tactiles
var init = function () {
  document.addEventListener('touchstart', handler, true)
  document.addEventListener('touchmove', handler, true)
  document.addEventListener('touchend', handler, true)
  document.addEventListener('touchcancel', handler, true)
}
var handler = function touch (event) {
  var touch = event.changedTouches[0],
    simulatedEvent = document.createEvent('MouseEvent')

  simulatedEvent.initMouseEvent(
    { touchstart: 'mousedown', touchmove: 'mousemove', touchend: 'mouseup' }[
      event.type
    ],
    true,
    true,
    window,
    1,
    touch.screenX,
    touch.screenY,
    touch.clientX,
    touch.clientY,
    false,
    false,
    false,
    false,
    0,
    null
  )

  touch.target.dispatchEvent(simulatedEvent)
}

//! Fonction de l'orinetation automatique
var launchFullScreen = function (el) {
  if (el.requestFullscreen) {
    el.requestFullscreen()
      .then(function () {
        // Votre code ici
      })
      .catch(function () {
        // Votre code ici
      })
  } else if (el.mozRequestFullScreen) {
    el.mozRequestFullScreen()
      .then(function () {
        // Votre code ici
      })
      .catch(function () {
        // Votre code ici
      })
  } else if (el.webkitRequestFullscreen) {
    el.webkitRequestFullscreen()
      .then(function () {
        // Votre code ici
      })
      .catch(function () {
        // Votre code ici
      })
  } else if (el.msRequestFullscreen) {
    el.msRequestFullscreen()
      .then(function () {
        // Votre code ici
      })
      .catch(function () {
        // Votre code ici
      })
  }
}

var fullscreenExit = function () {
  if (document.exitFullscreen) {
    document.exitFullscreen()
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen()
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen()
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen()
  }
}
window.screen.orientation.onchange = function () {
  if (this.type.startsWith('landscape')) {
    if (document.fullscreenElement == null) {
      launchFullScreen(video_player)
    }
  } else {
    if (document.fullscreenElement != null) {
      fullscreenExit()
    }
  }
}

function volumeToggle () {
  if (volumeIcon.classList.contains('active')) {
    video.volume = 1
  } else {
    video.volume = 0
  }
}

function replay () {
  if (document.querySelector('.counter').classList.contains('active')) {
    document.querySelector('.counter').classList.remove('active')
  }
  controls.classList.add('active')
  video.pause()
  replayBtn.style.display = 'block'
  playBtn.style.display = 'none'
  pauseBtn.style.display = 'none'
}

// Fonction de copie dans le presse papier
function copyToClipboard (text) {
  const input = document.createElement('input')
  input.setAttribute('value', text)
  document.body.appendChild(input)
  input.select()
  document.execCommand('copy')
  document.body.removeChild(input)
  alert('Copié')
}
// Fonction pour arrondir
function numRoundMultiple (x, y) {
  return Math.round(x / y) * y
}
// Fonction play
function playVideo () {
  playBtn.style.display = 'none'
  pauseBtn.style.display = 'block'
  video_player.classList.add('paused')
  video.play()
}
// Fonction pause
function pauseVideo () {
  playBtn.style.display = 'block'
  pauseBtn.style.display = 'none'
  video_player.classList.remove('paused')
  video.pause()
}
function drawProgress (canvas, buffered, duration) {
  // Récupère le contexte du canvas
  let context = canvas.getContext('2d', { antialias: false })
  // Définit la couleur de remplissage du rectangle
  context.fillStyle = '#fff'

  // Récupère la hauteur et la largeur du canvas
  let height = canvas.height
  let width = canvas.width
  // Vérifie que la hauteur et la largeur sont définies
  if (!height || !width)
    throw "La largeur ou la hauteur du canvas n'est pas définie."
  // Efface le contenu précédent du canvas
  context.clearRect(0, 0, width, height)

  // Parcourt les différentes plages tamponnées de la vidéo
  for (let i = 0; i < buffered.length; i++) {
    // Calcule la position de début et de fin de chaque plage tamponnée en fonction de la durée totale de la vidéo et de la largeur du canvas
    let leadingEdge = (buffered.start(i) / duration) * width
    let trailingEdge = (buffered.end(i) / duration) * width
    // Dessine un rectangle rempli pour chaque plage tamponnée
    context.fillRect(leadingEdge, 0, trailingEdge - leadingEdge, height)
  }
}
// Fonction pour formater la durée
function formatDuration (time) {
  const seconds = Math.floor(time % 60)
  const minutes = Math.floor(time / 60) % 60
  const hours = Math.floor(time / 3600)
  if (hours === 0) {
    return `${minutes}:${leadingZeroFormat.format(seconds)}`
  } else {
    return `${hours}:${leadingZeroFormat.format(
      minutes
    )}:${leadingZeroFormat.format(seconds)}`
  }
}
// Orientation
function lockOrientation (orientation) {
  screen.orientation
    .lock(orientation)
    .then(function () {
      // Votre code ici
    })
    .catch(function () {
      // Votre code ici
    })
}
// Fonction plein écran
function toggleFullScreenMode () {
  if (document.fullscreenElement == null) {
    removeSettings()
    video_player
      .requestFullscreen()
      .then(function () {
        let portrait = false
        video.oncanplay = () => {
          const aspectRatio = video.videoWidth / video.videoHeight
          portrait = aspectRatio >= 0.9 ? false : true
        }
        portrait ? lockOrientation('portrait') : lockOrientation('landscape')
      })
      .catch(function () {
        // Votre code ici ⛶
      })
  } else {
    removeSettings()
    lockOrientation('portrait')
    document.exitFullscreen()
  }
}
function toggleFullscreenOnSlide (e) {
  ;[...e.changedTouches].forEach(touch => {
    const start = touch.pageY
    function screenSlide (e) {
      e.preventDefault()
      ;[...e.changedTouches].forEach(touch => {
        const end = touch.pageY
        var diff = end - start
        if (
          diff > 50 &&
          document.fullscreenElement != null &&
          !settings.classList.contains('active')
        ) {
          toggleFullScreenMode()
        } else if (
          diff < -25 &&
          document.fullscreenElement === null &&
          !settings.classList.contains('active')
        ) {
          const isFullscreenAllowed = video_player.classList.contains('allowed')
            ? true
            : false
          if (isFullscreenAllowed) toggleFullScreenMode()
        }
      })
      video_player.removeEventListener('touchend', screenSlide)
    }
    video_player.addEventListener('touchend', screenSlide)
  })
}
var clickTimer = null
let once = true
function touchStart (e) {
  if (clickTimer == null) {
    clickTimer = setTimeout(function () {
      clickTimer = null
      once = true
    }, 300)
  } else {
    clearTimeout(clickTimer)
    clickTimer = null
    skip(e)
    once = false
  }
}
function skip (e) {
  var offsetWidth = window.innerWidth
  ;[...e.changedTouches].forEach(touch => {
    var touchPos = touch.pageX
    var halfOffset = Math.floor(offsetWidth / 2)
    return touchPos > halfOffset ? scrub(+10) : scrub(-10)
  })
}
function scrub (time) {
  if (time > 0 && video.duration - video.currentTime > 10) {
    skip10.classList.add('active')
    setTimeout(() => {
      skip10.classList.remove('active')
    }, 500)
  } else if (time < 0 && video.currentTime > 10) {
    replay10.classList.add('active')
    setTimeout(() => {
      replay10.classList.remove('active')
    }, 500)
  }
}

function removeSettings () {
  settings.classList.remove('active')
  settingsBtn.classList.remove('active')
  let drop = document.querySelectorAll('.drop')
  if (!settings.classList.contains('active')) {
    drop.forEach(event => {
      if (event.classList.contains('active')) {
        event.classList.remove('active')
        menu_bar.style.marginLeft = '0'
      }
    })
  }
}
function removeControls () {
  if (settings.classList.contains('active')) {
    removeSettings()
  }
  controls.classList.remove('active')
}
function removeActiveClasses (e) {
  e.forEach(event => {
    event.classList.remove('active')
  })
}
// Les evenements
video_player.addEventListener('touchstart', touchStart)
video_player.addEventListener('contextmenu', e => {
  e.preventDefault()
  contextMenu.classList.add('active')
})
video.addEventListener('pointerdown', () => {
  if (contextMenu.classList.contains('active'))
    contextMenu.classList.remove('active')
})
controls.addEventListener('pointerdown', () => {
  if (contextMenu.classList.contains('active'))
    contextMenu.classList.remove('active')
})
addEventListener('blur', () => {
  if (contextMenu.classList.contains('active')) {
    contextMenu.classList.remove('active')
  }
  if (settings.classList.contains('active')) {
    removeSettings()
  }
})
video.addEventListener('touchstart', () => {
  setTimeout(() => {
    if (once) {
      controls.classList.add('active')
    }
  }, 350)
})
overlay.addEventListener('touchstart', removeControls)
video.addEventListener('canplay', () => {
  webicon.classList.add('active')
})
closeControls.addEventListener('touchstart', () => {
  setTimeout(() => {
    if (once) {
      removeControls()
    }
  }, 400)
})
volume.addEventListener('click', () => {
  volumeIcon.classList.toggle('active')
  volume.classList.add('active')
  volumeToggle()
  if (!closed_caption.classList.contains('active')) {
    closed_caption.click()
  }
})
volumeIcon.addEventListener('click', () => {
  volume.classList.add('active')
  volumeIcon.classList.toggle('active')
  volumeToggle()
  if (!closed_caption.classList.contains('active')) {
    closed_caption.click()
  }
})
// Les paramètres
video_player.addEventListener('mouseleave', () => {
  removeSettings()
  if (contextMenu.classList.contains('active'))
    contextMenu.classList.remove('active')
})
settingsBtn.onclick = () => {
  settings.classList.toggle('active')
  settingsBtn.classList.toggle('active')
  let drop = document.querySelectorAll('.drop')
  if (!settings.classList.contains('active')) {
    drop.forEach(event => {
      if (event.classList.contains('active')) {
        event.classList.remove('active')
        menu_bar.style.marginLeft = '0'
      }
    })
  }
}
closeSettings.forEach(cls => {
  cls.addEventListener('click', () => {
    removeSettings()
    if (contextMenu.classList.contains('active'))
      contextMenu.classList.remove('active')
  })
})

settings_item.forEach(function (btn) {
  btn.onclick = () => {
    menu_bar.style.marginLeft = '-95vw'
    var drop = btn.getAttribute('data-drop')
    var sets_items = document.getElementById(drop)
    sets_items.classList.add('active')
  }
})
back_icon.forEach(function (btn) {
  btn.onclick = () => {
    let bk = btn.parentNode
    let sets_items = bk.parentNode
    menu_bar.style.marginLeft = '0'
    sets_items.classList.remove('active')
  }
})
// Vitesse de lecture
playback.forEach(event => {
  event.addEventListener('click', () => {
    if (removeActiveClasses(playback)) {
      event.classList.add('active')
    } else {
      event.classList.add('active')
      let speed = event.getAttribute('data-speed')
      video.playbackRate = speed
    }
  })
})
// Qualité vidéo
qualities.forEach(event => {
  let qualitie_html = `<li data-quality="${event.getAttribute(
    'sizes'
  )}"> <div class="icon check"></div> ${event.getAttribute('sizes')}p </li>`
  if (event.getAttribute('sizes') >= 720) {
    qualitie_html = `<li data-quality="${event.getAttribute(
      'sizes'
    )}"> <div class="icon check"></div> ${event.getAttribute(
      'sizes'
    )}p HD </li>`
  }
  quality_ul.insertAdjacentHTML('afterbegin', qualitie_html)
})

const quality = video_player.querySelectorAll('#quality-drop li')

quality.forEach(event => {
  event.addEventListener('click', () => {
    let size = event.getAttribute('data-quality')
    removeActiveClasses(quality)
    event.classList.add('active')
    qualities.forEach(event => {
      if (event.getAttribute('sizes') == size) {
        let video_current_time = video.currentTime
        let video_source = event.src
        video.src = video_source
        video.setAttribute('sizes', event.getAttribute('sizes'))
        video.currentTime = video_current_time
        playVideo()
      }
    })
  })
})
// Sous-titres
if (tracks.length != 0) {
  for (let i = 0; i < tracks.length; i++) {
    trackLi = `<li class="" data-track="${tracks[i].label}"><div class="icon check"></div>${tracks[i].label}</li>`
    captions_labels.insertAdjacentHTML('beforeend', trackLi)
  }
}
let caption = captions.querySelectorAll('ul li')

closed_caption.onclick = () => {
  closed_caption.classList.toggle('active')
  if (closed_caption.classList.contains('active') && caption.length > 1) {
    caption[1].click()
  } else {
    caption[0].click()
  }
}
if (caption.length <= 1) {
  closed_caption.classList.add('disabled')
  captions_labels.innerHTML = `<li class="active" data-track="Off"><div class="icon check"></div> Non disponible </li>`
}
caption.forEach(event => {
  event.addEventListener('click', () => {
    removeActiveClasses(caption)
    event.classList.add('active')
    closed_caption.classList.add('active')
    changeCaption(event)
  })
})
let track = video.textTracks

function changeCaption (label) {
  let trackLabel = label.getAttribute('data-track')
  for (let i = 0; i < track.length; i++) {
    track[i].mode = 'disabled'
    if (track[i].label == trackLabel) {
      track[i].mode = 'showing'
    }
  }
}
let caption_text = video_player.querySelector('.caption_text')

for (let i = 0; i < track.length; i++) {
  track[i].addEventListener('cuechange', () => {
    if ((track[i].mode = 'showing')) {
      if (track[i].activeCues[0]) {
        let span = `<span><mark>${track[i].activeCues[0].text}</mark></span>`
        caption_text.innerHTML = span
      } else {
        caption_text.innerHTML = ''
      }
    }
  })
}
caption[0].onclick = () => {
  closed_caption.classList.remove('active')
  caption_text.innerHTML = ''
}
loopToggles.forEach(loopToggle => {
  loopToggle.addEventListener('click', () => {
    loopToggles.forEach(loopToggle => {
      loopToggle.classList.toggle('active')
      const loopOn = loopToggle.querySelector('#loopOn'),
        loopOff = loopToggle.querySelector('#loopOff')
      if (loopToggle.classList.contains('active')) {
        loopOn.style.display = 'block'
        loopOff.style.display = 'none'
        mainVideo.setAttribute('loop', '')
      } else {
        loopOn.style.display = 'none'
        loopOff.style.display = 'block'
        mainVideo.removeAttribute('loop')
      }
    })
  })
})

nextBtn.addEventListener('touchstart', () => {
  setTimeout(() => {
    if (once) {
      prevSave()
      next()
    }
  }, 500)
})
prevBtn.addEventListener('touchstart', () => {
  setTimeout(() => {
    if (prevBtn.classList.contains('active') && once) {
      if (getPrev) {
        location.replace(`watch?v=${getPrev}`)
      }
    }
  }, 500)
})
skip10.addEventListener('click', () => {
  video.currentTime += 10
})
replay10.addEventListener('click', () => {
  video.currentTime -= 10
})
progressArea.addEventListener('touchstart', init, true)
progressArea.addEventListener('mousemove', e => {
  e.preventDefault()
  var progressWidthVal = progressArea.clientWidth
  let x = e.offsetX
  let videoDuration = video.duration
  let progressTime = Math.floor((x / progressWidthVal) * videoDuration)
  if (progressTime >= videoDuration) {
    progressTime = videoDuration - 1
  } else if (progressTime <= 0) {
    progressTime = 0
  }
  progressBar.style.width = `${(x / progressWidthVal) * 100}%`
  progressBar.style.maxWidth = '100%'
  video.currentTime = progressTime

  if (x < 20) {
    x = 20
  } else if (x > Math.floor(progressWidthVal - 20)) {
    x = progressWidthVal - 20
  }
  if (thumb) {
    if (x < 5) {
      x = 5
    } else if (x > Math.floor(progressWidthVal - 5)) {
      x = progressWidthVal - 5
    }
  }
  progressAreaTime.style.setProperty('--x', `${x}px`)
  progressAreaTime.style.display = 'block'
  progressAreaTime.innerHTML = `${formatDuration(progressTime)}`
  if (thumb) {
    if (x < 50) {
      x = 50
    } else if (x > Math.floor(progressWidthVal - 50)) {
      x = progressWidthVal - 50
    }
  }

  thumbnail.style.setProperty('--x', `${x}px`)
  if (thumb) {
    thumbnail.style.display = 'block'
    progressAreaTime.classList.add('thumb')
  }
  progressArea.classList.add('active')
  for (var item of thumbnails) {
    var data = item.sec.find(x1 => x1.index === Math.floor(progressTime))
    if (data) {
      if (item.data != undefined) {
        thumbnail.setAttribute(
          'style',
          `background-image: url(${item.data});
          background-position-x: ${data.backgroundPositionX}px;
          background-position-y: ${data.backgroundPositionY}px;
          --x: ${x}px;
          display: block;`
        )
        return
      }
    }
  }
  progressArea.addEventListener('mouseleave', () => {
    thumbnail.style.display = 'none'
    progressAreaTime.style.display = 'none'
    progressArea.classList.remove('active')
  })
  progressArea.addEventListener('mouseup', () => {
    thumbnail.style.display = 'none'
    progressAreaTime.style.display = 'none'
    progressArea.classList.remove('active')
  })
})
video_player.addEventListener('mouseup', () => {
  thumbnail.style.display = 'none'
  progressAreaTime.style.display = 'none'
  progressArea.classList.remove('active')
})
copyURL.addEventListener('click', () => {
  let link = document.querySelector('[data-url="time"] a').href.split('&t=')[0]
  copyToClipboard(link)
})
copySequence.addEventListener('click', () => {
  let link = document.querySelector('[data-url="time"] a').href.split('&t=')[0]
  copyToClipboard(link + timeLink)
})
copyIframe.addEventListener('click', () => {
  let link = document.querySelector('[data-url="time"] a').href.split('&t=')[0]
  link = link.replace('watch', 'embed')
  let iframe = `<iframe width="853" height="480" style="width: 100%;height: 100%;aspect-ratio: 16/9;" src="${link}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe>`
  copyToClipboard(iframe)
})
// mobile() ? console.log('mobile') : console.log('desktop');
if (mobile === true) {
  playBtn.addEventListener('touchstart', playVideo)
  pauseBtn.addEventListener('touchstart', pauseVideo)
  replayBtn.addEventListener('touchstart', () => {
    video.currentTime = 0
    playVideo()
  })
} else {
  playBtn.addEventListener('click', playVideo)
  pauseBtn.addEventListener('click', pauseVideo)
  replayBtn.addEventListener('click', () => {
    video.currentTime = 0
    playVideo()
  })
}

video.addEventListener('touchstart', () => {
  if (!video.paused) {
    if (!controls.classList.contains('active')) {
      controls.classList.add('active')
    }
  }
})
video.addEventListener('waiting', () => {
  loader.style.display = 'block'
})
video.addEventListener('canplay', () => {
  loader.style.display = 'none'
})
video.addEventListener('play', () => {
  playVideo()
})

video.addEventListener('pause', () => {
  pauseVideo()
})
// La durée totale de la vidéo
video.addEventListener('loadeddata', () => {
  duration.innerHTML = formatDuration(video.duration)
})
video.volume = 0
// Le temps de lecture
video.addEventListener('timeupdate', e => {
  current.innerHTML = formatDuration(video.currentTime)
  let currentVideoTime = e.target.currentTime
  let videoDuration = e.target.duration
  // La barre de progression
  let progressWidth = (currentVideoTime / videoDuration) * 100
  progressBar.style.width = `${progressWidth}%`

  let currentForm = document.querySelector('.current-time'),
    inputField = document.querySelector('.current-time')[0],
    durationField = document.querySelector('.current-time')[1],
    current_time,
    duration_time
  current_time = Math.floor(mainVideo.currentTime)
  duration_time = Math.floor(mainVideo.duration)
  inputField.value = current_time
  durationField.value = duration_time
  let xhr = new XMLHttpRequest()
  xhr.open('POST', 'php/duration.php')
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
      } else {
        console.log('Erreur ' + xhr.status)
      }
    }
  }
  let formData = new FormData(currentForm)
  xhr.send(formData)
  currentForm.onsubmit = e => {
    e.preventDefault()
  }
})
const leadingZeroFormat = new Intl.NumberFormat(undefined, {
  minimumIntegerDigits: 2
})
video.addEventListener('progress', () => {
  drawProgress(bufferedBar, video.buffered, video.duration)
})
// La lecture automatique
autoplay.addEventListener('click', () => {
  autoplay.classList.toggle('active')
  if (autoplay.classList.contains('active')) {
    autoplay.title = 'La lecture automatique est activée'
  } else {
    autoplay.title = 'La lecture automatique est desactivée'
  }
})

video.addEventListener('ended', () => {
  var interval_1
  if (auto_play.classList.contains('active')) {
    let counter = document.querySelector('.counter')
    let count = 7
    controls.classList.add('active')
    counter.classList.add('active')
    countDown = document.querySelector('.counter p')
    interval_1 = setInterval(() => {
      countDown.innerHTML = `Prochaine video dans ${count} s`
      if (counter.classList.contains('active')) {
        count--
        if (count == 0) {
          clearInterval(interval_1)
          next()
        }
      } else {
        count = 7
      }
    }, 1000)
  } else {
    replay()
  }
})

// Plein écran
fullscreenBtn.addEventListener('click', toggleFullScreenMode)
video.addEventListener('touchmove', toggleFullscreenOnSlide)
controls.addEventListener('touchmove', toggleFullscreenOnSlide)
document.addEventListener('fullscreenchange', () => {
  if (document.fullscreenElement == null) {
    removeSettings()
    if (video_player.classList.contains('openFullScreen')) {
      video_player.classList.remove('openFullScreen')
      fullscreen.style.display = 'block'
      exitFullscreen.style.display = 'none'
    }
  } else {
    removeSettings()
    if (!video_player.classList.contains('openFullScreen')) {
      video_player.classList.add('openFullScreen')
      fullscreen.style.display = 'none'
      exitFullscreen.style.display = 'block'
    }
  }
})
window.addEventListener('unload', () => {
  video.play()
  saveDuration(video.currentTime, video.src)
  if (autoplay.classList.contains('active')) {
    localStorage.setItem('autoplay', 'active')
    autoplay.title = 'La lecture automatique est activée'
  } else {
    autoplay.title = 'La lecture automatique est desactivée'
    localStorage.setItem('autoplay', 'off')
  }
})
mainVideo.src = 'kom' + video_id
window.addEventListener('load', () => {
  load()
})

document.body.onclick = () => video_player.classList.add('allowed')
let thumb = false
var thumbnails = []
var thumbnailWidth = 100
var thumbnailHeight = 60
var horizontalItemCount = 5
var verticalItemCount = 5

let preview_video = document.createElement('video')
preview_video.preload = 'metadata'
preview_video.width = '250'
preview_video.height = '250'
preview_video.controls = true
let xhr2 = new XMLHttpRequest()
xhr2.open('GET', 'src_' + video_id)
xhr2.onload = () => {
  if (xhr2.readyState === XMLHttpRequest.DONE) {
    const src = xhr2.response
    preview_video.src = src
  }
}
xhr2.send()
// Ajouter un écouteur d'événement pour détecter quand les données de la vidéo ont été chargées
preview_video.addEventListener('loadeddata', async function () {
  // Mettre en pause la vidéo
  preview_video.pause()

  // Initialiser plusieurs variables
  var count = 1
  var id = 1
  var x = 0,
    y = 0

  // Créer un tableau contenant tous les indices de temps de la vidéo
  var array = []
  var duration = parseInt(preview_video.duration)
  for (var i = 1; i <= duration; i++) {
    array.push(i)
  }

  // Boucler à travers le tableau et créer une vignette pour chaque seconde de la vidéo
  var canvas
  var i, j
  for (i = 0, j = array.length; i < j; i += horizontalItemCount) {
    // Parcourir un tableau slice() et dessiner une image extraite de la vidéo à l'aide de la méthode drawImage()
    for (var startIndex of array.slice(i, i + horizontalItemCount)) {
      // Calculer la position de l'image dans le canvas
      var backgroundPositionX = x * thumbnailWidth
      var backgroundPositionY = y * thumbnailHeight

      // Trouver l'objet correspondant à l'image extraite de la vidéo dans le tableau "thumbnails"
      var item = thumbnails.find(x => x.id === id)

      /* Si l'objet n'existe pas dans le tableau "thumbnails", 
      le créer avec un canvas vide et 
      l'ajouter au tableau "thumbnails" */
      if (!item) {
        canvas = document.createElement('canvas')
        canvas.width = thumbnailWidth * horizontalItemCount
        canvas.height = thumbnailHeight * verticalItemCount
        thumbnails.push({
          id: id,
          canvas: canvas,
          sec: [
            {
              index: startIndex,
              backgroundPositionX: -backgroundPositionX,
              backgroundPositionY: -backgroundPositionY
            }
          ]
        })
      } else {
        /* Si l'objet existe déjà dans le tableau "thumbnails", 
        ajouter simplement les informations sur l'image extraite 
        de la vidéo à l'objet existant */
        canvas = item.canvas
        item.sec.push({
          index: startIndex,
          backgroundPositionX: -backgroundPositionX,
          backgroundPositionY: -backgroundPositionY
        })
      }

      // Dessiner une image extraite de la vidéo à l'aide de la méthode drawImage()
      var context = canvas.getContext('2d')
      preview_video.currentTime = startIndex
      await new Promise(function (resolve) {
        var event = function () {
          context.drawImage(
            preview_video,
            backgroundPositionX,
            backgroundPositionY,
            thumbnailWidth,
            thumbnailHeight
          )
          x++
          preview_video.removeEventListener('canplay', event)
          resolve()
        }
        preview_video.addEventListener('canplay', event)
      })
    }
    x = 0
    y++
    if (count > horizontalItemCount * verticalItemCount) {
      count = 1
      x = 0
      y = 0
      id++
    }
  }

  // Convertir les vignettes en objets blob et stocker les URL dans l'objet correspondant
  thumbnails.forEach(function (item) {
    item.canvas.toBlob(
      blob => (item.data = URL.createObjectURL(blob)),
      'image/jpeg'
    )
    delete item.canvas
  })

  // Définir la variable thumb sur true
  thumb = true
})
