(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
                        source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "$1" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
                            
                            if(input.parent().children('#region').length != 0)
                            {
                                if($(ui.item.option).val() > 0)
                                {
                                    //send ajax requesting the district list
                                    $('#area_feed').html('<img src="'+imageUrl+'/indicator.gif"/>');
                                    $.ajax({
                                        url : rootUrl + '/mice/en/search/areafeed',
                                        dataType: "json",
                                        type: "post",
                                        data: {"area_id" : $(ui.item.option).val()},
                                        success : function(data)
                                        {
                                            if(data != null)
                                            {
                                                $('#area_feed').empty();
                                                $('#district').empty();
                                                $.each(data, function(key, value){
                                                    $('#district').append('<option value="'+value.area_id+'">'+value.area_name+'</option>');
                                                });
                                            }
                                            $("#district option:first").attr('selected', 'selected');
                                            $('#district').parent().children('.ui-autocomplete-input').val($("#district option:first").text());

                                            //unBlock Ui modal
                                            $.unblockUI();

                                        }

                                    });
                                }
                                else
                                {
                                    $('#district').empty().html('<option value="all">'+chooseArea+'</option>');
                                    $('#district').parent().children('.ui-autocomplete-input').val($("#district option:first").text());
                                }
                            }
                        },
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									var elid = $(this).parent().children('select').attr('id');
									if(elid == 'region' || elid == 'district')
									{
										$( this ).val( pickOne );
										select.val( pickOne );
									}
									else
									{
										$( this ).val( showAll );
										select.val( showAll );
									}
									input.data( "autocomplete" ).term = "Show All";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" )
                    .click(function(){
                        input.val('');
                     });

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				this.button = $( "<button type='button'>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},
			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#district ,#region, #category, #scale, #type" ).combobox();
	});