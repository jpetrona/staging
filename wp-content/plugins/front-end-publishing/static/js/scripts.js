var hasChanged = false;
jQuery ( document ).ready ( function ( $ ) {

    var tag = $ ( "#source_json" ).val ();
    if ( typeof tag != 'undefined' ) {
        if ( tag.length > 0 )
            tag = JSON.parse ( tag );
    }
    else {
        tag = [];
    }
    var x_old_source_value = $ ( "#old-fep-source" ).val ();
    var x_prepopulate;
    if ( x_old_source_value != '' ) {
        //console.log ( x_old_source_value );

        tag.forEach ( function ( element, index, value ) {

            if ( element.value == x_old_source_value ) {

                x_prepopulate = [ element ];
            }
        } );
    }
    else {
        x_prepopulate = [];
    }

    //$ ( "#fep-source" ).tokenInput ( tag, { prePopulate: x_prepopulate, tokenLimit: 1, theme: "facebook" } );
    $("#token-input-fep-source").attr("placeholder", "Choose a Source");

    $.fn.wrapInTag = function ( opts ) {

        var tag = opts.tag || 'strong',
            words = opts.words || [],
            regex = RegExp ( words.join ( '|' ), 'gi' ),
            replacement = '<' + tag + '>$&</' + tag + '>';

        return this.html ( function () {
            return $ ( this ).text ().replace ( regex, replacement );
        } );
    };


    function stringbold ( opts, stringx ) {
        var tag = opts.tag || 'strong',
            words = opts.words || [],
            regex = RegExp ( words.join ( '|' ), 'gi' ),
            replacement = '<' + tag + ' style="font-weight:bold;">$&</' + tag + '>';

        return stringx.replace ( regex, replacement );

    }


    var tag = $ ( "#old-fep-tags" ).val ();
    if ( typeof tag != 'undefined' ) {
        if ( tag.length > 0 )
            tag = JSON.parse ( tag );
    }
    else {
        tag = [];
    }
    $ ( "#fep-tags" ).tokenInput ( fepajaxhandler.ajaxurl + "?action=Company_Name_Nasdaq", {
        prePopulate: tag,
        method: 'GET', queryParam: 'word', theme: "facebook", propertyToSearch: "name",
        resultsFormatter: function ( item ) {

            var StockExchange = item.StockExchange;
            if( StockExchange == null )
            {
                StockExchange = '';
            }else if( StockExchange == 'NYQ') {
                StockExchange = 'NYSE';
                StockExchange.toUpperCase();
            }else{
                StockExchange.toUpperCase();
            }
            var  val = $("#token-input-fep-tags" ).val();
            var name_htm = stringbold ( {
                tag: 'span',
                words: [val]
            }, item.name );
            var symbol_htm = stringbold ( {
                tag: 'span',
                words: [val]
            }, item.symbol );


            var formatting = 0;

            if ( item.PercentChange == null ) {
                item.PercentChange = '';
            } else if ( item.PercentChange.indexOf ( "+" ) > - 1 ) {
                formatting = "<span class='fep-tag-PercentChange fep-tag-PercentChange-green'>" + item.PercentChange + "</span>";
            }
            else {
                formatting = "<span class='fep-tag-PercentChange fep-tag-PercentChange-red'>" + item.PercentChange + "</span>";
            }
            if ( item.LastTradePriceOnly == null ) {
                item.LastTradePriceOnly = '';
            }

            var html = '<li class="script-li-format"><table><tr><td class="td-sym">' + $.trim(symbol_htm)  + '</td><td  class="td-name" >' +  $.trim(name_htm) +'</td><td  class="td-val">' + item.LastTradePriceOnly + '</td><td  class="td-val">' + formatting + '</td><td  class="td-val td-5">' + StockExchange + '</td></tr></table></li>';

            return html;
        },
        tokenFormatter: function ( item ) { return "<li class='script-li-token'><p>" + item.symbol + "</p></li>"; },
        onAdd: function (item,symbol_htm) {
            selectedValues = $('#fep-tags').tokenInput("get");
            var hash = {};
            var sum = '';  
            hash['sym'] = item.Symbol+':';
            hash['price'] = item.LastTradePriceOnly;
            for (var name in hash) {
                sum += hash[name];
            }
            var cur_val = $('#fep-tags_graph').val();
            if(cur_val){
                $('#fep-tags_graph').val(cur_val + "," + sum);
            }else{
                $('#fep-tags_graph').val(sum);
            }
        },
        onDelete: function (item) {
            var removeItem = {};
            var removeItemcom = '';  
            removeItem['sym'] = item.Symbol+':';
            removeItem['price'] = item.LastTradePriceOnly;
            for (var name in removeItem) {
                removeItemcom += removeItem[name];
            }
            var cur_val = $('#fep-tags_graph').val();
            var arraynew = cur_val.split(",");
            arraynew.splice( $.inArray(removeItemcom,arraynew) ,1 );
            $('#fep-tags_graph').val(arraynew);
        },
    } );
    //$("#token-input-fep-tags").attr("placeholder", "Symbol or Company name");
} );


function confirmExit () {
    var mce = typeof(tinyMCE) != 'undefined' ? tinyMCE.activeEditor : false;
    if ( hasChanged || (mce && ! mce.isHidden () && mce.isDirty () ) )
        return "You have unsaved changes. Proceed anyway?";
}
window.onbeforeunload = confirmExit;

function substr_count ( mainString, subString ) {
    var re = new RegExp ( subString, 'g' );
    if ( ! mainString.match ( re ) || ! mainString || ! subString )
        return 0;
    var count = mainString.match ( re );
    return count.length;
}

function str_word_count ( s ) {
    if ( ! s.length )
        return 0;
    s = s.replace ( /(^\s*)|(\s*$)/gi, "" );
    s = s.replace ( /[ ]{2,}/gi, " " );
    s = s.replace ( /\n /, "\n" );
    return s.split ( ' ' ).length;
}

function countTags ( s ) {
    if ( ! s.length )
        return 0;
    return s.split ( ',' ).length;
}

function post_has_errors ( title, content, bio, category, tags, fimg, sourceurl ) {

    var error_string = '';

    fep_rules.check_required = 1;
    if ( fep_rules.check_required == 0 )
        return false;
    

    if ( (fep_rules.min_words_title != 0 && title === '') ) {
        error_string += 'Please enter Title</br>';
    }
    if ( fep_rules.min_words_content != 0 && content === '' ) {
        error_string += 'Please enter Content</br>';
    }
    if ( fep_rules.min_words_bio != 0 && bio === '' ) {
        error_string += 'Bio is empty</br>';
    }
    if ( category == - 1 ) {
        error_string += 'Please select Category</br>';
    }
    /* if(fep_rules.min_tags !=0 &&  tags==='')
     {
     error_string+= 'Tags is empty</br>';
     }*/


    /*
     if(fep_rules.check_required == false)
     return false;

     if((fep_rules.min_words_title !=0 && title==='') )
     {
     error_string = "title " ;
     }
     if((fep_rules.min_words_content !=0 && content==='')  )
     {
     error_string = "content " ;
     }
     if((fep_rules.min_words_bio !=0 && bio===''))
     {
     error_string = "bio " ;
     }
     if( category==-1 )
     {
     error_string = "category" ;
     }
     if(  (fep_rules.min_tags !=0 &&  tags==='')  )
     {
     error_string = "tags "+ fep_rules.min_tags  + "tags = "+ tags ;
     }
     */
    var stripped_content = content.replace ( /(<([^>]+)>)/ig, "" );
    var stripped_bio = bio.replace ( /(<([^>]+)>)/ig, "" );

    if ( title != '' && str_word_count ( title ) < fep_rules.min_words_title )
        error_string += 'The title is too short<br/>';
    if ( content != '' && str_word_count ( title ) > fep_rules.max_words_title )
        error_string += 'The title is too long<br/>';
    if ( content != '' && str_word_count ( stripped_content ) < fep_rules.min_words_content )
        error_string += 'The article is too short<br/>';
    if ( str_word_count ( stripped_content ) > fep_rules.max_words_content )
        error_string += 'The article is too long<br/>';
    if ( bio != - 1 && bio != '' && str_word_count ( stripped_bio ) < fep_rules.min_words_bio )
        error_string += 'The bio is too short<br/>';
    if ( bio != - 1 && str_word_count ( stripped_bio ) > fep_rules.max_words_bio )
        error_string += 'The bio is too long<br/>';
    if ( substr_count ( content, '</a>' ) > fep_rules.max_links )
        error_string += 'There are too many links in the article body<br/>';
    if ( substr_count ( bio, '</a>' ) > fep_rules.max_links_bio )
        error_string += 'There are too many links in the bio<br/>';
    /*  if ( tags != '' && countTags(tags) < fep_rules.min_tags )
     error_string += 'You haven\'t added the required number of tags<br/>';
     if ( countTags(tags) > fep_rules.max_tags )
     error_string += 'There are too many tags<br/>';*/
    //if ( fimg == - 1 )
        //error_string += 'You need to choose a featured image<br/>';
    

    /*var myRegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
    if ( ! myRegExp.test ( sourceurl ) )
        error_string += 'You need to enter a valid url <br/>';*/

    if ( error_string == '' )
        return false;
    else
        return '<h2>Your submission has errors. Please try again!</h2>' + '<h6>'+error_string+'</h6>';
}

jQuery ( document ).ready ( function ( $ ) {
    $ ( "input, textarea, #fep-post-content" ).keydown ( function () { hasChanged = true; } );

    $("#fep-post-title").blur(function(){
        tinyMCE.triggerSave ();
        var post_title = $("#fep-post-title").val();
        var post_content = $("#fep-post-content").val();
        var post_category = $("#fep-category").val();
        var post_image = $("#fep-featured-image-id").val();
        if((post_title!="" && post_content!="" && post_category>0) && (post_image>0 || $('#embed_video').is(':checked') ) ){
            $("#fep-submit-post").removeAttr('disabled');
            $("#fep-submit-post").html("Ready to Publish");
            $("#fep-submit-post").addClass('writepost-enabled');
            }else{
            $("#fep-submit-post").removeClass('writepost-enabled');
            $("#fep-submit-post").css('background-color','rgba(43, 0, 247, 0.67)');
        }
    })
    
    $("#fep-topic").focus(function(){
        tinyMCE.triggerSave ();
        var post_title = $("#fep-post-title").val();
        var post_content = $("#fep-post-content").val();
        var post_category = $("#fep-category").val();
        var post_image = $("#fep-featured-image-id").val();
        if((post_title!="" && post_content!="" && post_category>0) && (post_image>0 || $('#embed_video').is(':checked')) ){
            $("#fep-submit-post").removeAttr('disabled');
            $("#fep-submit-post").html("Ready to Publish");
            $("#fep-submit-post").addClass('writepost-enabled');
            }else{
            $("#fep-submit-post").removeClass('writepost-enabled');
            $("#fep-submit-post").attr('disabled','true');
            $("#fep-submit-post").css('background-color','rgba(43, 0, 247, 0.67)');
        }
    })

    // $("#fep-category").change(function(){
    //     tinyMCE.triggerSave ();
    //     var post_title = $("#fep-post-title").val();
    //     var post_content = $("#fep-post-content").val();
    //     var post_category = $("#fep-category").val();
    //     var post_image = $("#fep-featured-image-id").val();
    //     if((post_title!="" && post_content!="" && post_category>0) && (post_image>0 || $('#embed_video').is(':checked') ) ){
    //         $("#fep-submit-post").removeAttr('disabled');
    //         $("#fep-submit-post").html("Ready to Publish");
    //         $("#fep-submit-post").addClass('writepost-enabled');
    //         }else{
    //         $("#fep-submit-post").removeClass('writepost-enabled');
    //         $("#fep-submit-post").attr('disabled','true');
    //         $("#fep-submit-post").css('background-color','rgba(43, 0, 247, 0.67)');
    //     }
    // })

    $ ( "select" ).change ( function () { hasChanged = true; } );
    $ ( "td.post-delete a" ).click ( function ( event ) {
        var id = $ ( this ).siblings ( '.post-id' ).first ().val ();
        var nonce = $ ( '#fepnonce_delete' ).val ();
        var loadimg = $ ( this ).siblings ( '.fep-loading-img' ).first ();
        var row = $ ( this ).closest ( '.fep-row' );
        var message_box = $ ( '#fep-message' );
        var post_count = $ ( '#fep-posts .count' );
        var confirmation = confirm ( 'Are you sure?' );
        if ( ! confirmation )
            return;
        $ ( this ).hide ();
        loadimg.show ().css ( { 'float': 'none', 'box-shadow': 'none' } );
        $.ajax ( {
            type: 'POST',
            url: fepajaxhandler.ajaxurl,
            data: {
                action: 'fep_delete_posts',
                post_id: id,
                delete_nonce: nonce
            },
            success: function ( data, textStatus, XMLHttpRequest ) {
                var arr = $.parseJSON ( data );
                message_box.html ( '' );
                if ( arr.success ) {
                    row.hide ();
                    message_box.show ().addClass ( 'success' ).append ( arr.message );
                    post_count.html ( Number ( post_count.html () ) - 1 );
                }
                else {
                    message_box.show ().addClass ( 'warning' ).append ( arr.message );
                }
                if ( message_box.offset ().top < $ ( window ).scrollTop () ) {
                    $ ( 'html, body' ).animate ( { scrollTop: message_box.offset ().top - 10 }, 'slow' );
                }
            },
            error: function ( MLHttpRequest, textStatus, errorThrown ) {
                alert ( errorThrown );
            }
        } );
        event.preventDefault ();
    } );
    $ ( "#fep-submit-post.active-btn" ).on ( 'click', function () {
        tinyMCE.triggerSave ();
        //$("#fep-submission-form").validate();
        var form = $('#fep-submission-form');
        var isValid = form.valid();
        if(!isValid){ 
            return false;
        }
        var x_source_json = JSON.parse ( $ ( "#source_json" ).val () );
        var tag_value = '';
        $ ( '#fep-tag-container ul li p' ).each ( function ( i ) {if ( tag_value.length == 0 ) {tag_value = $ ( this ).text ();} else {tag_value += "," + $ ( this ).text ();}} );
        var title = $ ( "#fep-post-title" ).val ();
        var content = $ ( "#fep-post-content" ).val ();
        var bio = $ ( "#fep-about" ).val ();
        var category = $ ( "#fep-category" ).val ();
        var tags = tag_value;
        var topic = $ ( "#fep-topic" ).val ();
        var topic_field_key = $ ( "#topic_field_key" ).val ();

        var author_ide = $ ( "#author_ide" ).val ();
        var user_id = $ ( "#user_id" ).val ();
        var pid = $ ( "#fep-post-id" ).val ();
        var video_source = $ ( "#video_source" ).val ();
        var uploadImage = ''
        if (video_source =='') {
            uploadImage = uploadImageonMedia(function(res) {
               finalSubmitData();
            });
        }else{
            finalSubmitData();
        }
    } );
    $ ( 'body' ).on ( 'click', '#fep-continue-editing', function ( e ) {
        $ ( '#fep-message' ).hide ();
        $ ( '#fep-submission-form' ).show ();
        e.preventDefault ();
    } );

    $ ( '#fep-featured-image-link' ).click ( function ( e ) {
        jQuery("#fepupload").click();
    } );

} );
    function finalSubmitData(){
            var x_source_json = JSON.parse ( $ ( "#source_json" ).val () );
            var tag_value = '';
            $ ( '#fep-tag-container ul li p' ).each ( function ( i ) {if ( tag_value.length == 0 ) {tag_value = $ ( this ).text ();} else {tag_value += "," + $ ( this ).text ();}} );
            var title = $ ( "#fep-post-title" ).val ();
            var content = $ ( "#fep-post-content" ).val ();
            var bio = $ ( "#fep-about" ).val ();
            var category = $ ( "#fep-category" ).val ();
            var tags = tag_value;
            var topic = $ ( "#fep-topic" ).val ();
            var topic_field_key = $ ( "#topic_field_key" ).val ();

            var author_ide = $ ( "#author_ide" ).val ();
            var user_id = $ ( "#user_id" ).val ();
            var pid = $ ( "#fep-post-id" ).val ();
            var video_source = $ ( "#video_source" ).val ();
            var load_img = $ ( "img.fep-loading-img" );
           setTimeout(function() {
                var fimg = $ ( "#fep-featured-image-id" ).val ();
                var nonce = $ ( "#fepnonce" ).val ();
                var message_box = $ ( '#fep-message' );
                var form_container = $ ( '#fep-new-post-submit' );
                var submit_btn = $ ( '#fep-submit-post' );
                var submission_form = $ ( '#fep-submission-form' );
                var post_id_input = $ ( "#fep-post-id" );
                //var errors = post_has_errors ( title, content, bio, category, tags, fimg, source_link );
                //if($("#fep-source").val()!=""){
                    //var source = x_source_json[$("#fep-source").val()].value;
                //}
                var source = $("#fep-source").val();
                var source_field_key = $ ( "#source_field_key" ).val ();
                var source_link = $ ( "#fep-source-link" ).val ();
                var source_link_key = $ ( "#source_link_key" ).val ();
                var fep_tags_graph = $ ( "#fep-tags_graph" ).val ();
                
                /*if ( errors ) {
                    console.log(errors);
                    if ( form_container.offset ().top < $ ( window ).scrollTop () ) {
                        $ ( 'html, body' ).animate ( { scrollTop: form_container.offset ().top - 10 }, 'slow' );
                    }
                    message_box.removeClass ( 'success' ).addClass ( 'warning' ).html ( '' ).show ().append ( errors );
                    return;
                }*/
                load_img.show ();
                submit_btn.attr ( "disabled", true ).removeClass ( 'active-btn' ).addClass ( 'passive-btn' );
                $.ajaxSetup ( { cache: false } );
                $.ajax ( {
                    type: 'POST',
                    url: fepajaxhandler.ajaxurl,
                    data: {
                        action: 'fep_process_form_input',
                        post_title: title,
                        post_topic: topic,
                        post_topic_key: topic_field_key,
                        post_source_key: source_field_key,
                        post_source: source,
                        post_source_link: source_link,
                        post_source_link_key: source_link_key,
                        post_content: content,
                        about_the_author: bio,
                        post_author_ide: author_ide,
                        post_category: category,
                        post_tags: tags,
                        post_id: pid,
                        user_id: user_id,
                        featured_img: fimg,
                        user_id: user_id,
                        post_nonce: nonce,
                        fep_tags_graph: fep_tags_graph,
                        video_source: video_source
                    },
                    success: function ( data, textStatus, XMLHttpRequest ) {
                        hasChanged = false;
                        var arr = $.parseJSON ( data );
                        if ( arr.success ) {
                            submission_form.hide ();
                            post_id_input.val ( arr.post_id );
                            message_box.removeClass ( 'warning' ).addClass ( 'success' );
                           window.location.href="//"+window.location.hostname+"/myprofile";
                        }
                        else
                            message_box.removeClass ( 'success' ).addClass ( 'warning' );
                        message_box.html ( '' ).append ( arr.message ).show ();
                        if ( form_container.offset ().top < $ ( window ).scrollTop () ) {
                            $ ( 'html, body' ).animate ( { scrollTop: form_container.offset ().top - 10 }, 'slow' );
                        }
                        load_img.hide ();
                        submit_btn.attr ( "disabled", false ).removeClass ( 'passive-btn' ).addClass ( 'active-btn' );
                    },
                    error: function ( MLHttpRequest, textStatus, errorThrown ) {
                        alert ( errorThrown );
                    }
                } );
            }, 3000);
        load_img.show();    
    }
    function uploadImageonMedia(callback) {
        var file = document.getElementById('fepupload');
        //var siteurl = '//www.retire.ly/wp-upload-featured.php';
        var siteurl = 'http://192.168.1.75/retirelynews/wp-upload-featured.php';
        /* Create a FormData instance */
        var formData = new FormData();
        // script for delete icon section
       
        formData.append("featured", file.files[0]);
        $.ajax({
           url: siteurl,
           type: "POST",
           data: formData,
           processData: false,
           contentType: false,
           success: function(response) {
            response = JSON.parse(response);
             $( '#fep-featured-image-id' ).val ( response.attach_id );
             $( '#uploader1' ).val ( response.uploadfile );
             callback(true);
           },
           error: function(jqXHR, textStatus, errorMessage) {
               console.log(errorMessage); // Optional
             callback(false);
           }
        });
           
        /* Send to server */
        //jQuery("#loader").show();

    }

    function PreviewfeaturedImage(input) {
        if (input.files && input.files[0]) {
            var checkis_fill = input.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                //$('#uploaded-preview').attr('src', e.target.result);
                $( '#showfeaturedimage' ).css("background-image","url("+e.target.result+")");
                $( '#showfeaturedimage' ).css("background-position","center");
                $( '#showfeaturedimage' ).css("background-size", "cover");
                $('#chechfilestrue' ).attr("value", 'true');
                $('#video_source').val("");
                //$('#embed_video').attr('checked', '');
                $('#embed_video').prop('checked', false);
                $('#coverimageremove').css('display','none');
                var post_title = $("#fep-post-title").val();
                    var post_content = $("#fep-post-content").val();
                    var post_category = $("#fep-category").val();
                    var source = $("#fep-source").val();
                    var source_link = $ ( "#fep-source-link" ).val ();
                    if((post_title!="" && source!="" && source_link!="" && post_content!="" && post_category>0)){
                        $("#fep-submit-post").removeAttr('disabled');
                        $("#fep-submit-post").html("Ready to Publish");
                        $("#fep-submit-post").addClass('writepost-enabled');
                        }else{
                        $("#fep-submit-post").removeClass('writepost-enabled');
                        $("#fep-submit-post").attr('disabled','true');
                        $("#fep-submit-post").css('background-color','rgba(43, 0, 247, 0.67)');
                    }
            }

            reader.readAsDataURL(input.files[0]);
             $('#filebgcolor' ).css("background-color","");
             $('.deletefeaurued-icon').show();
             $('#nextcont').show();
             $('#skipcont').hide();
             //$('embed_video').attr('checked', '');
             $(".video-filled").hide()
             $('#embed_video').attr("disabled", "disabled");
             $('#headingFive').find('span').removeClass('go-green');             
             $('.demo-checkbox-btn').attr("title", "Embeded video is disable, you have already choosen cover image.");
             
        }
        //input.value = null;
       
        /* Add the file */
    }

    $(document).ready(function(){

        $('.deletefeauruedimg').on('click', function(){

             $('#chechfilestrue' ).attr("value", 'false');
             $('.deletefeaurued-icon').hide();
             $('#nextcont').hide();
             $('#skipcont').show();
             $('#embed_video').removeAttr("disabled");
             $('.demo-checkbox-btn').removeAttr("title");
             $( '#showfeaturedimage' ).removeAttr("style");
             $( '#showfeaturedimage' ).css("background-color", " #F3F6F8");
             $( '#filebgcolor' ).css("background-color"," #F3F6F8");
             
             //$("#fep-featured-image-id").val("");
             $("#fep-submit-post").removeClass('writepost-enabled');
             $("#fep-submit-post").attr('disabled','true');
             $("#fep-submit-post").css('background-color','rgba(43, 0, 247, 0.67)');
             $('#fepupload').val("");

    });

          $('#showfeaturedimage, #coverimageremove, #uploader1, #filebgcolor, .featurimg-upld').on('mouseover', function(){
            var checkis_file = $( '#chechfilestrue' ).val();
            if (checkis_file !='true') {
                $('#coverimageremove').css('display', 'block');
            }else{
                $('.deletefeaurued-icon').show();
            }
          });
          $('#filebgcolor').on('mouseout', function(){
            $('#coverimageremove').css('display', 'none');
            $('.deletefeaurued-icon').hide();
          });
    });




