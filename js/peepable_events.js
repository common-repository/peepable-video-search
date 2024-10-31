/* 
 * Javascript functions for Peepable events
 */

function peepableOnplay (e) {
    console.debug( "peepableOnplay the video player with the ID : ", e.detail.videoID );
    if (typeof onPeepablePlay == 'function')
    {
        onPeepablePlay(e); // this function can be included by the customer if they want to use it 
    }
}
function peepableEnded (e) {
    if (typeof onPeepableEnded == 'function')
    {
        onPeepableEnded(e); // this function can be included by the customer if they want to use it 
    }
}
function peepablePause (e) {
    if (typeof onPeepablePause == 'function')
    {
        onPeepablePause(e); // this function can be included by the customer if they want to use it 
    }
}

function peepableDisposed (e) {
    
    if (typeof onPeepableDisposed == 'function')
    {
        onPeepableDisposed(e); // this function can be included by the customer if they want to use it 
    }

}
function peepableTimeUpdate (e) {
    
      if (typeof onPeepableTimeUpdate == 'function')
    {
        onPeepableTimeUpdate(e); // this function can be included by the customer if they want to use it 
    }

}


PeepableToolkit.on('peepableOnPlay', peepableOnplay);
PeepableToolkit.on('peepableTimeUpdate', peepableTimeUpdate);
PeepableToolkit.on('peepableEnded', peepableEnded);
PeepableToolkit.on('peepablePause', peepablePause);
PeepableToolkit.on('peepableDispose', peepableDisposed);	

