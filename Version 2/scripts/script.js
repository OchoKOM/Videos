const mini_player = document.querySelectorAll('.thumbNails');
const all_button = document.querySelectorAll('button');
const all_videos = document.querySelectorAll('video');
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
mini_player.forEach(event => {
    let link = `watch?v=${event.getAttribute('data-mini')}`;
    let mini_video = event.querySelector('video');
    mini_video.addEventListener('timeupdate', ()=>{
        let rebour = formatDuration((Math.floor(mini_video.duration)) - (Math.floor(mini_video.currentTime)))
        if (rebour == '0:00') {
            rebour = 'Lire'
        }
        let button = event.querySelector('button');
        button.setAttribute('data-time', rebour)
        if (Math.floor(mini_video.currentTime) != 0) {
            link = `watch?v=${event.getAttribute('data-mini')}&t=${Math.floor(mini_video.currentTime)}`;
        }
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
    let playBtn = event.querySelector('button');
    playBtn.onclick = ()=>{
        let all_videos = document.querySelectorAll('video');
        all_videos.forEach(el => {
            el.classList.add('active');
            mini_video.play();
        });
    }
    event.addEventListener('mouseenter',()=>{
        event.classList.add('playing');
        mini_video.src = `kom${event.getAttribute('data-mini')}`
        mini_video.poster = event.querySelector('img').src
        mini_video.addEventListener('canplay', ()=>{
            if(mini_video.classList.contains('active'))
                mini_video.play();
        })
        mini_video.addEventListener('play',()=>{
            all_button.forEach(button =>{
                button.classList.remove('active');
            })
            let xhr = new XMLHttpRequest();
            xhr.open('GET',`watch.php?v=${event.getAttribute('data-mini')}`);
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
        event.addEventListener('mouseleave',()=>{
            mini_video.pause();
            mini_video.currentTime = 0;
            mini_video.src = ''
            mini_video.poster = ''
            mini_video.removeAttribute('autoplay')
            event.classList.remove('playing');
        })
    })
    event.addEventListener('touchstart',()=>{
        const others_players = document.querySelectorAll('.playing');
        event.classList.add('playing');
        removePlayingClasses(others_players)
        mini_video.src = `kom${event.getAttribute('data-mini')}`
        mini_video.poster = event.querySelector('img').src
        let playBtn = event.querySelector('button');
        if(mini_video.classList.contains('active'))
            mini_video.play();
        mini_video.addEventListener('play',()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('GET',`watch.php?v=${event.getAttribute('data-mini')}`);
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
    })
});
const leadingZeroFormat = new Intl.NumberFormat(undefined, {
    minimumIntegerDigits: 2,
});
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
        let mini_video = player.querySelector('video');
        mini_video.pause();
        mini_video.currentTime = 0;
        mini_video.src = ''
        mini_video.poster = ''
        mini_video.removeAttribute('autoplay')
        player.classList.remove('playing');
    })
}