<script src="scripts/controls/elements.js"></script>
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
    function seeMore(){
        location.replace('<?= $usrPseudo; ?>/videos');
    }
    function next() {
        location.replace('view.php?v=<?= $row4; ?>');
    }
    const counterImg = document.querySelector('.counter img')
    counterImg.src = "<?= $nextPoster ?>"
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
    <?php
    if (isset($_SESSION['auth'])) {
    ?> let durationGet = localStorage.getItem('duration_<?= $_SESSION['id']; ?>_<?= $getid; ?>', `${mainVideo.currentTime}`);<?php
    }  else {
    ?> let durationGet = localStorage.getItem('duration<?= $getid; ?>', `${mainVideo.currentTime}`);<?php
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
    function load() {
        document.querySelector('.counter').classList.add('active');
        let counterImg = document.querySelector('.counter img');
        let counterTitle = document.querySelector('.counter .next-title h3');
        let counterUsr = document.querySelector('.counter .next-title h4');       counterTitle.innerText = "<?=$nextName?>";
        counterTitle.innerHTML = splitText(counterTitle, 50);
        counterUsr.innerText = "<?=$nextUsr?>";
        counterImg.src = "<?= $nextPoster ?>";
        document.querySelector('.counter').classList.remove('active');
    }
    function next(){
        location.replace('watch?v=<?= $row4 ?>')
    }
</script>
<script src="scripts/controls/controls.js"></script>