const vidInput = document.querySelector('#vidBtn'),
imgInput = document.getElementById('imgBtn'),
lnk = document.getElementById('link'),
mainVideo = document.getElementById('vid'),
fileImg = document.getElementById('imgBtn'),
fileVid = document.getElementById('vidBtn'),
video_player = document.querySelector('.vid'),
play_pause = document.getElementById('vid'),
posterPrev = document.querySelector('.posterView'),
instr = document.querySelector('.instruction'),
vd = document.querySelector('.vd'),
im = document.querySelector('.im'),
vidInstr = document.querySelector('.vidInstr'),
modalclose = document.querySelector('.modalClose'),
closeBtn = document.querySelector('.closeBtn'),
modalCancel = document.querySelector('.modalCancel');

function hideMsg() {
    document.querySelector('.message').style.display= "none";
}
function vidInp() {
    vidInput.click();
}
function imgInp() {
    imgInput.click();
}
function link() {
    document.querySelector('.post').click()
}
function previewImg(){
    mainVideo.poster = URL.createObjectURL(fileImg.files[0]);
    instr.style.display="none";
    posterPrev.style.display="block";
    posterPrev.src = URL.createObjectURL(fileImg.files[0]);
    im.classList.add('active');
}
function previewVid(){
    vidName = fileVid.files[0].name;
    vidType = fileVid.files[0].type;
    let splitExt = vidType.split('/');
    const  vidExt = splitExt[1];
    if(vidName.length >= 25){
        vidName = vidName.substring(0, 25) + " ..."
    }
    if(vidExt == "mp4"){
        vidInstr.innerHTML = `${vidName}`;
        vd.classList.add('active');
    }else if(vidExt == "avi"){
        vidInstr.innerHTML = `${vidName}`;
        vd.classList.add('active');
    }else if(vidExt == "webm"){
        vidInstr.innerHTML = `${vidName}`;
        vd.classList.add('active');
    }else if(vidExt == "mov"){
        vidInstr.innerHTML = `${vidName}`;
        vd.classList.add('active');
    }else if(vidExt == "webm"){
        vidInstr.innerHTML = `${vidName}`;
        vd.classList.add('active');
    }else{
        vidInstr.innerHTML = `<div align=center class="err">Extension non valide</div>`;
        vd.classList.add('active');
    }
    mainVideo.src = URL.createObjectURL(fileVid.files[0]);
}
 // Fonction pour lire
function playVideo(){
    video_player.classList.add('paused');
    mainVideo.play();
}

// Fonction pause
function pauseVideo(){
    video_player.classList.remove('paused')
    mainVideo.pause();
}
vidInput.addEventListener('change', () => {
    previewImg();
});
imgInput.addEventListener('change', () => {
    previewVid();
});
mainVideo.addEventListener('ended', () => {
    video_player.classList.remove('paused')
    mainVideo.currentTime = 0;
});
play_pause.addEventListener('click', () => {
    const isVideoPaused = video_player.classList.contains('paused');

    isVideoPaused ? pauseVideo() :playVideo() ; 
});
mainVideo.addEventListener('click', () => {
    const isVideoPaused = video_player.classList.contains('paused');

    isVideoPaused ? pauseVideo() :playVideo() ; 
});
modalclose.addEventListener('click',()=>{
    video_player.classList.remove('paused')
    mainVideo.pause();
})
closeBtn.addEventListener('click',()=>{
    video_player.classList.remove('paused')
    mainVideo.pause();
})
modalCancel.addEventListener('click',()=>{
    video_player.classList.remove('paused');
    mainVideo.pause();
    mainVideo.currentTime=0
    mainVideo.src = URL.createObjectURL(fileVid.files[0]);
})
