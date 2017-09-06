(function ($) {

  var userMediaStream;
  var playlist;
  var constraints = { audio: true };

  navigator.getUserMedia = (navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

  function gotStream(stream) {
    userMediaStream = stream;
    playlist.initRecorder(userMediaStream);
    $(".btn-record").removeClass("disabled");
  }

  function logError(err) {
    if (err.name === 'PermissionDeniedError') {
        $('#playlist').text('您禁止了录音权限，请开启录音权限并刷新页面');
    }
    console.error(err);
  }

  if (navigator.mediaDevices) {
    navigator.mediaDevices.getUserMedia(constraints)
    .then(gotStream)
    .catch(logError);
  } else if (navigator.getUserMedia && 'MediaRecorder' in window) {
    navigator.getUserMedia(
      constraints,
      gotStream,
      logError
    );
  }
  else {
    $('#playlist').text('您的浏览器不支持录音，请使用Chrome v58.0+内核的浏览器');
    console.error('getUserMedia not supported.');
  }

  playlist = WaveformPlaylist.init({
    samplesPerPixel: 5000,
    zoomLevels: [1000, 5000, 9000],
    waveHeight: 100,
    container: document.getElementById("playlist"),
    state: 'cursor',
    colors: {
      waveOutlineColor: '#E0EFF1',
      timeColor: 'grey',
      fadeColor: 'black'
    },
    controls: {
      show: true, //whether or not to include the track controls
      width: 200 //width of controls in pixels
    }
  });

  //initialize the WAV exporter.
  // playlist.initExporter();

  window.playlist = playlist;

})(jQuery);
