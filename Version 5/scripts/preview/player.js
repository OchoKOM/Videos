let vidP = document.querySelector('.vid');
const ic = document.getElementById('logo').value
vidP.innerHTML = `${vidP.innerHTML}
<img src="${ic}" alt="">
<div class="controls">
    <div class="bar" id="bar"> 
        <div class="juice"></div>
    </div>
    <div class="buttons">
        <div class="play-pause" id="play-pause">
            <svg class="play-icon" viewBox="0 0 24 24">
                <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
            </svg>
            <svg class="pause-icon" viewBox="0 0 48 48" style="display:none;">
                <path   fill="currentColor" d="M28.25 38V10H36v28ZM12 38V10h7.75v28Z"/>
            </svg>
        </div>
        <div class="vol">
            <div class="volume">
                <svg class="volume-high-icon" viewBox="0 0 48 48" >
                    <path fill="currentColor" d="M28 41.45v-3.1q4.85-1.4 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4 10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24 8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27 32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>                                </svg>
                <svg class="volume-low-icon" viewBox="0 0 48 48"  style="display:none;">
                    <path fill="currentColor" d="M10 30V18h8L28 8v32L18 30Zm21 2.4V15.55q2.7.85 4.35 3.2Q37 21.1 37 24q0 2.95-1.65 5.25T31 32.4Zm-6-16.8L19.35 21H13v6h6.35L25 32.45ZM18.9 24Z"/>
                </svg>
                <svg class="volume-muted-icon" viewBox="0 0 45 45" style="display:none;">
                    <path fill="currentColor" d="m40.65 45.2-6.6-6.6q-1.4 1-3.025 1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425 2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8 43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2 1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2 1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3 14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
                </svg>
            </div>
            <input type="range" min="0" max="100"step="1" value="100" class="range" onchange="rangeSlide(this.value)" onmousemove="rangeSlide(this.value)">
            <span id="vol-value">100%</span>
        </div>
    </div>
</div>`