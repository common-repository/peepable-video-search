/* 
 * Used to get chapters for a specified video using the Peepable API 
 */

function onPeepablePlay (e){
    console.debug('Peepable Play');
    ajaxRequestChaptersForm (e.detail.videoID);    
    peepable_displayChapterInfo (e);
}

function onPeepableTimeUpdate (e) {
    console.debug('Peepable Time Update');
    ajaxRequestChaptersForm (e.detail.videoID );    
    peepable_displayChapterInfo(e);
}

ajaxRequestChaptersForm.chapters = null;
ajaxRequestChaptersForm.video_id = null;


//jQuery(document).ready(function(event) {
//    jQuery('#apiKeysForm').submit(ajaxRequestChaptersForm);

function ajaxRequestChaptersForm( videoid ){

        // only call this if the videoid has changed

    if (ajaxRequestChaptersForm.video_id != videoid){
        // 
       // a new video is playing
           // Get the chapter information for this video
            ajaxRequestChaptersForm.video_id = videoid;

            //var frmdata = 'video_id=' + videoid + '&action=getChapters';

            var siteurl = document.location.origin;

            //console.debug(siteurl);


            if (siteurl == 'https://localhost'){
                siteurl = 'https://localhost/widget.peepable.com';
            }

              if (siteurl == 'http://localhost'){
                siteurl = 'http://localhost/widget.peepable.com';
            }

            var ajaxurl = siteurl + '/wp-admin/admin-ajax.php';
  
            //console.debug('getting chapters');
            var peepable_getchaptersform = 'video_id=' + videoid + '&redirect=&action=peepable_getChapters';
            jQuery.ajax({
                type:"POST",
                url: siteurl + "/wp-admin/admin-ajax.php",
                data: peepable_getchaptersform,
                complete:function(data){ // changed to complete from usual "success" as wodpress returned 404 on success
                    peepable_chaptersReturnedAsync(data)
                              }
            });
            

    } //if
    return false;
}


function peepable_chaptersReturnedAsync(data){

    var chapterjson = data.responseText;
    if (chapterjson.indexOf ("[") != -1) {
        chapterjson = chapterjson.substring (chapterjson.indexOf ("[")); // WP prepends some non data in reponse sometimes
    }
    
    var datafromgetchapters = JSON.parse(chapterjson);
    //console.log(datafromgetchapters);
    ajaxRequestChaptersForm.chapters = datafromgetchapters;
}
 
function peepable_displayChapterInfo (e){

    try{
        if (ajaxRequestChaptersForm.chapters != null){
            var tc = e.detail.currentTime;
            var c = ajaxRequestChaptersForm.chapters.length -1;

            while (c >=0 ){
                if (tc > ajaxRequestChaptersForm.chapters[c].in_cue) { 
                    break; 
                }
                c-=1;
            }

            var chapterInfo = ajaxRequestChaptersForm.chapters[c].content;

            jQuery("#peepable_chapter_info").css("display","block");
            jQuery("#peepable_chapter_info").html(chapterInfo);
        }    // if
    }   catch (err){ // null content when there's an error
    }
}
   
