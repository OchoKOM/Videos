const mini_players = document.querySelectorAll('.thumbNails'),
all_button = document.querySelectorAll('button'),
all_videos = document.querySelectorAll('video');
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
    let button = mini_player.querySelector('button');
    mini_video?.addEventListener('play', compteEnRebour(mini_video, button, mini_player))
    mini_video?.addEventListener('waiting', ()=>{
        button?.classList.add('waiting')
    })
    mini_video?.addEventListener('canplay', ()=>{
        button.classList.remove('waiting')
    })
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
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                    }else{
                        console.log('Erreur '+ xhr.status);
                    }
                }
            }
            xhr.send();
        })
        mini_player.addEventListener('mouseleave',()=>{
            mini_video.pause();
            mini_video.currentTime = 0;
            mini_video.src = ''
            mini_video.poster = ''
            mini_video.removeAttribute('autoplay')
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
function compteEnRebour(video, play, player) {
    video?.addEventListener('timeupdate', ()=>{
        let rebour = formatDuration((Math.floor(video.duration)) - (Math.floor(video.currentTime)))
        if (rebour == '0:00') {
            rebour = 'Lire'
        }
        play?.setAttribute('data-time', rebour)
        if (Math.floor(video.currentTime) != 0) {
            link = `watch?v=${player.getAttribute('data-mini')}&t=${Math.floor(video.currentTime)}`;
        }
    })
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
    mini_video.currentTime = 0;
    mini_video.src = ''
    mini_video.poster = ''
    mini_video.removeAttribute('autoplay')
    player.classList.remove('playing');
}