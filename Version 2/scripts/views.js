var currentForm = document.querySelector('.current-time'),
inputField = document.querySelector('.current-time')[0],
durationField = document.querySelector('.current-time')[1];
let current_time = Math.floor(mainVideo.currentTime) ;
let duration_time = Math.floor(mainVideo.duration) ;
setInterval(() => {
    current_time = Math.floor(mainVideo.currentTime) ;
    duration_time = Math.floor(mainVideo.duration) ;
    inputField.value = current_time;
    durationField.value = duration_time;
}, 900);
mainVideo.addEventListener('loadeddata',()=>{
    setInterval(() => {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','php/duration.php');
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                }else{
                    console.log('Erreur '+ xhr.status);
                }
            }
        }
        let formData = new FormData(currentForm)
        xhr.send(formData);
    }, 2000);
    currentForm.onsubmit = (e) =>{
        e.preventDefault();
    }
})