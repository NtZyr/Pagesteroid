$( '.add-row' ).live( 'click', function( e ) {
    e.preventDefault();

    var widget = $(this).attr('data-widget');
    var context = $(this).closest('.pagesteroid-wrap').find('.pagesteroid-wrap-content').first();
    var wrapper_num = $(this).closest('.pagesteroid-wrap').first().index();
    var item_num = $(this).closest('.pagesteroid-wrap').find('.pagesteroid-wrap-content').first().find('.pagesteroid-item').length;

    $.ajax({ 
        context: context,
        url: ajax_url,
        type: "POST",
        data: {
            action: 'get_widget',
            widget: widget,
            wrapper: wrapper_num,
            num: item_num
        },
        success: function(data) {
            if(context.find('.pagesteroid-rows-message').length > 0) {
                context.find('.pagesteroid-rows-message').hide();
            }

            context.append(data);
            tinymce.init(tinyMCEPreInit.mceInit['#' + wrapper_num + '_content_' + item_num]);
        }
    });
} );

$( '.add-wrap' ).live( 'click', function( e ) {
    e.preventDefault();

    var wrapper = $(this).attr('data-wrapper');
    var context = $(this).closest('#pagesteroid');
    var wrap_num = $('.pagesteroid-wrap').length;

    $.ajax({
        context: context,
        url: ajax_url,
        type: "POST",
        data: {
            action: 'get_wrapper',
            wrapper: wrapper,
            num: wrap_num
        },
        success: function(data) {

            context.find('.pagesteroid-rows').append(data);
        }
    });
});

$('.wrapper-add').live('hover', function(){
    $(this).parent().find('.wrapper-add-menu').show();
});

$('.wrapper-remove').live('click', function() {
    if( confirm( "Remove wrapper and contains?" ) ) {
        $(this).closest('.pagesteroid-wrap').remove();
    }
});

$('.pagesteroid-remove').live('click', function() {
    if( confirm( "Remove widget and contains?" ) ) {
        $(this).closest('.pagesteroid-row').first().remove();
    }
});

$('.pagesteroid-toggle').live('click',function(){
    $(this).closest('.pagesteroid-row').find('.pagesteroid-row-fields').first().toggle();
});

$('.pagesteroid-row-fields').hide();

$('.wrapper-add-menu').live( 'mouseleave', function(){ $(this).hide() });

$( '.pagesteroid-wrap .pagesteroid-wrap-content' ).sortable({
    handle: '.pagesteroid-handle',
    cursor: 'grabbing',
    stop: function( e, ui) {
        pagesteroid_UpdateWrapOrder();
    }
});

$( '.pagesteroid-rows' ).sortable({
    handle: '.wrapper-handle',
    cursor: 'grabbing',
    stop: function( e, ui) {
        pagesteroid_UpdateWrapOrder();
    }
});

$('.slide-add').live( 'click', function() {
    var context = $(this).closest('.slides_box').first().find('.slides').first();
    var wrapper_num = $(this).closest('.pagesteroid-wrap').first().index();
    var item_num = $(this).closest('.pagesteroid-item').first().index();
    var slide_num = context.find('.slide').length;
    $.ajax({
        context: context,
        url: ajax_url,
        type: "POST",
        data: {
            action: 'get_slide',
            wrapper: wrapper_num,
            item: item_num,
            num: slide_num
        },
        success: function(data) {

            context.append(data);
        }
    });
} );

$('.slide-remove').live('click', function(){
    $(this).parent().remove();
}); 

function pagesteroid_UpdateWrapOrder() {
    $('.pagesteroid-wrap').each( function( i ) {
        $( this ).find( '.wrapper-input' ).each( function( j ) {
            var field = $(this).attr( 'data-field' );
            $(this).attr( 'name', 'pagesteroid[' + i + '][' + field + ']' );
        } );

        $( this ).find( '.pagesteroid-item' ).each( function( j ) {
            $(this).find('.item-input').each( function() {
                var field = $(this).find('.item-input').attr( 'data-field' );
                $(this).attr( 'name', 'pagesteroid[' + i + '][items][' + j + '][' + field + ']' );
            });
        });
    } );
}

// function pagesteroid_UpdateItemOrder() {
//     $('.pagesteroid-item').each( function( i ) {
//         $( this ).find( '.item-input' ).each( function( j ) {
//             var field = $(this).attr( 'data-field' );
//             $(this).attr( 'name', 'pagesteroid[' + i + '][items][' + j + '][' + field + ']' );
//         });
//     });
// }