$(window).load(function(){


	function update_view_for_data_product(){
		//Remove Popup image if has many element
		if( $('.template-image').length > 1 ){

			let popupImage = $('.template-image');

			popupImage.each(function(i, el){
				if( i != 0 ){
					$(el).remove();
				}
			});
			
		}


		//Remove Popup asset file if has many element
		if( $('.modal-wapper-add-file').length > 1 ){

			let popupImage = $('.modal-wapper-add-file');

			popupImage.each(function(i, el){
				if( i != 0 ){
					$(el).remove();
				}
			});
			
		}

		$('.input_file_asset').each(function(i,el){
            if( $(el).val() ){

                var obj = JSON.parse($(el).val());

                if( obj ){
                    var extension = obj.type_file,
                        file_name = obj.file_name;

                    if( obj.type_link == 'local' ){
                        file_url = $('meta[name="domain"]').attr('content')+ '/'+obj.link;
                    }else{
                        file_url = obj.link;
                    }
                        

                    if ( obj.is_image ) {
                        $(el).parent().find('.preview_file').attr('href',file_url).html('<img style="margin:5px 0;display: block;" src="'+file_url+'" >'+file_name).show();
                    } else{
                         $(el).parent().find('.preview_file').attr('href',file_url).html('<img style="margin:5px 0;display: block;" src="'+$('meta[name="domain"]').attr('content')+'/'+'filemanager/filemanager/img/ico/'+extension+'.jpg" >'+file_name).show();
                    }

                }

            }
        });


		//Change title of input file download
		input_repeater_update_class_title_item();

		$('.change_title_item_input_repeater').each(function(index,el){

            if( $( el ).val() ){ 
                $(el).closest('.x_panel').find('>.x_title>h2>.title').text($(el).val());
            }
        });

		update_title_variable();

		show_form_image_multiable();

 		setTimeout(function() {
 			
 			$('img[data-src]').each(function(index, el){
	 			$(el).attr('src',$(el).data('src'));
	 		});

 		}, 10);
	}



	function update_hideshow_input(){

		let select_product_type = $('.select_product_type').val();

		$('#data-info-ecommerce-product .menu-left li').removeClass('is-show').hide();
		$('#data-info-ecommerce-product .menu-left li.product-'+select_product_type).addClass('is-show').show();

		

 		if( select_product_type == 'simple' ){

 			$('.checked_product_virtual1, .checked_product_downloadable1').show();


	 		$('.onoff_input').each(function(index, el){
	 			if( $(el).is(':checked') ){
	 				$('#data-info-ecommerce-product .menu-left li.show-when-'+$(el).data('input')).show();
	 				$('#data-info-ecommerce-product .menu-left li.hide-when-'+$(el).data('input')).hide();
	 			}else{
	 				$('#data-info-ecommerce-product .menu-left li.show-when-'+$(el).data('input')).hide();
	 				$('#data-info-ecommerce-product .menu-left li.hide-when-'+$(el).data('input')).show();
	 			}
	 		});

 		}else{

 			$('.checked_product_virtual1, .checked_product_downloadable1').hide();

 		}

 		if( select_product_type == 'variable' ){
 			$('.use_for_variable').closest('label').show();
 		}else{
 			$('.use_for_variable').closest('label').hide();
 		}
 		
 	
 		if( !$('#data-info-ecommerce-product .menu-left li.active').is(":visible")  ){
			$('#data-info-ecommerce-product .menu-left li:visible a:eq(0)').trigger('click');
 		}


	}


	$(document).on('click','.onoff_input',function(){
		update_hideshow_input();
	});

	$(document).on('change','.select_product_type',function(){
		update_hideshow_input();
	});

	vn4_ajax({
		url: $('#data-info-ecommerce-product').data('url'),
		dataType: 'html',
		callback:function(result){

			let html = $.parseHTML(result);
			$('#data-info-ecommerce-product').empty();
			for (var i = 0; i < html.length; i++) {
				if( html[i].tagName === 'SECTION' ){
					$( html[i].dataset.section ).append( html[i].innerHTML );
				}
			}

	 		if( $('#warper-variable .load-variable-save').length ){

	 			vn4_ajax({
					url: $('.load-variable-save').data('url'),
					dataType: 'html',
					callback:function(result){

						$('#warper-variable').empty();

						let html = $.parseHTML(result);


						for (var i = 0; i < html.length; i++) {
							if( html[i].tagName === 'SECTION' ){
								$( html[i].dataset.section ).append( html[i].innerHTML );
							}
						}

	 					update_view_for_data_product();

	 					udpateNumberPositionRepeater($('#input-repeater-variable'));

	 					_formHasChanged = false;

					}
				});

	 		}else{
	 			update_view_for_data_product();
	 		}

	 		update_hideshow_input();
	 		
	 		 $( ".list-attribute" ).sortable({
		    	 placeholder: "ui-state-highlight",
	    	 	start:function(event,ui){
			   		ui.placeholder.height(ui.item.height() + 10);
			   	},
			   	update: function(event, ui) {
			   		update_variable_product();
                },
		    });
		}
	});


	

	$(document).on('click','.attribute-item .remove',function(){

		$(this).closest('.attribute-item').remove();
		update_variable_product();

	});

	$(document).on('change','input.use_for_variable',function(){
		update_variable_product();
	});


	function update_variable_product(){

		var value = [];

		$('input.use_for_variable:checked').each(function() {
	       value.push($(this).val());
     	});



		var variable_product = [{}];

		var i = 0;
		
		$('input.use_for_variable:checked').each(function(){

			variable_product[i] = {};

			variable_product[i].id = $(this).closest('.info').find('.id_attribute').val();

			variable_attribute = [];

			$(this).closest('.attribute-item').find('.relationship_mm_select .vn4-btn').each(function(){
				// variable_attribute.push({title: $(this).text().replace(/(\r\n|\n|\r)/gm, "").trim(), value: $(this).find('input[type="hidden"]').val() });
				variable_attribute.push($(this).find('input[type="hidden"]').val());
			});

			variable_product[i].variable = variable_attribute;

			i++;
		});


		return variable_product;

		// var table = [];

		// for (var i = 0; i < variable_product.length; i++) {
		// 	table
		// }


	}


	function update_title_variable(){

		setTimeout(function() {
			$('#warper-variable>.input-repeater>.list-input>.repeater-item').each(function(){

				$this = $(this);

				let title = [];

				$this.find('.variable_value').each(function(){
					$(this).removeClass('change_title_item_input_repeater');
					title.push($(this).closest('label').contents().get(0).nodeValue + ': ' + $(this).find('option:selected').text());
				});

				$this.find('>.x_panel>.x_title>h2>.title').text(title.join(' - '));

			});
		}, 10);
	}

	function add_zero(your_number, length) {
	    var num = '' + your_number;
	    while (num.length < length) {
	        num = '0' + num;
	    }
	    return num;
	}

	$(document).on('change','.variable_value',function(){

		let warper = $(this).closest('.choose_attribute_value').find('.variable_value');

		let sku_attributes = '';

		warper.each(function(index, el){
			sku_attributes += $(el).data('sku')+$(el).val();
		});
		console.log(sku_attributes);
		
		update_title_variable();
	});

	$(document).on('click','.add-group-item[data-template="script-template-variable"]',function(){
		update_title_variable();
	});



	$(document).on('click','.load_all_variable_product',function(){

		var variable_product = update_variable_product();

		$this = $(this);

		vn4_ajax({

			url: $(this).data('url'),
			dataType: 'html',
			show_loading: true,
			data:{
				variable_product: variable_product,
			},
			callback:function(result){

			 	try {
			        let message = JSON.parse(result);

			        if( message.message ){
			        	show_message(message.message);
			        }

			    } catch (e) {

			    	let html = $.parseHTML(result);

					$('#warper-variable').empty();

					for (var i = 0; i < html.length; i++) {
						if( html[i].tagName === 'SECTION' ){
							$( html[i].dataset.section ).append( html[i].innerHTML );
						}
					}

					

					if( $('.template-image').length > 1 ){

						let popupImage = $('.template-image');

						popupImage.each(function(i, el){
							if( i != 0 ){
								$(el).remove();
							}
						});
						
					}

					if( $('.modal-wapper-add-file').length > 1 ){

						let popupImage = $('.modal-wapper-add-file');

						popupImage.each(function(i, el){
							if( i != 0 ){
								$(el).remove();
							}
						});
						
					}

					$('#script-template-variable:not(:last-child)').remove();


					if( $this.hasClass('create_all_variable') ){

						let totalVariable = 1;
						console.log(variable_product);

						var matrixVariable = [];

						for (var i = 0; i < variable_product.length; i++) {
							totalVariable *= variable_product[i]['variable'].length;
						}


						let change = 1;

						for (var i = variable_product.length - 1; i >= 0; i--) {

							var attributes = variable_product[i];

							var j = 0;

							var index = 1;

							var numberLap = 1;

							while( j < totalVariable ) {
								
								if( !matrixVariable[j] ) matrixVariable[j] = [];

								matrixVariable[j][i] = attributes['variable'][index - 1];

								if( numberLap == change ){
									index++;
									numberLap = 0;
								}

								numberLap++;
								j++;

								if( index > attributes['variable'].length ){
									index = 1;
								}
							}

							numberLap = change * attributes['variable'].length;
							change = change * attributes['variable'].length;
						}


						for (var i = 0; i < matrixVariable.length; i++) {
							
							var element = $($('#script-template-variable').html());

		                    element.find('textarea.editor-content').attr('id','___change__id__group__input__'+$('textarea.editor-content').length);
		                    element.find(':input:not(.input-trash):first').addClass('change_title_item_input_repeater');


		                    for (var j = 0; j < matrixVariable[i].length; j++) {
		                    	element.find('.variable_value option[value="'+matrixVariable[i][j]+'"]').closest('.variable_value').val(matrixVariable[i][j]);
		                    }


	                    	$('#input-repeater-variable>.list-input').append(element);


	                    	udpateNumberPositionRepeater($('#input-repeater-variable'));

						}
						

						update_title_variable();

					}

			    }


			   
			}

		});

	});

	$(document).on('click','.add_selectAttribute',function(){

		let value = $('#selectAttribute').val();

		if( $('.id_attribute[value="'+value+'"]').length ){
			show_message({content: 'You have already added this property, please select another property',title: 'Error',icon:'fa-times',color: '#CA2121' });
			return;
		}


		vn4_ajax({

			url: $(this).data('url'),
			dataType: 'html',
			data:{
				value: $('#selectAttribute').val()
			},
			callback:function(result){

			    $( ".list-attribute" ).sortable({
			    	 placeholder: "ui-state-highlight",
		    	 	start:function(event,ui){
				   		ui.placeholder.height(ui.item.height() + 10);
				   	},
				   	update: function(event, ui) {
				   		update_variable_product();
	                },
			    });

				$('#ecommerce_product_attribute-content').append(result);

				if( $('.select_product_type').val() == 'variable' ){
		 			$('.use_for_variable').closest('label').show();
		 		}else{
		 			$('.use_for_variable').closest('label').hide();
		 		}

			}
		});

	});
});