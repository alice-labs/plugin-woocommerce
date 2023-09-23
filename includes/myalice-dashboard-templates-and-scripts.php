<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

// Admin Internal Script & Template
add_action( 'admin_footer', function () { ?>
    <div id="alice-feedback-modal" style="display: none;">
        <div class="alice-modal-bg"></div>
        <div class="alice-modal-body">
            <div class="alice-modal-header">
                <h3><?php esc_html_e( "We're sorry to see you go. If you have a moment, please let us know why you’re deactivating the plugin.", 'myaliceai' ); ?></h3>
                <div class="alice-modal-close">
                    <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.5,1.5l-13,13m0-13,13,13" transform="translate(0 0)"></path>
                    </svg>
                </div>
            </div>
            <div class="alice-modal-content">
                <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
					<?php wp_nonce_field( 'alice_deactivation_feedback', 'alice_deactivation_feedback' ); ?>
                    <input type="hidden" name="action" value="alice_deactivation_feedback">
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback"
                                   value="<?php esc_html_e( "I'm unable to get the plugin to work", 'myaliceai' ); ?>"> <?php esc_html_e( "I'm unable to get the plugin to work", 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback"
                                   value="<?php esc_html_e( 'I no longer need the plugin', 'myaliceai' ); ?>"> <?php esc_html_e( 'I no longer need the plugin', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback"
                                   value="<?php esc_html_e( 'I found a better solution', 'myaliceai' ); ?>"> <?php esc_html_e( 'I found a better solution', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback"
                                   value="<?php esc_html_e( 'The plugin is impacting website performance', 'myaliceai' ); ?>"> <?php esc_html_e( 'The plugin is impacting website performance', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback"
                                   value="<?php esc_html_e( "This is a temporary deactivation. I'll be back!", 'myaliceai' ); ?>"> <?php esc_html_e( "This is a temporary deactivation. I'll be back!", 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value="<?php esc_html_e( 'Other', 'myaliceai' ); ?>"> <?php esc_html_e( 'Other', 'myaliceai' ); ?> <input
                                    type="text" name="feedback_other">
                        </label>
                    </div>
                    <div class="submission-button-field">
                        <button type="submit">
                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.540335 0.384995L11.7433 6.72599C11.7912 6.75489 11.8307 6.79517 11.8582 6.84303C11.8856 6.89089 11.9 6.94474 11.9 6.99949C11.9 7.05425 11.8856 7.1081 11.8582 7.15595C11.8307 7.20381 11.7912 7.24409 11.7433 7.27299L0.540335 13.615C0.49504 13.6419 0.442987 13.6561 0.389904 13.6561C0.336822 13.6561 0.284769 13.6419 0.239474 13.615C0.192756 13.5856 0.154586 13.5451 0.12861 13.4973C0.102635 13.4495 0.0897211 13.396 0.0911039 13.342V0.657995C0.0905368 0.604554 0.103944 0.551846 0.130072 0.504802C0.156201 0.457757 0.194196 0.417913 0.240504 0.388995C0.285303 0.361721 0.336964 0.346923 0.389842 0.346218C0.44272 0.345512 0.494781 0.358927 0.540335 0.384995ZM1.30382 7.62499V11.758L9.70939 6.99999L1.30485 2.24299V6.37499H4.33922V7.62499H1.30382Z"
                                      fill="#ffffff"/>
                            </svg>
							<?php esc_html_e( 'Submit & Deactivate', 'myaliceai' ); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function($){
            var defaults = {
                columns: 1,     // how many columns should be use to show options
                search : false, // include option search box

                // search filter options
                searchOptions : {
                    delay        : 250,                  // time (in ms) between keystrokes until search happens
                    showOptGroups: false,                // show option group titles if no options remaining
                    searchText   : true,                 // search within the text
                    searchValue  : false,                // search within the value
                    onSearch     : function( element ){} // fires on keyup before search on options happens
                },

                // plugin texts
                texts: {
                    placeholder    : 'Select options', // text to use in dummy input
                    search         : 'Search',         // search input placeholder text
                    searchNoResult : 'No results',     // search results not found text
                    selectedOptions: ' selected',      // selected suffix text
                    selectAll      : 'Select all',     // select all text
                    unselectAll    : 'Unselect all',   // unselect all text
                    noneSelected   : 'None Selected'   // None selected text
                },

                // general options
                selectAll              : false, // add select all option
                selectGroup            : false, // select entire optgroup
                minHeight              : 200,   // minimum height of option overlay
                maxHeight              : null,  // maximum height of option overlay
                maxWidth               : null,  // maximum width of option overlay (or selector)
                maxPlaceholderWidth    : null,  // maximum width of placeholder button
                maxPlaceholderOpts     : 10,    // maximum number of placeholder options to show until "# selected" shown instead
                showCheckbox           : true,  // display the checkbox to the user
                checkboxAutoFit        : false,  // auto calc checkbox padding
                optionAttributes       : [],    // attributes to copy to the checkbox from the option element
                replacePlaceholderText : true, // replace text of placeholder if button is too small

                // Callbacks
                onLoad        : function( element ){},           // fires at end of list initialization
                onOptionClick : function( element, option ){},   // fires when an option is clicked
                onControlOpen : function( element ){},           // fires when the options list is opened
                onControlClose: function( element ){},           // fires when the options list is closed
                onSelectAll   : function( element, selected ){}, // fires when (un)select all is clicked
                onPlaceholder : function( element, placeholder, selectedOpts ){}, // fires when the placeholder txt is updated
            };

            var msCounter    = 1; // counter for each select list
            var msOptCounter = 1; // counter for each option on page

            // FOR LEGACY BROWSERS (talking to you IE8)
            if( typeof Array.prototype.map !== 'function' ) {
                Array.prototype.map = function( callback, thisArg ) {
                    if( typeof thisArg === 'undefined' ) {
                        thisArg = this;
                    }

                    return $.isArray( thisArg ) ? $.map( thisArg, callback ) : [];
                };
            }
            if( typeof String.prototype.trim !== 'function' ) {
                String.prototype.trim = function() {
                    return this.replace(/^\s+|\s+$/g, '');
                };
            }

            function MultiSelect( element, options )
            {
                this.element           = element;
                this.options           = $.extend( true, {}, defaults, options );
                this.updateSelectAll   = true;
                this.updatePlaceholder = true;
                this.listNumber        = msCounter;

                msCounter = msCounter + 1; // increment counter

                /* Make sure its a multiselect list */
                if( !$(this.element).attr('multiple') ) {
                    throw new Error( '[jQuery-MultiSelect] Select list must be a multiselect list in order to use this plugin' );
                }

                /* Options validation checks */
                if( this.options.search ){
                    if( !this.options.searchOptions.searchText && !this.options.searchOptions.searchValue ){
                        throw new Error( '[jQuery-MultiSelect] Either searchText or searchValue should be true.' );
                    }
                }

                /** BACKWARDS COMPATIBILITY **/
                if( 'placeholder' in this.options ) {
                    this.options.texts.placeholder = this.options.placeholder;
                    delete this.options.placeholder;
                }
                if( 'default' in this.options.searchOptions ) {
                    this.options.texts.search = this.options.searchOptions['default'];
                    delete this.options.searchOptions['default'];
                }
                /** END BACKWARDS COMPATIBILITY **/

                // load this instance
                this.load();
            }

            MultiSelect.prototype = {
                /* LOAD CUSTOM MULTISELECT DOM/ACTIONS */
                load: function() {
                    var instance = this;

                    // make sure this is a select list and not loaded
                    if( (instance.element.nodeName != 'SELECT') || $(instance.element).hasClass('jqmsLoaded') ) {
                        return true;
                    }

                    // sanity check so we don't double load on a select element
                    $(instance.element).addClass('jqmsLoaded ms-list-'+ instance.listNumber ).data( 'plugin_multiselect-instance', instance );

                    // add option container
                    $(instance.element).after('<div id="ms-list-'+ instance.listNumber +'" class="ms-options-wrap"><button type="button"><span>None Selected</span></button><div class="ms-options"><ul></ul></div></div>');

                    var placeholder = $(instance.element).siblings('#ms-list-'+ instance.listNumber +'.ms-options-wrap').find('> button:first-child');
                    var optionsWrap = $(instance.element).siblings('#ms-list-'+ instance.listNumber +'.ms-options-wrap').find('> .ms-options');
                    var optionsList = optionsWrap.find('> ul');

                    // don't show checkbox (add class for css to hide checkboxes)
                    if( !instance.options.showCheckbox ) {
                        optionsWrap.addClass('hide-checkbox');
                    }
                    else if( instance.options.checkboxAutoFit ) {
                        optionsWrap.addClass('checkbox-autofit');
                    }

                    // check if list is disabled
                    if( $(instance.element).prop( 'disabled' ) ) {
                        placeholder.prop( 'disabled', true );
                    }

                    // set placeholder maxWidth
                    if( instance.options.maxPlaceholderWidth ) {
                        placeholder.css( 'maxWidth', instance.options.maxPlaceholderWidth );
                    }

                    // override with user defined maxHeight
                    if( instance.options.maxHeight ) {
                        var maxHeight = instance.options.maxHeight;
                    }
                    else {
                        // cacl default maxHeight
                        var maxHeight = ($(window).height() - optionsWrap.offset().top + $(window).scrollTop() - 20);
                    }

                    // maxHeight cannot be less than options.minHeight
                    maxHeight = maxHeight < instance.options.minHeight ? instance.options.minHeight : maxHeight;

                    optionsWrap.css({
                        maxWidth : instance.options.maxWidth,
                        minHeight: instance.options.minHeight,
                        maxHeight: maxHeight,
                    });

                    // isolate options scroll
                    // @source: https://github.com/nobleclem/jQuery-IsolatedScroll
                    optionsWrap.on( 'touchmove mousewheel DOMMouseScroll', function ( e ) {
                        if( ($(this).outerHeight() < $(this)[0].scrollHeight) ) {
                            var e0 = e.originalEvent,
                                delta = e0.wheelDelta || -e0.detail;

                            if( ($(this).outerHeight() + $(this)[0].scrollTop) > $(this)[0].scrollHeight ) {
                                e.preventDefault();
                                this.scrollTop += ( delta < 0 ? 1 : -1 );
                            }
                        }
                    });

                    // hide options menus if click happens off of the list placeholder button
                    $(document).off('click.ms-hideopts').on('click.ms-hideopts', function( event ){
                        if( !$(event.target).closest('.ms-options-wrap').length ) {
                            $('.ms-options-wrap.ms-active > .ms-options').each(function(){
                                $(this).closest('.ms-options-wrap').removeClass('ms-active');

                                var listID = $(this).closest('.ms-options-wrap').attr('id');

                                var thisInst = $(this).parent().siblings('.'+ listID +'.jqmsLoaded').data('plugin_multiselect-instance');

                                // USER CALLBACK
                                if( typeof thisInst.options.onControlClose == 'function' ) {
                                    thisInst.options.onControlClose( thisInst.element );
                                }
                            });
                        }
                        // hide open option lists if escape key pressed
                    }).on('keydown', function( event ){
                        if( (event.keyCode || event.which) == 27 ) { // esc key
                            $(this).trigger('click.ms-hideopts');
                        }
                    });

                    // handle pressing enter|space while tabbing through
                    placeholder.on('keydown', function( event ){
                        var code = (event.keyCode || event.which);
                        if( (code == 13) || (code == 32) ) { // enter OR space
                            placeholder.trigger( 'mousedown' );
                        }
                    });

                    // disable button action
                    placeholder.on( 'mousedown', function( event ){
                        // ignore if its not a left click
                        if( event.which && (event.which != 1) ) {
                            return true;
                        }

                        // hide other menus before showing this one
                        $('.ms-options-wrap.ms-active').each(function(){
                            if( $(this).siblings( '.'+ $(this).attr('id') +'.jqmsLoaded')[0] != optionsWrap.parent().siblings('.ms-list-'+ instance.listNumber +'.jqmsLoaded')[0] ) {
                                $(this).removeClass('ms-active');

                                var thisInst = $(this).siblings( '.'+ $(this).attr('id') +'.jqmsLoaded').data('plugin_multiselect-instance');

                                // USER CALLBACK
                                if( typeof thisInst.options.onControlClose == 'function' ) {
                                    thisInst.options.onControlClose( thisInst.element );
                                }
                            }
                        });

                        // show/hide options
                        optionsWrap.closest('.ms-options-wrap').toggleClass('ms-active');

                        // recalculate height
                        if( optionsWrap.closest('.ms-options-wrap').hasClass('ms-active') ) {
                            // USER CALLBACK
                            if( typeof instance.options.onControlOpen == 'function' ) {
                                instance.options.onControlOpen( instance.element );
                            }

                            optionsWrap.css( 'maxHeight', '' );

                            // override with user defined maxHeight
                            if( instance.options.maxHeight ) {
                                var maxHeight = instance.options.maxHeight;
                            }
                            else {
                                // cacl default maxHeight
                                var maxHeight = ($(window).height() - optionsWrap.offset().top + $(window).scrollTop() - 20);
                            }

                            if( maxHeight ) {
                                // maxHeight cannot be less than options.minHeight
                                maxHeight = maxHeight < instance.options.minHeight ? instance.options.minHeight : maxHeight;

                                optionsWrap.css( 'maxHeight', maxHeight );
                            }
                        }
                        else if( typeof instance.options.onControlClose == 'function' ) {
                            instance.options.onControlClose( instance.element );
                        }
                    }).click(function( event ){ event.preventDefault(); });

                    // add placeholder copy
                    if( instance.options.texts.placeholder ) {
                        placeholder.find('span').text( instance.options.texts.placeholder );
                    }

                    // add search box
                    if( instance.options.search ) {
                        optionsList.before('<div class="ms-search"><input type="text" value="" placeholder="'+ instance.options.texts.search +'" /></div>');
                        optionsList.after('<div class="no-result-message">' + instance.options.texts.searchNoResult + '</div>');

                        var search = optionsWrap.find('.ms-search input');

                        search.on('keyup', function(){
                            // ignore keystrokes that don't make a difference
                            if( $(this).data('lastsearch') == $(this).val() ) {
                                return true;
                            }

                            // pause timeout
                            if( $(this).data('searchTimeout') ) {
                                clearTimeout( $(this).data('searchTimeout') );
                            }

                            var thisSearchElem = $(this);

                            $(this).data('searchTimeout', setTimeout(function(){
                                thisSearchElem.data('lastsearch', thisSearchElem.val() );

                                // USER CALLBACK
                                if( typeof instance.options.searchOptions.onSearch == 'function' ) {
                                    instance.options.searchOptions.onSearch( instance.element );
                                }

                                // search non optgroup li's
                                var searchString = $.trim( search.val().toLowerCase() );
                                if( searchString ) {
                                    optionsList.find('li[data-search-term*="'+ searchString +'"]:not(.optgroup)').removeClass('ms-hidden');
                                    optionsList.find('li:not([data-search-term*="'+ searchString +'"], .optgroup)').addClass('ms-hidden');
                                }
                                else {
                                    optionsList.find('.ms-hidden').removeClass('ms-hidden');
                                }

                                // show/hide optgroups based on if there are items visible within
                                if( !instance.options.searchOptions.showOptGroups ) {
                                    optionsList.find('.optgroup').each(function(){
                                        if( $(this).find('li:not(.ms-hidden)').length ) {
                                            $(this).show();
                                        }
                                        else {
                                            $(this).hide();
                                        }
                                    });
                                }

                                instance._updateSelectAllText();
                            }, instance.options.searchOptions.delay ));
                        });
                    }

                    // add global select all options
                    if( instance.options.selectAll ) {
                        optionsList.before('<a href="#" class="ms-selectall global">' + instance.options.texts.selectAll + '</a>');
                    }

                    // handle select all option
                    optionsWrap.on('click', '.ms-selectall', function( event ){
                        event.preventDefault();

                        instance.updateSelectAll   = false;
                        instance.updatePlaceholder = false;

                        var select = optionsWrap.parent().siblings('.ms-list-'+ instance.listNumber +'.jqmsLoaded');

                        if( $(this).hasClass('global') ) {
                            // check if any options are not selected if so then select them
                            if( optionsList.find('li:not(.optgroup, .selected, .ms-hidden) input[type="checkbox"]:not(:disabled)').length ) {
                                // get unselected vals, mark as selected, return val list
                                optionsList.find('li:not(.optgroup, .selected, .ms-hidden) input[type="checkbox"]:not(:disabled)').closest('li').addClass('selected');
                                optionsList.find('li.selected input[type="checkbox"]:not(:disabled)').prop( 'checked', true );
                            }
                            // deselect everything
                            else {
                                optionsList.find('li:not(.optgroup, .ms-hidden).selected input[type="checkbox"]:not(:disabled)').closest('li').removeClass('selected');
                                optionsList.find('li:not(.optgroup, .ms-hidden, .selected) input[type="checkbox"]:not(:disabled)').prop( 'checked', false );
                            }
                        }
                        else if( $(this).closest('li').hasClass('optgroup') ) {
                            var optgroup = $(this).closest('li.optgroup');

                            // check if any selected if so then select them
                            if( optgroup.find('li:not(.selected, .ms-hidden) input[type="checkbox"]:not(:disabled)').length ) {
                                optgroup.find('li:not(.selected, .ms-hidden) input[type="checkbox"]:not(:disabled)').closest('li').addClass('selected');
                                optgroup.find('li.selected input[type="checkbox"]:not(:disabled)').prop( 'checked', true );
                            }
                            // deselect everything
                            else {
                                optgroup.find('li:not(.ms-hidden).selected input[type="checkbox"]:not(:disabled)').closest('li').removeClass('selected');
                                optgroup.find('li:not(.ms-hidden, .selected) input[type="checkbox"]:not(:disabled)').prop( 'checked', false );
                            }
                        }

                        var vals = [];
                        optionsList.find('li.selected input[type="checkbox"]').each(function(){
                            vals.push( $(this).val() );
                        });
                        select.val( vals ).trigger('change');

                        instance.updateSelectAll   = true;
                        instance.updatePlaceholder = true;

                        // USER CALLBACK
                        if( typeof instance.options.onSelectAll == 'function' ) {
                            instance.options.onSelectAll( instance.element, vals.length );
                        }

                        instance._updateSelectAllText();
                        instance._updatePlaceholderText();
                    });

                    // add options to wrapper
                    var options = [];
                    $(instance.element).children().each(function(){
                        if( this.nodeName == 'OPTGROUP' ) {
                            var groupOptions = [];

                            $(this).children('option').each(function(){
                                var thisOptionAtts = {};
                                for( var i = 0; i < instance.options.optionAttributes.length; i++ ) {
                                    var thisOptAttr = instance.options.optionAttributes[ i ];

                                    if( $(this).attr( thisOptAttr ) !== undefined ) {
                                        thisOptionAtts[ thisOptAttr ] = $(this).attr( thisOptAttr );
                                    }
                                }

                                groupOptions.push({
                                    name   : $(this).text(),
                                    value  : $(this).val(),
                                    checked: $(this).prop( 'selected' ),
                                    attributes: thisOptionAtts
                                });
                            });

                            options.push({
                                label  : $(this).attr('label'),
                                options: groupOptions
                            });
                        }
                        else if( this.nodeName == 'OPTION' ) {
                            var thisOptionAtts = {};
                            for( var i = 0; i < instance.options.optionAttributes.length; i++ ) {
                                var thisOptAttr = instance.options.optionAttributes[ i ];

                                if( $(this).attr( thisOptAttr ) !== undefined ) {
                                    thisOptionAtts[ thisOptAttr ] = $(this).attr( thisOptAttr );
                                }
                            }

                            options.push({
                                name      : $(this).text(),
                                value     : $(this).val(),
                                checked   : $(this).prop( 'selected' ),
                                attributes: thisOptionAtts
                            });
                        }
                        else {
                            // bad option
                            return true;
                        }
                    });
                    instance.loadOptions( options, true, false );

                    // BIND SELECT ACTION
                    optionsWrap.on( 'click', 'input[type="checkbox"]', function(){
                        $(this).closest( 'li' ).toggleClass( 'selected' );

                        var select = optionsWrap.parent().siblings('.ms-list-'+ instance.listNumber +'.jqmsLoaded');

                        // toggle clicked option
                        select.find('option[value="'+ instance._escapeSelector( $(this).val() ) +'"]').prop(
                            'selected', $(this).is(':checked')
                        ).closest('select').trigger('change');

                        // USER CALLBACK
                        if( typeof instance.options.onOptionClick == 'function' ) {
                            instance.options.onOptionClick(instance.element, this);
                        }

                        instance._updateSelectAllText();
                        instance._updatePlaceholderText();
                    });

                    // BIND FOCUS EVENT
                    optionsWrap.on('focusin', 'input[type="checkbox"]', function(){
                        $(this).closest('label').addClass('focused');
                    }).on('focusout', 'input[type="checkbox"]', function(){
                        $(this).closest('label').removeClass('focused');
                    });

                    // USER CALLBACK
                    if( typeof instance.options.onLoad === 'function' ) {
                        instance.options.onLoad( instance.element );
                    }

                    // hide native select list
                    $(instance.element).hide();
                },

                /* LOAD SELECT OPTIONS */
                loadOptions: function( options, overwrite, updateSelect ) {
                    // console.log( options );
                    overwrite    = (typeof overwrite == 'boolean') ? overwrite : true;
                    updateSelect = (typeof updateSelect == 'boolean') ? updateSelect : true;

                    var instance    = this;
                    var select      = $(instance.element);
                    var optionsList = select.siblings('#ms-list-'+ instance.listNumber +'.ms-options-wrap').find('> .ms-options > ul');
                    var optionsWrap = select.siblings('#ms-list-'+ instance.listNumber +'.ms-options-wrap').find('> .ms-options');

                    if( overwrite ) {
                        optionsList.find('> li').remove();

                        if( updateSelect ) {
                            select.find('> *').remove();
                        }
                    }

                    var containers = [];
                    for( var key in options ) {
                        // Prevent prototype methods injected into options from being iterated over.
                        if( !options.hasOwnProperty( key ) ) {
                            continue;
                        }

                        var thisOption      = options[ key ];
                        var container       = $('<li/>');
                        var appendContainer = true;

                        // OPTION
                        if( thisOption.hasOwnProperty('value') ) {
                            if( instance.options.showCheckbox && instance.options.checkboxAutoFit ) {
                                container.addClass('ms-reflow');
                            }

                            // add option to ms dropdown
                            instance._addOption( container, thisOption );

                            if( updateSelect ) {
                                var selOption = $('<option/>', {
                                    value: thisOption.value,
                                    text : thisOption.name
                                });

                                // add custom user attributes
                                if( thisOption.hasOwnProperty('attributes') && Object.keys( thisOption.attributes ).length ) {
                                    selOption.attr( thisOption.attributes );
                                }

                                // mark option as selected
                                if( thisOption.checked ) {
                                    selOption.prop( 'selected', true );
                                }

                                select.append( selOption );
                            }
                        }
                        // OPTGROUP
                        else if( thisOption.hasOwnProperty('options') ) {
                            var optGroup = $('<optgroup/>', {
                                label: thisOption.label
                            });

                            optionsList.find('> li.optgroup > span.label').each(function(){
                                if( $(this).text() == thisOption.label ) {
                                    container       = $(this).closest('.optgroup');
                                    appendContainer = false;
                                }
                            });

                            // prepare to append optgroup to select element
                            if( updateSelect ) {
                                if( select.find('optgroup[label="'+ thisOption.label +'"]').length ) {
                                    optGroup = select.find('optgroup[label="'+ thisOption.label +'"]');
                                }
                                else {
                                    select.append( optGroup );
                                }
                            }

                            // setup container
                            if( appendContainer ) {
                                container.addClass('optgroup');
                                container.append('<span class="label">'+ thisOption.label +'</span>');
                                container.find('> .label').css({
                                    clear: 'both'
                                });

                                // add select all link
                                if( instance.options.selectGroup ) {
                                    container.append('<a href="#" class="ms-selectall">' + instance.options.texts.selectAll + '</a>');
                                }

                                container.append('<ul/>');
                            }

                            for( var gKey in thisOption.options ) {
                                // Prevent prototype methods injected into options from
                                // being iterated over.
                                if( !thisOption.options.hasOwnProperty( gKey ) ) {
                                    continue;
                                }

                                var thisGOption = thisOption.options[ gKey ];
                                var gContainer  = $('<li/>');
                                if( instance.options.showCheckbox && instance.options.checkboxAutoFit ) {
                                    gContainer.addClass('ms-reflow');
                                }

                                // no clue what this is we hit (skip)
                                if( !thisGOption.hasOwnProperty('value') ) {
                                    continue;
                                }

                                instance._addOption( gContainer, thisGOption );

                                container.find('> ul').append( gContainer );

                                // add option to optgroup in select element
                                if( updateSelect ) {
                                    var selOption = $('<option/>', {
                                        value: thisGOption.value,
                                        text : thisGOption.name
                                    });

                                    // add custom user attributes
                                    if( thisGOption.hasOwnProperty('attributes') && Object.keys( thisGOption.attributes ).length ) {
                                        selOption.attr( thisGOption.attributes );
                                    }

                                    // mark option as selected
                                    if( thisGOption.checked ) {
                                        selOption.prop( 'selected', true );
                                    }

                                    optGroup.append( selOption );
                                }
                            }
                        }
                        else {
                            // no clue what this is we hit (skip)
                            continue;
                        }

                        if( appendContainer ) {
                            containers.push( container );
                        }
                    }
                    optionsList.append( containers );

                    // pad out label for room for the checkbox
                    if( instance.options.checkboxAutoFit && instance.options.showCheckbox && !optionsWrap.hasClass('hide-checkbox') ) {
                        var chkbx = optionsList.find('.ms-reflow:eq(0) input[type="checkbox"]');
                        if( chkbx.length ) {
                            var checkboxWidth = chkbx.outerWidth();
                            checkboxWidth = checkboxWidth ? checkboxWidth : 15;

                            optionsList.find('.ms-reflow label').css(
                                'padding-left',
                                (parseInt( chkbx.closest('label').css('padding-left') ) * 2) + checkboxWidth
                            );

                            optionsList.find('.ms-reflow').removeClass('ms-reflow');
                        }
                    }

                    // update placeholder text
                    instance._updatePlaceholderText();

                    // RESET COLUMN STYLES
                    optionsWrap.find('ul').css({
                        'column-count'        : '',
                        'column-gap'          : '',
                        '-webkit-column-count': '',
                        '-webkit-column-gap'  : '',
                        '-moz-column-count'   : '',
                        '-moz-column-gap'     : ''
                    });

                    // COLUMNIZE
                    if( select.find('optgroup').length ) {
                        // float non grouped options
                        optionsList.find('> li:not(.optgroup)').css({
                            'float': 'left',
                            width: (100 / instance.options.columns) +'%'
                        });

                        // add CSS3 column styles
                        optionsList.find('li.optgroup').css({
                            clear: 'both'
                        }).find('> ul').css({
                            'column-count'        : instance.options.columns,
                            'column-gap'          : 0,
                            '-webkit-column-count': instance.options.columns,
                            '-webkit-column-gap'  : 0,
                            '-moz-column-count'   : instance.options.columns,
                            '-moz-column-gap'     : 0
                        });

                        // for crappy IE versions float grouped options
                        if( this._ieVersion() && (this._ieVersion() < 10) ) {
                            optionsList.find('li.optgroup > ul > li').css({
                                'float': 'left',
                                width: (100 / instance.options.columns) +'%'
                            });
                        }
                    }
                    else {
                        // add CSS3 column styles
                        optionsList.css({
                            'column-count'        : instance.options.columns,
                            'column-gap'          : 0,
                            '-webkit-column-count': instance.options.columns,
                            '-webkit-column-gap'  : 0,
                            '-moz-column-count'   : instance.options.columns,
                            '-moz-column-gap'     : 0
                        });

                        // for crappy IE versions float grouped options
                        if( this._ieVersion() && (this._ieVersion() < 10) ) {
                            optionsList.find('> li').css({
                                'float': 'left',
                                width: (100 / instance.options.columns) +'%'
                            });
                        }
                    }

                    // update un/select all logic
                    instance._updateSelectAllText();
                },

                /* UPDATE MULTISELECT CONFIG OPTIONS */
                settings: function( options ) {
                    this.options = $.extend( true, {}, this.options, options );
                    this.reload();
                },

                /* RESET THE DOM */
                unload: function() {
                    $(this.element).siblings('#ms-list-'+ this.listNumber +'.ms-options-wrap').remove();
                    $(this.element).show(function(){
                        $(this).css('display','').removeClass('jqmsLoaded');
                    });
                },

                /* RELOAD JQ MULTISELECT LIST */
                reload: function() {
                    // remove existing options
                    $(this.element).siblings('#ms-list-'+ this.listNumber +'.ms-options-wrap').remove();
                    $(this.element).removeClass('jqmsLoaded');

                    // load element
                    this.load();
                },

                // RESET BACK TO DEFAULT VALUES & RELOAD
                reset: function() {
                    var defaultVals = [];
                    $(this.element).find('option').each(function(){
                        if( $(this).prop('defaultSelected') ) {
                            defaultVals.push( $(this).val() );
                        }
                    });

                    $(this.element).val( defaultVals );

                    this.reload();
                },

                disable: function( status ) {
                    status = (typeof status === 'boolean') ? status : true;
                    $(this.element).prop( 'disabled', status );
                    $(this.element).siblings('#ms-list-'+ this.listNumber +'.ms-options-wrap').find('button:first-child')
                        .prop( 'disabled', status );
                },

                /** PRIVATE FUNCTIONS **/
                // update the un/select all texts based on selected options and visibility
                _updateSelectAllText: function(){
                    if( !this.updateSelectAll ) {
                        return;
                    }

                    var instance = this;

                    // select all not used at all so just do nothing
                    if( !instance.options.selectAll && !instance.options.selectGroup ) {
                        return;
                    }

                    var optionsWrap = $(instance.element).siblings('#ms-list-'+ instance.listNumber +'.ms-options-wrap').find('> .ms-options');

                    // update un/select all text
                    optionsWrap.find('.ms-selectall').each(function(){
                        var unselected = $(this).parent().find('li:not(.optgroup,.selected,.ms-hidden)');

                        $(this).text(
                            unselected.length ? instance.options.texts.selectAll : instance.options.texts.unselectAll
                        );
                    });

                    var shownOptionsCount = optionsWrap.find('> ul li:not(.optgroup,.ms-hidden)').length;

                    // show/hide no-results message
                    optionsWrap.find('.no-result-message').toggle( shownOptionsCount ? false : true );

                    // show/hide (un)select all element as necessary
                    optionsWrap.find('.ms-selectall.global').toggle( shownOptionsCount ? true : false );
                },

                // update selected placeholder text
                _updatePlaceholderText: function(){
                    if( !this.updatePlaceholder ) {
                        return;
                    }

                    var instance       = this;
                    var select         = $(instance.element);
                    var selectVals     = select.val() ? select.val() : [];
                    var placeholder    = select.siblings('#ms-list-'+ instance.listNumber +'.ms-options-wrap').find('> button:first-child');
                    var placeholderTxt = placeholder.find('span');
                    var optionsWrap    = select.siblings('#ms-list-'+ instance.listNumber +'.ms-options-wrap').find('> .ms-options');

                    // if there are disabled options get those values as well
                    if( select.find('option:selected:disabled').length ) {
                        selectVals = [];
                        select.find('option:selected').each(function(){
                            selectVals.push( $(this).val() );
                        });
                    }

                    // get selected options
                    var selOpts = [];
                    for( var key in selectVals ) {
                        // Prevent prototype methods injected into options from being iterated over.
                        if( !selectVals.hasOwnProperty( key ) ) {
                            continue;
                        }

                        selOpts.push(
                            $.trim( select.find('option[value="'+ instance._escapeSelector( selectVals[ key ] ) +'"]').text() )
                        );

                        if( selOpts.length >= instance.options.maxPlaceholderOpts ) {
                            break;
                        }
                    }

                    // UPDATE PLACEHOLDER TEXT WITH OPTIONS SELECTED
                    placeholderTxt.text( selOpts.join( ', ' ) );

                    if( selOpts.length ) {
                        optionsWrap.closest('.ms-options-wrap').addClass('ms-has-selections');

                        // USER CALLBACK
                        if( typeof instance.options.onPlaceholder == 'function' ) {
                            instance.options.onPlaceholder( instance.element, placeholderTxt, selOpts );
                        }
                    }
                    else {
                        optionsWrap.closest('.ms-options-wrap').removeClass('ms-has-selections');
                    }

                    // replace placeholder text
                    if( !selOpts.length ) {
                        placeholderTxt.text( instance.options.texts.placeholder );
                    }
                    // if copy is larger than button width use "# selected"
                    else if( instance.options.replacePlaceholderText && ((placeholderTxt.width() > placeholder.width()) || (selOpts.length != selectVals.length)) ) {
                        placeholderTxt.text( selectVals.length + instance.options.texts.selectedOptions );
                    }
                },

                // Add option to the custom dom list
                _addOption: function( container, option ) {
                    var instance = this;
                    var optionNameText = $('<div/>').html( option.name ).text();

                    var thisOption = $('<label/>', {
                        for : 'ms-opt-'+ msOptCounter
                    }).html( `<span class="checkbox-title">${optionNameText}</span>` );

                    var thisCheckbox = $('<input>', {
                        type : 'checkbox',
                        title: optionNameText,
                        id   : 'ms-opt-'+ msOptCounter,
                        value: option.value
                    });

                    // add user defined attributes
                    if( option.hasOwnProperty('attributes') && Object.keys( option.attributes ).length ) {
                        thisCheckbox.attr( option.attributes );
                    }

                    if( option.checked ) {
                        container.addClass('default selected');
                        thisCheckbox.prop( 'checked', true );
                    }

                    thisOption.prepend( '<span class="custom-checkbox"></span>' );
                    thisOption.prepend( thisCheckbox );

                    var searchTerm = '';
                    if( instance.options.searchOptions.searchText ) {
                        searchTerm += ' ' + optionNameText.toLowerCase();
                    }
                    if( instance.options.searchOptions.searchValue ) {
                        searchTerm += ' ' + option.value.toLowerCase();
                    }

                    container.attr( 'data-search-term', $.trim( searchTerm ) ).prepend( thisOption );

                    msOptCounter = msOptCounter + 1;
                },

                // check ie version
                _ieVersion: function() {
                    var myNav = navigator.userAgent.toLowerCase();
                    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
                },

                // escape selector
                _escapeSelector: function( string ) {
                    if( typeof $.escapeSelector == 'function' ) {
                        return $.escapeSelector( string );
                    }
                    else {
                        return string.replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, "\\$&");
                    }
                }
            };

            // ENABLE JQUERY PLUGIN FUNCTION
            $.fn.multiselect = function( options ){
                if( !this.length ) {
                    return;
                }

                var args = arguments;
                var ret;

                // menuize each list
                if( (options === undefined) || (typeof options === 'object') ) {
                    return this.each(function(){
                        if( !$.data( this, 'plugin_multiselect' ) ) {
                            $.data( this, 'plugin_multiselect', new MultiSelect( this, options ) );
                        }
                    });
                } else if( (typeof options === 'string') && (options[0] !== '_') && (options !== 'init') ) {
                    this.each(function(){
                        var instance = $.data( this, 'plugin_multiselect' );

                        if( instance instanceof MultiSelect && typeof instance[ options ] === 'function' ) {
                            ret = instance[ options ].apply( instance, Array.prototype.slice.call( args, 1 ) );
                        }

                        // special destruct handler
                        if( options === 'unload' ) {
                            $.data( this, 'plugin_multiselect', null );
                        }
                    });

                    return ret;
                }
            };
        }(jQuery));

        (function ($) {
            var alice_feedback_modal = $('#alice-feedback-modal');

            $(document).on('click', '#deactivate-myaliceai', function (e) {
                if ($(this).text() !== 'Network Deactivate') {
                    e.preventDefault();

                    alice_feedback_modal.fadeIn();
                }
            }).on('click', '.alice-modal-close, .alice-modal-bg', function (e) {
                e.preventDefault();

                alice_feedback_modal.fadeOut();
            }).on('submit', '#alice-feedback-modal form', function (e) {
                e.preventDefault();

                var $form = $(this),
                    deactivate_url = $('#deactivate-myaliceai').attr('href'),
                    data = $form.serialize();

                $.post(ajaxurl, data, function (response) {
                    if (response.success) {
                        location.href = '<?php echo admin_url(); ?>' + deactivate_url;
                    }
                });
            }).on('click', '[data-form]', function (e) {
                e.preventDefault();
                var form_section = $('.alice-connect-with-myalice');

                switch ($(this).data('form')) {
                    case 'login':
                        form_section.addClass('alice-login-active');
                        form_section.find('.--full-name input').attr('disabled', 'disabled');
                        form_section.find('input[name="action"]').val('myalice_login');
                        break;
                    case 'signup':
                        form_section.removeClass('alice-login-active');
                        form_section.find('.--full-name input').removeAttr('disabled');
                        form_section.find('input[name="action"]').val('myalice_signup');
                        break;
                }
            }).on('click', '[data-link-section]', function (e) {
                e.preventDefault();
                $('#alice-dashboard').removeClass('--connect-with-myalice --select-the-team --needs-your-permission --explore-myalice --plugin-settings').addClass($(this).data('link-section'));
            }).on('change', '.alice-plugin-settings form', function (e) {
                $(this).find('button[type="submit"]').removeAttr('disabled');
            }).on('submit', '.alice-plugin-settings form', function (e) {
                e.preventDefault();

                var $form = $(this),
                    url = $form.attr('action'),
                    data = $form.serialize(),
                    spinner = $form.find('.spinner');

                spinner.addClass('is-active');

                $.post(url, data, function (response) {
                    spinner.removeClass('is-active');

                    const notice_area = $form.find('.myalice-notice-area');

                    if (response.success) {
                        $form.find('button[type="submit"]').attr('disabled', 'disabled');
                        notice_area.prepend(`<div class="updated"><p>${response.data.message}</p></div>`);
                    } else {
                        notice_area.prepend(`<div class="error"><p>${response.data.message}</p></div>`);
                    }

                    setTimeout(function () {
                        notice_area.html('');
                    }, 3000);
                });
            }).on('submit', '.alice-connect-with-myalice form', function (e) {
                e.preventDefault();

                var $form = $(this),
                    url = $form.attr('action'),
                    data = $form.serialize(),
                    spinner = $form.find('.spinner');

                spinner.addClass('is-active');

                $.post(url, data, function (response) {
                    spinner.removeClass('is-active');

                    const notice_area = $form.find('.myalice-notice-area');

                    if (response.success) {
                        setTimeout(function () {
                            if (response.data.is_auto_connected) {
                                $('#alice-dashboard').removeClass('--connect-with-myalice --select-the-team --needs-your-permission --explore-myalice --plugin-settings').addClass('--explore-myalice');
                            } else {
                                $('.--myalice-dashboard-menu-link')[0].click();
                            }
                        }, 3000);

                        notice_area.prepend(`<div class="updated"><p>${response.data.message}</p></div>`);
                    } else {
                        notice_area.prepend(`<div class="error"><p>${response.data.message}</p></div>`);
                    }

                    setTimeout(function () {
                        notice_area.html('');
                    }, 3000);
                });
            }).on('submit', '.alice-select-the-team form', function (e) {
                e.preventDefault();

                var $form = $(this),
                    url = $form.attr('action'),
                    data = $form.serialize(),
                    spinner = $form.find('.spinner');

                spinner.addClass('is-active');

                $.post(url, data, function (response) {
                    spinner.removeClass('is-active');

                    const notice_area = $form.find('.myalice-notice-area');

                    if (response.success) {
                        if (response.data.is_connected) {
                            $('#alice-dashboard').removeClass('--connect-with-myalice --select-the-team --needs-your-permission --explore-myalice --plugin-settings').addClass('--explore-myalice');
                        }

                        notice_area.prepend(`<div class="updated"><p>${response.data.message}</p></div>`);
                    } else {
                        notice_area.prepend(`<div class="error"><p>${response.data.message}</p></div>`);
                    }

                    setTimeout(function () {
                        notice_area.html('');
                    }, 3000);
                });
            }).on('click', '.myalice-notice-dismiss', function (e) {
                e.preventDefault();
                var notice_wrap = $(this).closest('.notice.notice-info');

                $.post(ajaxurl, {action: 'myalice_notice_dismiss'}, function (response) {
                    if (response.success) {
                        notice_wrap.remove();
                    }
                });
            }).on('click', 'span.myalice-pass-show', function (e) {
                e.preventDefault();

                var $this = $(this),
                    password_field = $this.siblings('input');

                if ($this.hasClass('dashicons-visibility')) {
                    password_field.attr('type', 'text');
                } else {
                    password_field.attr('type', 'password');
                }

                $this.toggleClass('dashicons-visibility dashicons-hidden')
            }).on('click', '.alice-migration-warning button.alice-btn', function (e) {
                e.preventDefault();

                var $this = $(this),
                    spinner = $this.siblings('.spinner'),
                    notice_area = $this.siblings('.myalice-notice-area'),
                    url = "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                    data = {
                        "action": "myalice_migration",
                        "nonce": "<?php echo wp_create_nonce( 'myaliceai' ); ?>"
                    };

                spinner.addClass('is-active');
                notice_area.hide();

                $.post(url, data, function (response) {
                    spinner.removeClass('is-active');

                    if (response.success) {
                        location.href = "<?php echo admin_url('admin.php?page=myalice_dashboard'); ?>";
                    } else {
                        notice_area.show();
                    }
                });
            }).on('click', '.myalice-customization-admin-notice button.notice-dismiss', function (e) {
                e.preventDefault();
                var notice_wrap = $(this).closest('.myalice-customization-admin-notice');

                $.post(ajaxurl, {action: 'myalice_customization_notice_dismiss'}, function (response) {
                    if (response.success) {
                        notice_wrap.remove();
                    }
                });
            }).on('click', '.--wc-api-sync-btn', function (e) {
                e.preventDefault();

                var $this = $(this),
                    $label = $this.children('span'),
                    $wc_status_button = $('li.--wcapi-status button'),
                    url = "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                    data = {
                        "action": "myalice_check_wc_api_status",
                        "nonce": "<?php echo wp_create_nonce( 'myaliceai' ); ?>"
                    };

                $this.addClass('--syncing').removeClass('--synced');
                $label.text('Syncing Changes...');

                $.post(url, data, function (response) {
                    $this.removeClass('--syncing').addClass('--synced');

                    if (response.success) {
                        $label.text('Changes synced');

                        if (response.data.error === false && response.data.success === true) {
                            $wc_status_button.removeClass('--wcapi-disconnected').addClass('--wcapi-operational');
                            $wc_status_button.text('Operational');
                            $wc_status_button.removeAttr('title');
                        } else {
                            $wc_status_button.removeClass('--wcapi-operational').addClass('--wcapi-disconnected');
                            $wc_status_button.text('Disconnected');
                            $wc_status_button.attr('title', response.data.message);
                            $('#alice-dashboard').removeClass('--explore-myalice').addClass('--needs-your-permission');
                        }
                    } else {
                        $this.removeClass('--syncing --synced');
                        $label.text('Changes failed');
                    }
                });
            }).on('change', '[name="show_chatbox"]', function () {
                let $this = $(this);
                if ($this.val() === 'specific') {
                    $('.--display-chat-widget').addClass('--page-specific');
                } else {
                    $('.--display-chat-widget').removeClass('--page-specific');
                }
            });

            $('.--display-chat-widget > select').multiselect({
                placeholder: 'Select Pages',
                search: true,
                searchOptions: {
                    'default': 'Search Pages'
                },
                selectAll: true
            });
        })(jQuery);
    </script>
	<?php
} );