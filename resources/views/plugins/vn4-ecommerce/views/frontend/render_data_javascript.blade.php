
<?php
    $productDetail = get_product_detail($post);
?>

<script type="text/javascript">
    window.addEventListener('load',function(){

        window.__ecommerce_post_detail = {!!$productDetail!!};
        window.__ecommerce_product = {!!$post!!};

        window.__ecommerce_config = {
            class_attribute_selected: 'product-attribute--selected',
            class_attribute_disabled: 'product-variation--disabled',
            selector_message_stock: '.product-attribute__stock',
            message_in_stock: '<span style="color:green;"> {quantity} sản phẩm có sẵn</span>',
            message_status_in_stock: '<span style="color:green;"> Sản phẩm có sẵn</span>',
            message_status_out_stock: '<span style="color:red;"> Đã hết hàng</span>',
            message_out_stock: '<span style="color:red;">Đã hết hàng</span>',
            message_not_variation: '<span style="color:red;">Phiên bản này không tồn tại</span>',
            selector_input_quantity: '.input-quantity',
            selector_button_up_quantity: '.vn4cms-input-quantity .btn-up',
            selector_button_down_quantity: '.vn4cms-input-quantity .btn-down',
            elementHtml_price: document.body.querySelector('.product-attribute__price'),
            elementHtml_compare_price: document.body.querySelector('.product-attribute__price--compare'),
            currency_symbol:'$',
            position_of_currency_symbol: true, //true: before; false: after 
            message_not_update_price: '(not update)',
        };

        window.__ecommerce_post_detail.flag = {};
        window.__ecommerce_post_detail.flag = {
            count_attribute: 0,
        };

        __ecommerce_post_detail.variations = JSON.parse( __ecommerce_post_detail.variations );
        

        let KeyDelete = Object.keys( __ecommerce_post_detail.variations ).filter( key => __ecommerce_post_detail.variations[key].delete );

        __ecommerce_post_detail.variationsDevoid = KeyDelete.map( key => __ecommerce_post_detail.variations[key] );
        
        __ecommerce_post_detail.variations = Object.keys( __ecommerce_post_detail.variations )
                                            .filter( key => !__ecommerce_post_detail.variations[key].delete )
                                            .map( key => __ecommerce_post_detail.variations[key] );
        let variable_attribute = [];


        for (let i in __ecommerce_post_detail.variations) {

            for( let index in __ecommerce_post_detail.variations[i].attributes ){

                let name_attribute = __ecommerce_post_detail.variations[i].attributes[index].id;
                let idAttribute = __ecommerce_post_detail.variations[i].attributes[index].ecom_prod_attr;
                
                if( !variable_attribute[idAttribute] ) variable_attribute[idAttribute] = [];
                if( !variable_attribute[idAttribute][ name_attribute ] ) variable_attribute[idAttribute][ name_attribute ] = [];

                for( let index2 in __ecommerce_post_detail.variations[i].attributes ){

                    let idAttribute2 = __ecommerce_post_detail.variations[i].attributes[index2].ecom_prod_attr;
                    
                    if( idAttribute != idAttribute2 ){

                        let attribute_value_id = __ecommerce_post_detail.variations[i].attributes[index2].id;

                        if( !variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ] ) variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ] = [];

                        if(  variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ].indexOf( attribute_value_id ) == -1 ){
                             variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ].push(attribute_value_id);
                        }
                    }
                }
            }
        }

        String.prototype.replaceArray = function(find, replace) {
          var replaceString = this;
          var regex; 
          for (var i = 0; i < find.length; i++) {
            regex = new RegExp(find[i], "g");
            replaceString = replaceString.replace(regex, replace[i]);
          }
          return replaceString;
        };

        window.__ecommerce_post_detail.flag.count_attribute = Object.keys(variable_attribute).length;

        document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_in_stock.replaceArray(['{quantity}'],[__ecommerce_product.quantity]);

        function ecommerce_get_price(price){
            if( __ecommerce_config.position_of_currency_symbol ){
                return __ecommerce_config.currency_symbol+(new Intl.NumberFormat().format(price));
            }else{
                return (new Intl.NumberFormat().format(price)) +__ecommerce_config.currency_symbol;
            }
        } 

        function change_attribute(){

            if( this.classList.contains( __ecommerce_config.class_attribute_disabled ) ) return;
            
            this.classList.add('__clicked');

            let value = this.attributes.value.value*1,
                parent = this.closest('.list-attribute-value'),
                attibute_id = parent.dataset.id,
                attribute_chose = parent.attributes['data-id'].value*1,
                product_attribute = parent.closest('.product_attribute'),
                product_attribute_value = product_attribute.querySelectorAll('.list-attribute-value'),
                list_attribute_active = [],
                list_attribute_not_active = [],
                list_detail_after_choose = [],
                list_attribute_can_choose = [],
                list_attribute_not_disable = [];

            parent.querySelectorAll('.attribute-value.'+__ecommerce_config.class_attribute_selected+':not(.__clicked)').forEach( (el, index) => {
                el.classList.remove( __ecommerce_config.class_attribute_selected);
            });

            this.classList.toggle( __ecommerce_config.class_attribute_selected );
            this.classList.remove('__clicked'); 

            let active = this.classList.contains( __ecommerce_config.class_attribute_selected );

            product_attribute_value.forEach( (el, index) => {
                let product_attribute_value_active = el.querySelector('.attribute-value.'+__ecommerce_config.class_attribute_selected);
                
                if( product_attribute_value_active ){
                    list_attribute_active.push({'id': el.attributes['data-id'].value,
                        title:  product_attribute_value_active.attributes.title.value, 
                        value: product_attribute_value_active.attributes.value.value });
                }
            });
           
            for( let i in __ecommerce_post_detail.variations ){

                let variable = __ecommerce_post_detail.variations[i];

                let dk = true;

                for ( let attribute of list_attribute_active ){

                    if(  variable.attributes.filter( item => item.ecom_prod_attr*1 === attribute.id*1 && item.id*1 === attribute.value*1).length < 1 ){
                        dk = false;
                        break;
                    }
                }

                if( dk ){
                    list_detail_after_choose.push(variable);
                }
            }

            product_attribute.querySelectorAll('.attribute-value').forEach( (el, index)=>{
                el.classList.remove(__ecommerce_config.class_attribute_disabled);
            });

            product_attribute_value.forEach( attribute => {

                attribute.querySelectorAll( '.attribute-value ').forEach( valueElement => {

                    let searchRegex = [];

                    product_attribute_value.forEach( attribute2 => {

                        if( attribute.dataset.id !== attribute2.dataset.id ){
                            let actived = attribute2.querySelector('.attribute-value.'+__ecommerce_config.class_attribute_selected);
                            
                            if( actived ){
                                searchRegex.push( actived.attributes.value.value );
                            }else{
                                searchRegex.push( '((\\d)*)' );
                            }
                        }else{
                            searchRegex.push(  valueElement.attributes.value.value );
                        }

                    });

                    
                    let regex = new RegExp ( searchRegex.join('_'), 'i');

                    let variations = __ecommerce_post_detail.variations.filter( item => {
                        return item.key.match( regex ) && (
                            item.warehouse_manage_stock || 
                            (
                                !item.warehouse_manage_stock && item.stock_status !== 'outofstock'
                            )
                        );
                    });

                    if( variations.length < 1 ){
                        valueElement.classList.add(__ecommerce_config.class_attribute_disabled);
                    }
                    
                });
            });

            document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = '';

            if( list_attribute_active.length == window.__ecommerce_post_detail.flag.count_attribute){
                
                if( list_detail_after_choose.length == 1){

                    window.__ecommerce_post_detail.variable_current = list_detail_after_choose[0];

                    if( list_detail_after_choose[0].warehouse_manage_stock ){

                        if( parseInt( list_detail_after_choose[0].warehouse_quantity ) > 0 ){

                            let quantity = parseInt( list_detail_after_choose[0].warehouse_quantity );

                            document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_in_stock.replaceArray(['{quantity}'],[quantity]);

                            let input_quantity = document.body.querySelector( window.__ecommerce_config.selector_input_quantity );

                            if( input_quantity.value > quantity ){
                                input_quantity.value = quantity;
                            }


                        }else{
                            document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_out_stock;
                        }
                    }else{

                        if( list_detail_after_choose[0].stock_status !== 'outofstock' ){
                            document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_status_in_stock;
                        }else{
                            document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_status_out_stock;
                        }
                    }


                    if( __ecommerce_config.elementHtml_price && __ecommerce_config.elementHtml_compare_price ){

                        if( __ecommerce_post_detail.variable_current.compare_price ){
                            __ecommerce_config.elementHtml_price.innerText =  ecommerce_get_price(__ecommerce_post_detail.variable_current.price);
                            __ecommerce_config.elementHtml_compare_price.innerText = ecommerce_get_price(__ecommerce_post_detail.variable_current.compare_price);
                        }else{

                            if( __ecommerce_post_detail.variable_current.price ){
                                __ecommerce_config.elementHtml_price.innerText = ecommerce_get_price(__ecommerce_post_detail.variable_current.price);
                                __ecommerce_config.elementHtml_compare_price.innerText = '';
                            }else{
                                __ecommerce_config.elementHtml_price.innerText = __ecommerce_config.message_not_update_price;
                                __ecommerce_config.elementHtml_compare_price.innerText = '';
                            }
                        }
                    }
                }else{
                     window.__ecommerce_post_detail.variable_current = false;
                     document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_not_variation;
                }
            }else{
                let quantity = parseInt(__ecommerce_product.quantity);

                document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_in_stock.replaceArray(['{quantity}'],[quantity]);

                let input_quantity = document.body.querySelector( window.__ecommerce_config.selector_input_quantity );

                if( input_quantity.value > quantity ){
                    input_quantity.value = quantity;
                }
            }
        }

        document.querySelectorAll('.attribute-value').forEach( element => {
            element.addEventListener('click', change_attribute);
        });

        document.body.querySelector( __ecommerce_config.selector_button_down_quantity ).addEventListener('click',function(){
            let input = document.body.querySelector( window.__ecommerce_config.selector_input_quantity );
            if( input.value < 2){
                input.value = 1;
            }else{
                input.value--;
            }
        });

        document.body.querySelector( __ecommerce_config.selector_button_up_quantity ).addEventListener('click',function(){
            let input = document.body.querySelector( window.__ecommerce_config.selector_input_quantity );

            if( window.__ecommerce_post_detail.variable_current && input.value >= window.__ecommerce_post_detail.variable_current.stock*1 ){
                input.value = window.__ecommerce_post_detail.variable_current.stock*1;
            }else{
                input.value++;
            }
        });
        
    });

</script>