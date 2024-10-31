/* 
 * This file is for test only for cunsmuing Peepable Widget events
 * Clients must define their own functions to consume Peepable events
 * 
 */

function onPeepablePlay (e){
    console.debug( "peepableOnplay the video player with the ID : ", e.detail.videoID );
    document.querySelector('.contentName .value').innerHTML = e.detail.videoID;
    document.querySelector('.contentStatus .value').innerHTML = "Playing";
      
}

function onPeepablePause (e){
    console.debug( "peepablePause the video player with the ID : ", e.detail.videoID );
    document.querySelector('.contentStatus .value').innerHTML = "Paused";
}

function onPeepableReady (e) {
        console.debug( "peepableReady the video player with the ID : ", e.detail.videoID );
    document.querySelector('.contentStatus .value').innerHTML = "Ready";
}

function onPeepableDisposed (e) {
    console.debug( "peepableDispose the video player with the ID : ", e.detail.videoID );
    document.querySelector('.contentStatus .value').innerHTML = "";
    document.querySelector('.contentName .value').innerHTML = "";
    document.querySelector('.contentTime .value').innerHTML = "";
}

function onPeepableTimeUpdate (e) {
         document.querySelector('.contentTime .value').innerHTML = e.detail.currentTime;
}

function onPeepableEnded (e) {
    console.debug( "peepableEnded the video player with the ID : ", e.detail.videoID );
    document.querySelector('.contentStatus .value').innerHTML = "Finished";
}