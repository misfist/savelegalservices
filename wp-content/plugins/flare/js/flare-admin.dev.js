(function($, window, undefined){
    window.FlareAdmin = {
        // Elements used in this plugin
        elems: {},
        // The namespace of this plugin
        ns: __namespace,
        
        // Bind all events to elements
        assignEvents: function(){
            var self = this;
            
            // Code mode toggles
            this.elems.buttonList.delegate('.button-mode-choice', 'click.' + this.ns, function(event){
                var $this = $.data(this, '$this'),
                    $easy = $.data(this, '$easy'),
                    $code = $.data(this, '$code'),
                    $easyButton = $.data(this, '$easyButton'),
                    $codeButton = $.data(this, '$codeButton');
                
                if(!$this){
                    $this = $(this);
                    $.data(this, '$this', $this);
                }
                
                if(!$easy){
                    $easy = $this.closest('.button-row').find('.button-mode-config.button-mode-easy');
                    $.data(this, '$easy', $easy);
                }
                
                if(!$code){
                    $code = $this.closest('.button-row').find('.button-mode-config.button-mode-code');;
                    $.data(this, '$code', $code);
                }
                
                if(!$easyButton){
                    if(this.value == "easy"){
                        $easyButton = $this.closest('label');
                    } else {
                        $easyButton = $this.closest('.button-row').find('.button-mode-choice[value="easy"]').closest('label');
                    }
                    $.data(this, '$easyButton', $easyButton);
                }
                
                if(!$codeButton){
                    if(this.value == "code"){
                        $codeButton = $this.closest('label');
                    } else {
                        $codeButton = $this.closest('.button-row').find('.button-mode-choice[value="code"]').closest('label');
                    }
                    $.data(this, '$codeButton', $codeButton);
                }
                
                if(this.value == "easy"){
                    $easy.slideDown(500);
                    $code.slideUp(500);
                    $easyButton.hide();
                    $codeButton.show();
                } else if(this.value == "code"){
                    $easy.slideUp(500);
                    $code.slideDown(500);
                    $codeButton.hide();
                    $easyButton.show();
                }
            });
            
            // Delete button buttons
            this.elems.buttonList.delegate('.button-row .button-delete', 'click.' + this.ns, function(event){
                event.preventDefault();
                
                var $this = $(this);
                var buttonType = $this.closest('.button-row').attr('data-button-type');
                
                if(confirm("Are you sure you want to delete this button?")){
                    $this.closest('.button-row').slideUp(500, function(){
                        $(this).remove();
                        self.updateAvailableButtons();
                    });
                    
                    var buttonID = $this.attr('data-button-id');
                    if(buttonID){
                        self.elems.form.append('<input type="hidden" name="data[delete][]" value="' + buttonID  + '" id="' + self.ns + '-delete-button-' + buttonID + '" />');
                    }
                }
            });
            
            this.elems.buttonList.delegate('.button-row a.' + this.ns + '-button', 'click.' + this.ns, function(event){
                event.preventDefault();
            });
            
            // Add button buttons
            this.elems.addButtons.find('a.' + this.ns + '-button').bind('click.' + this.ns, function(event){
                event.preventDefault();
                
                $.ajax({
                    url: this.href,
                    type: "GET",
                    cache: false,
                    success: function(data){
                        self.elems.buttonList.append(data);
                        
                        var $colorPickers = self.elems.buttonList.find('.button-color');
                        $colorPickers.each(function(ind){
                            var $colorPicker = $colorPickers.eq(ind);
                            
                            if(!$colorPicker.data('hsb')){
                                $colorPicker.miniColors({
                                    change: function(hex, rgb){
                                        this.trigger('change');
                                    }
                                });
                            }
                        });
                        
                        self.updateAvailableButtons();
                        self.updateIconStyle();
                    }
                });
            });
            
            // Reveal add button choices 
            this.elems.addButtons.find('#' + this.ns + '-add-button-link').bind('click.' + this.ns, function(event){
                event.preventDefault();
                
                // Do nothing if the add button block is disabled
                if(self.elems.addButtons.hasClass('disabled')){
                    return false;
                }
                
                var $buttons = $.data(this, '$buttons');
                
                if(!$buttons){
                    $buttons = self.elems.addButtons.find('ul');
                    $.data(this, '$buttons', $buttons);
                }
                
                if($buttons.hasClass('buttons-open')){
                    $buttons.removeClass('buttons-open');
                } else {
                    $buttons.addClass('buttons-open');
                }
            });
            
            // Button preview color change
            this.elems.buttonList.delegate('input.button-color', 'change', function(event){
                var $this = $.data(this, '$this'),
                    $button = $.data(this, '$button');
                
                if(!$this){
                    $this = $(this);
                    $.data(this, '$this', $this);
                }
                
                if(!$button){
                    $button = $this.closest('.button-row').find('.' + self.ns + '-button');
                    $.data(this, '$button', $button);
                }
                
                $button.css('background-color', this.value);
            });
            
            // Button preview icon style
            this.elems.iconStyle.bind('change', function(event){
                self.updateIconStyle();
            });
            
            this.elems.positionChoices.find('input[type="checkbox"]').bind('click', function(event){
                var $this = $.data(this, '$this') || $.data(this, '$this', $(this));
                var $select = $.data(this, '$select') || $.data(this, '$select', $this.closest('p').find('.fancy-select'));
                var label = "";
                $select.find('option').each(function(ind){
                    if($this[0].checked){
                        if(ind == 1){
                            this.selected = true;
                            label = this.text;
                        }
                    } else {
                        this.selected = (this.value == "none");
                    }
                });
                $select.find('.selected').text(label);
            });
            this.elems.positionChoices.find('input[name="data[positions][]"]').bind('click', function(){
                self.updatePositions();
            });
            this.elems.positionChoices.find('select[name="data[positions][]"]').bind('change', function(){
                self.updatePositions();
                
                var $this = $.data(this, '$this') || $.data(this, '$this', $(this));
                var $checkbox = $.data(this, '$checkbox') || $.data(this, '$checkbox', $this.closest('p').find('input[type="checkbox"]'));
                if($this.find('option:selected').val() == "none"){
                    $checkbox.removeAttr('checked')[0].checked = false;
                    $checkbox.closest('.fancy-checkbox').removeClass('on').addClass('off');
                } else {
                    $checkbox.attr('checked', 'checked')[0].checked = true;
                    $checkbox.closest('.fancy-checkbox').removeClass('off').addClass('on');
                }
            });
            
            this.elems.buttonList.delegate('.fancy-select', 'click', function(event){
                var $select = $(this).find('select');
                $('#fancyform-options-dropdown').addClass('for-' + $select.attr('id'));
            });
            
            // Safety fallback for un-saved changes
            window.onbeforeunload = function(){
                if(self.originalSerialize != self.elems.form.serialize()){
                    return "You have unsaved changes. Are you sure you want to leave without saving?";
                }
            }
            // Un-bind safety fallback when we're submitting the form for saving
            this.elems.form.bind('submit', function(){
                window.onbeforeunload = null;
            });
        },
        
        initialize: function(){
            // The form
            this.elems.form = $('#' + this.ns + '-form');
            // The button list UL wrapper
            this.elems.buttonList = $('#' + this.ns + '-button-list');
            // The add button list wrapper
            this.elems.addButtons = $('#' + this.ns + '-add-button');
            // Icon style picker
            this.elems.iconStyle = $('#' + this.ns + '-choose-iconstyle');
            // Position display
            this.elems.positionDisplay = $('#' + this.ns + '-position-display');
            // Position choices wrapper
            this.elems.positionChoices = $('#' + this.ns + '-position-choices');
            
            // The form's original data value for comparison on an un-saved page exit
            this.originalSerialize = this.elems.form.serialize();
            
            // Color picker form elements
            this.elems.buttonList.find('input.button-color').miniColors({
                change: function(hex, rgb){
                    this.trigger('change');
                }
            });
            
            // jQuery UI Sortable on the button row elements
            this.elems.buttonList.sortable({
                axis: 'y',
                items: 'li.button-row',
                handle: '.button-drag-handle'
            });
            
            this.elems.form.find('.fancy').fancy();
            
            this.interfaces();
            
            this.updateIconStyle();
            
            this.updateAvailableButtons();
            
            this.assignEvents();
        },
        
        interfaces: function(){
            var self = this;
            
            for(var id in FlareInterfaces){
                var properties = FlareInterfaces[id];
                var $elem = $('#' + id);
                
                // Only process if the element still exists and is not a hidden field
                if($elem.length && !$elem.is('input[type="hidden"]')){
                    switch(properties.type){
                        case "slider":
                            var propertiesKey = {
                                animate: true,
                                min: 1,
                                max: 100,
                                orientation: 'horizontal',
                                range: false,
                                step: 1
                            };
                            var sliderOptions = {};
                            for(var key in propertiesKey){
                                if(properties[key]){
                                    sliderOptions[key] = properties[key];
                                } else {
                                    sliderOptions[key] = propertiesKey[key];
                                }
                            }
                            
                            $('#' + id).wrap('<div class="flare-slider-wrapper"></div>');
                            $('#' + id).before('<div id="' + id + '-slider" class="flare-slider"><span class="min">' + (properties.minLabel ? properties.minLabel : sliderOptions.min) + '</span><span class="max">' + (properties.maxLabel ? properties.maxLabel : sliderOptions.max) + '</span></div>');
                            
                            var $slider = $('#' + id + '-slider');
                            
                            if($elem.is('select')){
                                $slider.after('<span class="selected">' + $elem.find('option:selected').text() + '</span>');
                            }
                            
                            if(properties.marks){
                                var range = (sliderOptions.max - sliderOptions.min);
                                var totalMarks = (range / sliderOptions.step);
                                var marksHTML = "";
                                
                                for(var i = 0; i < totalMarks; i++){
                                    marksHTML+= '<span class="mark" style="width:' + (100 / totalMarks) + '%">' + (sliderOptions.min + (sliderOptions.step * (i + 1))) + '</span>';
                                }
                                
                                $slider.append('<span class="marks">' + marksHTML + '</span>');
                            }
                            
                            sliderOptions.value = $elem.val();
                            sliderOptions.slide = function(event, ui){
                                var $input = $.data(this, '$input');
                                
                                if(!$input){
                                    var $input = $('#' + ui.handle.parentNode.id.replace('-slider', ""));
                                    $.data(this, $input);
                                }
                                
                                if($input.is('input[type="text"]')){
                                    $input.val(ui.value);
                                } else if($input.is('select')){
                                    $input.find('option').each(function(){
                                        if(this.value == ui.value){
                                            this.selected = true;
                                        } else {
                                            this.selected = false;
                                        }
                                    });
                                    $(ui.handle.parentNode).next('.selected').text($input.find('option:selected').text());
                                }
                            };
                            sliderOptions.change = function(event, ui){
                                var $input = $.data(this, '$input');
                                
                                if(!$input){
                                    var $input = $('#' + ui.handle.parentNode.id.replace('-slider', ""));
                                    $.data(this, '$input', $input);
                                }
                                
                                if(FlareInterfaces[$input.attr('id')].update){
                                    self.interfaceUpdate($input.val(), 'slider', FlareInterfaces[$input.attr('id')].update);
                                }
                            };
                            
                            $slider.slider(sliderOptions);
                            
                            $('#' + id).bind('keyup', function(event){
                                var elem = this;
                                if (this.sliderTimer)
                                    clearTimeout(elem.sliderTimer);
                                
                                // Set delay timer so a check isn't done on every single key stroke
                                this.sliderTimer = setTimeout(function(){
                                    $('#' + elem.id + '-slider').slider('value', elem.value);
                                }, 250 );
                                
                                return true;
                            });
                        break;
                    }
                }
            }
        },
        
        // Update other interface elements based off interaction with an interface
        interfaceUpdate: function(value, type, updateObj){
            switch(type){
                case "slider":
                    var $option = $('#options-' + updateObj.option);
                        $option.val(Math.min(parseInt($option.val(), 10), parseInt(value, 10)));
                    
                    var $slider = $('#options-' + updateObj.option + '-slider');
                    if($slider.length){
                        
                        $slider.slider('option', updateObj.value, value);
                        
                        if(updateObj.value == 'min'){
                            $slider.find('.min').text(value);
                        } else if(updateObj.value == 'max'){
                            $slider.find('.max').text(value);
                        }
                        
                        $slider.slider('value', parseInt($option.val(), 10));
                    }
                break;
            }
        },
        
        // Update which buttons are available to be added
        updateAvailableButtons: function(){
            var self = this;
            
            // Make all buttons available
            this.elems.addButtons.find('li').show();
            
            // Loop through added buttons and hide the ability to add them again
            var count = this.elems.addButtons.find('li').length;
            this.elems.buttonList.find('.button-row').each(function(ind){
                var $row = $(this);
                var buttonType = $row.attr('data-button-type');
                
                $('#' + self.ns + '-available-button-' + buttonType).hide();
                count--;
            });
            
            // If all buttons are used, disabled the block, or enable if there are still buttons available
            if(count > 0){
                this.elems.addButtons.removeClass('disabled');
            } else {
                this.elems.addButtons.find('ul.buttons-open').removeClass('buttons-open');
                this.elems.addButtons.addClass('disabled');
            }
        },
        
        updateIconStyle: function(){
            var iconStyles = [];
            this.elems.iconStyle.find('option').each(function(){
                iconStyles.push(this.value);
            });
            
            var $buttons = this.elems.buttonList.find('.' + this.ns + '-button');
            
            for(var i in iconStyles){
                $buttons.removeClass(this.ns + '-iconstyle-' + iconStyles[i]);
            }
            $buttons.addClass(this.ns + '-iconstyle-' + this.elems.iconStyle.val());
        },
        
        updatePositions: function(){
            var positions = [];
            this.elems.positionChoices.find('input[name="data[positions][]"]:checked, select[name="data[positions][]"]').each(function(){
                positions.push($(this).val());
            });
            
            this.elems.positionDisplay.find('span').hide();
            for(var p in positions){
                if(positions[p] != ""){
                    this.elems.positionDisplay.find('span.' + positions[p]).show();
                }
            }
        }
    };
    
    $(document).ready(function(){
        FlareAdmin.initialize();
        
        $('#toplevel_page_flare').find('.wp-submenu a[href$="/dtlabs"]').attr('target', '_blank');

        // SlideDeck.com blog RSS feed AJAX update
        $('#flare-blog-rss-feed').load(ajaxurl + "?action=flare_blog_feed");
    });
})(jQuery, window, null);
