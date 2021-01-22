@extends('site.template')
@section('navbar')
  @include('site/navbar')
@endsection
@section('content')
<style type="text/css">
  .jp-audio, .jp-audio-stream, .jp-video {
    font-size: 16px;
    font-family: Verdana,Arial,sans-serif;
    line-height: 1.6;
    color: #666;
    border: none !important;
    background-color: #eee;
  }
  .jp-details .jp-title {
    margin: 0;
    padding: 5px 20px;
    font-size: .72em;
    font-weight: 700;
    color: #333 !important;
    background-color: #2ecc71 !important;
  }
</style>
<section id="mu-page-breadcrumb">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="mu-page-breadcrumb-area">
           <h2>Gallery</h2>
           <ol class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>            
            <li>Gallery</li>
            <li class="active">Video</li>
          </ol>
         </div>
       </div>
     </div>
   </div>
 </section>
<!-- Start gallery  -->
 <section id="mu-gallery">
  <div class="container">
        <div class="mu-gallery-area">
          <div class="mu-gallery-content">
            <div class="mu-gallery-body">
              @foreach($data as $video => $value)
              <div class="col-md-6" style="margin-bottom: 20px">
                <div id="jp_container_{{$value->id}}" class="jp-video jp-video-270p" role="application" aria-label="media player">
                  <div class="jp-type-single">
                    <div id="jquery_jplayer_{{$value->id}}" class="jp-jplayer"></div>
                    <div class="jp-gui">
                      <div class="jp-video-play">
                        <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                      </div>
                      <div class="jp-interface">
                        <div class="jp-progress">
                          <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                          </div>
                        </div>
                        <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                        <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                        <div class="jp-controls-holder">
                          <div class="jp-controls">
                            <button class="jp-play" role="button" tabindex="0">play</button>
                            <button class="jp-stop" role="button" tabindex="0">stop</button>
                          </div>
                          <div class="jp-volume-controls">
                            <button class="jp-mute" role="button" tabindex="0">mute</button>
                            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                            <div class="jp-volume-bar">
                              <div class="jp-volume-bar-value"></div>
                            </div>
                          </div>
                          <div class="jp-toggles">
                            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                            <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                          </div>
                        </div>
                        <div class="jp-details">
                          <div class="jp-title" aria-label="title">&nbsp;</div>
                        </div>
                      </div>
                    </div>
                    <div class="jp-no-solution">
                      <span>Update Required</span>
                      To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <!-- end gallery content -->
          </div>
    </div>
      <div align="right">
        {{ $data->appends(Request::get('search'))->links()}} 
      </div>
  </div>
 </section>
 <!-- End gallery  -->
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    @foreach($data as $video => $value)
      $("#jquery_jplayer_{{$value->id}}").jPlayer({
        ready: function () {
          $(this).jPlayer("setMedia", {
            title: "{{$value->judul}}",
            m4v: "{{url('/')}}/{{$value->filename}}",
            poster: "{{url('/').'/'.$value->thumbnail}}"
          });
        },
        play: function() { // To avoid multiple jPlayers playing together.
          $(this).jPlayer("pauseOthers");
        },
        swfPath: "../../dist/jplayer",
        supplied: "m4v",
        cssSelectorAncestor: "#jp_container_{{$value->id}}",
        globalVolume: true,
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true
      });
    @endforeach
  });
</script>
@endsection