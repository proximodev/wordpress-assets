var tag = document.createElement('script');
tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var player;
var userId;
function onYouTubeIframeAPIReady(videoId) {
  player = new YT.Player('player', {
    height: '900',
    width: '100%',
    videoId: videoId,
    playerVars: {
      modestbranding: 1,
      showinfo: 0,
      fs: 0,
    },
    events: {
        'onReady': onPlayerReady
    }
  });
}
  function handler(videoId) {
    if (userId === videoId) {
      player.playVideo()
    } else {
      player.loadVideoById(videoId)
      userId = videoId
    }
  }
  function stopVideo() {
    player.pauseVideo()
  }
  function onPlayerReady(event) {
    event.target.playVideo()
  }