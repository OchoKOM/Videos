// Selection des elements
const  mainVideo = video_player.querySelector("#main-video"),
  progressAreaTime = video_player.querySelector(".progressAreaTime"),
  action = video_player.querySelectorAll(".actions"),
  webicon = video_player.querySelector(".webicon"),
  title = video_player.querySelector(".tut"),
  controls = video_player.querySelector(".controls"),
  progressArea = video_player.querySelector(".progress-area"),
  progressBar = video_player.querySelector(".progress-bar"),
  bufferedBar = video_player.querySelector(".buffered-progress-bar"),
  fast_rewind = video_player.querySelector(".fast-rewind"),
  play_pause = video_player.querySelector(".play_pause"),
  pause = video_player.querySelector(".pause-icon"),
  play = video_player.querySelector(".play-icon"),
  rePlay = video_player.querySelector(".replay-icon"),
  fast_forward = video_player.querySelector(".fa-fast-forward"),
  playNext = video_player.querySelector(".play-next-icon"),
  volume = video_player.querySelector(".volume"),
  volumeHigh = video_player.querySelector(".volume-high-icon"),
  volumeLow = video_player.querySelector(".volume-low-icon"),
  volumeMuted = video_player.querySelector(".volume-muted-icon"),
  volume_range = video_player.querySelector(".volume_range"),
  current = video_player.querySelector(".current"),
  totalDuration = video_player.querySelector(".duration"),
  auto_play = video_player.querySelector(".auto-play"),
  closed_caption = video_player.querySelector('.closed-caption'),
  settingsBtn = video_player.querySelector(".settingsBtn"),
  picture_in_picture = video_player.querySelector(".picture_in_picture"),
  fullscreen = video_player.querySelector(".fullscreen"),
  exitFullscreen = video_player.querySelector(".exitFullscreen"),
  settings = video_player.querySelector(".settings"),
  settingHome = video_player.querySelectorAll('#settings [data-label="settingHome"] >ul>li'),
  menu_bar = video_player.querySelector(".menu-bar"),
  home_items = video_player.querySelectorAll(".drop-item"),
  settings_item = video_player.querySelectorAll(".drop-item"),
  back_icon = video_player.querySelectorAll(".back-icon"),
  captions_labels = video_player.querySelector("#captions-drop ul"),
  captions = video_player.querySelector("#captions-drop"),
  captionToggle = document.querySelector(".caption-line"),
  tracks = video_player.querySelectorAll("track"),
  loopToggle = video_player.querySelector(".loop-line"),
  playback = video_player.querySelectorAll("#speed-drop li"),
  qualities = video_player.querySelectorAll("source[sizes]"),
  quality = video_player.querySelectorAll("#quality-drop li"),
  loader = video_player.querySelector(".loader");