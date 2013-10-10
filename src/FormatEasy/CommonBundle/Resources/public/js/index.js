/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var opts_mmenu = [];
$(document).ready(function(){
    /********* Checkbox - Radio *********/
//    $('form').on('change', ':checkbox, :radio', function(){
//        var label = $(this).parent('label');
////        if(label.has('.one-check'))
////            label.parent().children().not(label).removeClass('active');
//        label.toggleClass('active');
//    });
    /********* Checkbox - Radio *********/
    
    /********* Input [Labels vs Placeholder] *********/
    if(Modernizr.input.placeholder){
        $('form input').not(':checkbox').not(':radio').each(function(){
            var label = $(this).parent('label');
            if(label.length < 1){
                label = $(this).siblings('label');
            }
            label.hide();
            $(this).prop('placeholder', label.text());
        });
    }else{

        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.prop('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
          }).blur(function() {
            var input = $(this);
            if (input.val() == '' || input.val() == input.prop('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();
        $('[placeholder]').parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.prop('placeholder')) {
                   input.val('');
                }
            });
        });
    }
    /********* Input [Labels vs Placeholder] *********/
    
    /********* Link Mmenu *********/
    $('a.link-mmenu').on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        var este = $(this);
        $.ajax({
          url: este.prop('href')  
        }).done(function(data) {
            
            var menu_open = '#mmenu-'+este.attr('data-menu-position');
            if(menu_open.length < 1){
                menu_open = '#mmenu-right';
            }
            var opts = opts_mmenu[menu_open];
            opts.modal = este.attr('data-modal') === 'true' || este.attr('data-modal') === 'false'?eval(este.attr('data-modal')):true;
            opts.zposition = este.attr('data-zposition')?este.attr('data-zposition'):'back';
            if(este.attr('data-configuration')){
                opts.configuration = {};
                /* true, false */
                opts.configuration.preventTabbing = este.attr('data-preventTabbing') === 'true' || este.attr('data-preventTabbing') === 'false'?eval(este.attr('data-preventTabbing')):true;
                /* true, false */
                opts.configuration.hardwareAcceleration = este.attr('data-hardwareAcceleration') === 'true' || este.attr('data-hardwareAcceleration') === 'false'?eval(este.attr('data-hardwareAcceleration')):true;
            }
            $(menu_open).find('.mm-inner .mmenu-content').html(data);
            $(menu_open).mmenu(opts).trigger('open.mm').on("closed.mm", function(){
                $(this).find('.mm-inner .mmenu-content').html('');
            });
        }).fail(function( jqXHR, textStatus ) {
            console.log("Request failed: "+textStatus);
        }).always(function() {
            
        });
    });
    /********* Link Mmenu *********/
    
    /********* Link Modal *********/
    $('a.link-modal').on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        var este = $(this);
        $.ajax({
          url: este.prop('href')  
        }).done(function(data) {
            
            var menu_open = '#mmenu-'+este.attr('data-menu-position');
            if(menu_open.length < 1){
                menu_open = '#mmenu-right';
            }
            
        }).fail(function( jqXHR, textStatus ) {
            console.log("Request failed: "+textStatus);
        }).always(function() {
            
        });
    });
    /********* Link Modal *********/
    
    /********* Mmenu *********/
    $('.mmenu').each(function(){
        var este = $(this), opts = {};
        /* left, right, top, bottom */
        opts.position = este.attr('data-position')?este.attr('data-position'):'left';
        /* back, front, next */
        opts.zposition = este.attr('data-zposition')?este.attr('data-zposition'):'back';
        /* true, false */
        opts.slidingSubmenus = este.attr('data-slidingSubmenu') === 'true' || este.attr('data-slidingSubmenus') === 'false'?eval(este.attr('data-slidingSubmenus')):false;
        /* true, false */
        opts.modal = este.attr('data-modal') === 'true' || este.attr('data-modal') === 'false'?eval(este.attr('data-modal')):true;
        /* true, false */
        opts.isMenu = este.attr('data-ismenu') === 'true' || este.attr('data-ismenu') === 'false'?eval(este.attr('data-ismenu')):true;
        /* true, false */
        opts.moveBackground = este.attr('data-moveBackground') === 'true' || este.attr('data-moveBackground') === 'false'?eval(este.attr('data-moveBackground')):false;
        if(este.attr('data-counters')){
            opts.counters = {};
            /* true, false */
            opts.counters.add = este.attr('data-counters-add')?este.attr('data-counters-add'):false;
            /* true, false */
            opts.counters.count = este.attr('data-counters-count')?este.attr('data-counters-count'):true;
        }
        if(este.attr('data-searchField')){
            opts.searchfield= {};
            /* true, false */
            opts.searchfield.add = este.attr('data-searchfield-add')?true:false;
            /* true, false */
            opts.searchfield.search = este.attr('data-searchfield-search')?true:false;
            /* text */
            opts.searchfield.placeholder = este.attr('data-searchfield-placeholder')?este.attr('data-searchfield-placeholder'):'Search';
            /* text */
            opts.searchfield.noResults = este.attr('data-searchfield-noResults')?este.attr('data-searchfield-noResults'):'No results found.';
            /* true, false */
            opts.searchfield.showLinksOnly = este.attr('data-searchfield-showLinksOnly')?true:false;
        }
        if(este.attr('data-dragOpen')){
            opts.dragOpen = {};
            /* true, false */
            opts.dragOpen.open = este.attr('data-dragOpen-open')?true:false;
            /* true, false */
            opts.dragOpen.threshold = este.attr('data-dragOpen-threshold')?este.attr('data-dragOpen-threshold'):100;
            /* text */
            opts.dragOpen.pageNode = este.attr('data-dragOpen-pageNode')?este.attr('data-dragOpen-pageNode'):'#page';
        }else{
            opts.dragOpen = false;
        }
        if(este.attr('data-onClick')){
            opts.onClick = {};
            var func;
            if(este.attr('data-onClick-close')){
                func = este.attr('data-onClick-close');
                if(typeof func !== 'boolean'){
                    func = window[este.attr('data-onClick-close')];
                    if(typeof func !== 'function')
                        func = true;
                }
                /* true, false, function */
                opts.onClick.close = func;
            }
            if(este.attr('data-onClick-setSelected')){
                func = este.attr('data-onClick-setSelected');
                if(typeof func !== 'boolean'){
                    func = window[este.attr('data-onClick-setSelected')];
                    if(typeof func !== 'function')
                        func = true;
                }
                /* true, false, function */
                opts.onClick.setSelected = func;
            }
            if(este.attr('data-onClick-setLocationHref')){
                func = este.attr('data-onClick-setLocationHref');
                if(typeof func !== 'boolean'){
                    func = window[este.attr('data-onClick-setLocationHref')];
                    if(typeof func !== 'function')
                        func = false;
                }
                /* true, false, function */
                opts.onClick.setLocationHref = func;
            }
            if(este.attr('data-onClick-delayLocationHref')){
                func = este.attr('data-onClick-delayLocationHref');
                if(typeof func !== 'boolean'){
                    func = window[este.attr('data-onClick-delayLocationHref')];
                    if(typeof func !== 'function')
                        func = true;
                }
                /* true, false, function */
                opts.onClick.delayLocationHref = func;
            }
            if(este.attr('data-onClick-blockUI')){
                func = este.attr('data-onClick-blockUI');
                if(typeof func !== 'boolean'){
                    func = window[este.attr('data-onClick-blockUI')];
                    if(typeof func !== 'function')
                        func = false;
                }
                /* true, false, function */
                opts.onClick.blockUI = func;
            }
            if(este.attr('data-onClick-callback')){
                func = window[este.attr('data-onClick-callback')];
                if(typeof func === 'function')
                    /* function */
                    opts.onClick.callback = func;
            }
        }
//   configuration: {
//      clone                : false,
//      hardwareAcceleration : true,
//      preventTabbing       : true,
//      selectedClass        : "Selected",
//      labelClass           : "Label",
//      counterClass         : "Counter",
//      pageSelector         : undefined,
//      pageNodetype         : "div",
//      transitionDuration   : 500
//   }
        if(este.attr('data-configuration')){
            opts.configuration = {}
            /* true, false */
            opts.configuration.preventTabbing = este.attr('data-preventTabbing') === 'true' || este.attr('data-preventTabbing') === 'false'?eval(este.attr('data-preventTabbing')):true;
            /* true, false */
            opts.configuration.hardwareAcceleration = este.attr('data-hardwareAcceleration') === 'true' || este.attr('data-hardwareAcceleration') === 'false'?eval(este.attr('data-hardwareAcceleration')):true;
        }
        este.mmenu(opts);
        if(este.attr('data-opening')){
            func = window[este.attr('data-opening')];
            if(typeof func === 'function'){
                $(this).on("opening.mm", function(){
                    func(este);
                });
            }
        }
        if(este.attr('data-opened')){
            func = window[este.attr('data-opened')];
            if(typeof func === 'function'){
                este.on("opened.mm", function(){
                    func(este);
                });
            }
        }
        opts_mmenu['#'+este.attr('id')] = opts;
    });
    $('.mmenu.mm-menu .mm-inner .mmenu-header span.cerrar').on('click',function(){
        $(this).parents('.mmenu.mm-menu').trigger('close.mm');
    });
    $('#mm-blocker').on('click', function(){
        $('.mmenu').trigger('close.mm');
    });
    /********* Mmenu *********/
    
    /********* Modal *********/
    
    /********* Modal *********/
});
/********* Functions *********/
/********* Functions *********/