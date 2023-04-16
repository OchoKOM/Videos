const vidInput = document.querySelector('#vidBtn');
const imgInput = document.getElementById('imgBtn');
const lnk = document.getElementById('link');
const mainVideo = document.getElementById('vid');
const fileImg = document.getElementById('imgBtn');
const fileVid = document.getElementById('vidBtn');
const video_player = document.querySelector('.vid');
const play_pause = document.getElementById('vid');
const posterPrev = document.querySelector('.posterView');
const instr = document.querySelector('.instruction');
const vd = document.querySelector('.vd');
const im = document.querySelector('.im');
const vidInstr = document.querySelector('.vidInstr');
const modalclose = document.querySelector('.modalClose');
const closeBtn = document.querySelector('.closeBtn');
const modalCancel = document.querySelector('.modalCancel');

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
