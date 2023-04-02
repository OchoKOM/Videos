<h5 id="<?= $getid ?>" hidden>
    <?= $name ?>
</h5>
<script>
    let time<?=$getid?> = document.querySelector('.time<?=$getid?>')
    setInterval(() => {
        var date1<?=$getid?> = <?=$getDate?>;
        let date<?=$getid?> = new Date().getTime()/1000
        
        let difference<?=$getid?> = date<?=$getid?> - date1<?=$getid?>;
        time<?=$getid?>.innerHTML = `• Il y a  ${formatT(difference<?=$getid?>)}`
    }, 3000);
    var date1<?=$getid?> = <?=$getDate?>;
    let date<?=$getid?> = new Date().getTime()/1000
    
    let difference<?=$getid?> = date<?=$getid?> - date1<?=$getid?>;
    time<?=$getid?>.innerHTML = `• Il y a  ${formatT(difference<?=$getid?>)}`
    const vidname = document.getElementById('<?= $getid ?>');
    title1 = vidname.innerHTML
    if (title1.length >= 25) {
        title1 = title1.substring(0, 25) + "...";
        vidname.innerHTML = title1;
    }
</script>
<script src="Mobile/scripts/player.js"></script>
<script src="Mobile\scripts\elements.js"></script>
<script>
    function next() {
        location.replace('watch?v=<?= $row4 ?>')
    }
    function seeMore(){
        location.replace('<?= $usrPseudo; ?>/videos');
    }
    function prevSave() {
        <?php
        if (isset($_SESSION['auth'])) {
        ?> let getPrev = sessionStorage.setItem('prev_<?= $_SESSION['id'] ?>_<?= $row4 ?>', '<?= $getid ?>');<?php
        } else {
        ?> let getPrev = sessionStorage.setItem('prev<?= $row4 ?>', '<?= $getid ?>');<?php
        }
        ?>
    }
    function prevGet() {
        <?php
        if (isset($_SESSION['auth'])) {
        ?> let getPrev = sessionStorage.getItem('prev_<?= $_SESSION['id'] ?>_<?= $getid ?>');<?php
        } else {
        ?> let getPrev = sessionStorage.getItem('prev<?= $getid ?>');<?php
        }
        ?>
    }
    function saveDuration(e,f) {
        <?php
        if (isset($_SESSION['auth'])) {
        ?> 
        localStorage.setItem('duration_<?= $_SESSION['id'] ?>_<?= $getid ?>', e);
        <?php
        }  else {
        ?> localStorage.setItem('duration<?= $getid ?>', e);<?php
        }
        ?>
        localStorage.setItem('src<?= $getid ?>', f);
    }
    function load() {
        document.querySelector('.counter').classList.add('active');
        let counterImg = document.querySelector('.counter img');
        let counterTitle = document.querySelector('.counter .next-title h3');
        let counterUsr = document.querySelector('.counter .next-title h4');       counterTitle.innerText = "<?=$nextName?>";
        counterTitle.innerHTML = splitText(counterTitle, 45);
        counterUsr.innerText = "<?=$nextUsr?>";
        counterImg.src = "<?= $nextPoster ?>";
        document.querySelector('.counter').classList.remove('active');
        <?php
        if (isset($_SESSION['auth'])) {
        ?> let durationGet = localStorage.getItem('duration_<?= $_SESSION['id']; ?>_<?= $getid; ?>', `${video.currentTime}`);<?php
        }  else {
        ?> let durationGet = localStorage.getItem('duration<?= $getid; ?>', `${video.currentTime}`);<?php
        }
        ?>
        if (durationGet) {
            <?php 
            if (isset($_GET['t'])) {
                $time = intval($_GET['t'])
                ?>
                <?php
                if (isset($_SESSION['auth'])) {
                ?> 
                localStorage.setItem('duration_<?= $_SESSION['id'] ?>_<?= $getid ?>', <?=$time?>);
                <?php
                }  else {
                ?> localStorage.setItem('duration<?= $getid ?>', <?=$time?>);<?php
                }
                ?>
                let time = '<?=$url.'watch?v='.$_GET['v'].'&t='.$time?>'
                let url = time.split('&t=')[0];
                location.replace(url);
                <?php
            }else {
                ?>
                mainVideo.currentTime = durationGet;
                <?php
            }
            ?>
        }else{
            <?php 
            if (isset($_GET['t'])) {
                $time = intval($_GET['t'])
                ?>
                let time = '<?=$url.'watch?v='.$_GET['v'].'&t='.$time?>'
                let url = time.split('&t=')[0];
                mainVideo.currentTime = 
                <?php
                if (isset($_SESSION['auth'])) {
                ?> 
                localStorage.setItem('duration_<?= $_SESSION['id'] ?>_<?= $getid ?>', <?=$time?>);
                <?php
                }  else {
                ?> localStorage.setItem('duration<?= $getid ?>', <?=$time?>);<?php
                }
                ?>
                
                location.replace(url);
                <?php
            }
            ?>
        }
        let getautoplay = localStorage.getItem('autoplay');
        <?php
        if (isset($_SESSION['auth'])) {
        ?> let getPrevious = sessionStorage.getItem('prev_<?= $_SESSION['id'] ?>_<?= $getid ?>');<?php
        }  else {
        ?> let getPrevious = sessionStorage.getItem('prev<?= $getid ?>');<?php
        }
        ?>
            autoplay.classList.add(getautoplay);
        if (autoplay.classList.contains('active')) {
            video.setAttribute('autoplay', '');
            autoplay.title = "La lecture automatique est activée";
        } else {
            video.getAttribute('autoplay', false);
            autoplay.title = "La lecture automatique est desactivée";
        }
        if (getPrevious) {
            prevBtn.classList.add('active')
        } else {
            prevBtn.classList.remove('active')
        }
    }
</script>
<script src="Mobile\scripts\controls.js"></script>