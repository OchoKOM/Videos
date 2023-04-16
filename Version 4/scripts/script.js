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
}, {
    passive: true
}
document.ontouchmove = ()=>{
    mini_players.forEach(mini_player => {
        isVisible(mini_player)
    })
}, {
    passive: true
}
mini_players.forEach(mini_player => {
    let mini_poster = mini_player.querySelector("[data-thumbnail]")
    let link = `watch?v=${mini_player.getAttribute('data-mini')}`;
    let mini_video = mini_player.querySelector('video');
    let button = mini_player.querySelector('button:not(.sound)');
    let volume = mini_player.querySelector('.sound');
    let progressBar = mini_player.querySelector('.progress-bar');
    let progress = mini_player.querySelector('.progress');
    if (!volume.classList.contains('on')){mini_video.volume = 0;} 
    mini_video?.addEventListener('play', compteEnRebour(mini_video, button, mini_player, progressBar, progress))
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
        let playBtn = mini_player.querySelector('button');
        if(mini_video.classList.contains('active'))
            mini_video.play();
        mini_video.addEventListener('play',()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('GET',`watch.php?v=${mini_player.getAttribute('data-mini')}`);
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status != 200){
                        console.log('Erreur '+ xhr.status);
                    }
                }
            }
            xhr.send();
        })
    })
});
const leadingZeroFormat = new Intl.NumberFormat(undefined, {
    minimumIntegerDigits: 2,
})
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
function compteEnRebour(video, play, player, bar, juice) {
    video?.addEventListener('timeupdate', (e)=>{
        let rebour = formatDuration((Math.floor(video.duration)) - (Math.floor(video.currentTime)))
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
        return `${minutes}:${leadingZeroFormat.format(seconds)}`;
    } else {
        return `${hours}:${leadingZeroFormat.format(minutes)}:${leadingZeroFormat.format(seconds)}`;
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