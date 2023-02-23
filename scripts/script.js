mini_player = document.querySelectorAll('.thumbNails')
mini_player.forEach(event => {
    let mini_video = event.querySelector('video');
    event.addEventListener('mouseenter',()=>{
        event.classList.add('playing');
        mini_video.src = `kom${event.getAttribute('data-mini')}`
        mini_video.poster = event.querySelector('img').src
        let playBtn = event.querySelector('button');
        playBtn.onclick = ()=>{
            mini_video.play()
        }
        mini_video.addEventListener('play',()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('GET',`php/watchAction.php?mv=${event.getAttribute('data-mini')}`);
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);
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
            event.classList.remove('playing');
        })
    })
});