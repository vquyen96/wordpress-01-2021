if(jQuery(document).ready(function(e){"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e("#image-conatent-table tbody").sortable({helper:function(a,t){var n=t.children(),i=t.clone();return i.children().each(function(a){e(this).width(n.eq(a).width())}),i},stop:function(e,a){renumberTable("#image-conatent-table")}}),e(".mdwbm_upload_single_file_button").live("click",function(a){var t,n;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!1})).on("select",function(){n=t.state().get("selection").first().toJSON(),e(".cat_banner_single_img_admin").attr("src",n.url),e(".mdwbm_image").attr("value",n.url),e(".cat_banner_single_img_admin").css("display","block")}),t.open())}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".mdwbm_upload_file_button").live("click",function(a){var t,n,i="";a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!0})).on("select",function(){n=t.state().get("selection").toJSON(),e.each(n,function(a,t){var n,_,c,r;i=e.now()+""+a+"-"+t.id,_=e("<td />"),c=e("<td />"),r=e("<td />"),e("<img />",{style:"",class:"wbm_add_cat_banner_img banner_add_cat_image_"+i,src:t.url}).appendTo(_),e("<input />",{type:"hidden",name:"term_meta[images]["+i+"][image_id]",class:"wbm_add_cat_banner_img_admin banner_cat_image_"+i,value:i}).appendTo(c),e("<input />",{type:"text",placeholder:"Enter banner image link",title:"Example: https://multidots.com",name:"term_meta[images]["+i+"][image_link]",class:"wbm_cat_page_cat_banner_link_admin add_category_input_"+i}).appendTo(c),e("<input />",{type:"hidden",name:"term_meta[images]["+i+"][image_url]",value:t.url}).appendTo(c),e("<a />",{class:"cat-single-image-delete single-image-delete",id:i,text:"Delete"}).appendTo(r),n=e("<tr />",{id:"add_category_"+i,class:"add_category_dynamic_div"}),e(_).appendTo(n),e(c).appendTo(n),e(r).appendTo(n),e(n).appendTo("#cat-multiple-banner-image table")})}),t.open())}),e(".wbm_shop_page_single_upload_file_button").live("click",function(a){var t,n;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!1})).on("select",function(){n=t.state().get("selection").first().toJSON(),e(".wbm_shop_page_cat_banner_img_admin_single").attr("src",n.url),e(".wbm_shop_page_cat_banner_img_admin_single").css("display","block")}),t.open())}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_shop_page_multi_upload_file_button").live("click",function(a){var t,n;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!0})).on("select",function(){n=t.state().get("selection").toJSON(),e.each(n,function(a,t){var n,i,_,c,r=(e.now(),t.id);r=e.now()+""+a+"-"+t.id,n=e("<td />"),i=e("<td />"),_=e("<td />"),e("<img />",{class:"wbm_shop_page_cat_banner_img_admin banner_shop_image_"+r,src:t.url}).appendTo(n),e("<input />",{type:"text",placeholder:"Enter banner image link",title:"Example: https://multidots.com",class:"banner_shop_input_"+r}).appendTo(i),e("<a />",{class:"shop-single-image-delete single-image-delete",id:r,text:"Delete"}).appendTo(_),c=e("<tr />",{id:"banner_shop_"+r,class:"banner_shop_dynamic_div ui-sortable-handle"}),e(n).appendTo(c),e(i).appendTo(c),e(_).appendTo(c),e(c).appendTo(".shop_banner_images table")})}),t.open())}),e(".wbm_cart_page_single_upload_file_button").live("click",function(a){var t,n;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!1})).on("select",function(){n=t.state().get("selection").first().toJSON(),e(".wbm_cart_page_cat_banner_img_admin_single").attr("src",n.url),e(".wbm_cart_page_cat_banner_img_admin_single").css("display","block")}),t.open())}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_cart_page_upload_file_button").live("click",function(a){var t,n,i;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!0})).on("select",function(){i=t.state().get("selection").toJSON(),e.each(i,function(a,t){var i,_,c,r;n=e.now()+""+a+"-"+t.id,i=e("<td />"),_=e("<td />"),c=e("<td />"),e("<img />",{class:"wbm_cart_page_cat_banner_img_admin banner_cart_image_"+n,src:t.url}).appendTo(i),e("<input />",{type:"text",placeholder:"Enter banner image link",title:"Example: https://multidots.com",class:"banner_cart_input_"+n}).appendTo(_),e("<a />",{class:"cart-single-image-delete single-image-delete",id:n,text:"Delete"}).appendTo(c),r=e("<tr />",{id:"banner_cart_"+n,class:"banner_cart_dynamic_div"}),e(i).appendTo(r),e(_).appendTo(r),e(c).appendTo(r),e(r).appendTo(".cart_banner_images table")})}),t.open())}),e(".wbm_checkout_page_single_upload_file_button").live("click",function(a){var t,n;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!1})).on("select",function(){n=t.state().get("selection").first().toJSON(),e(".wbm_checkout_page_cat_banner_img_admin_single").attr("src",n.url),e(".wbm_checkout_page_cat_banner_img_admin_single").css("display","block")}),t.open())}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_checkout_page_upload_file_button").live("click",function(a){var t,n,i;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!0})).on("select",function(){n=t.state().get("selection").toJSON(),e.each(n,function(a,t){var n,_,c,r;e.now()+""+a+"-"+t.id,i=e.now()+""+a+"-"+t.id,n=e("<td />"),_=e("<td />"),c=e("<td />"),e("<img />",{class:"wbm_checkout_page_cat_banner_img_admin banner_checkout_image_"+i,src:t.url}).appendTo(n),e("<input />",{type:"text",placeholder:"Enter banner image link",title:"Example: https://multidots.com",class:"banner_checkout_input_"+i}).appendTo(_),e("<a />",{class:"checkout-single-image-delete single-image-delete",id:i,text:"Delete"}).appendTo(c),r=e("<tr />",{id:"banner_checkout_"+i,class:"banner_checkout_dynamic_div ui-sortable-handle"}),e(n).appendTo(r),e(_).appendTo(r),e(c).appendTo(r),e(r).appendTo(".checkout_banner_images table")})}),t.open())}),e(".wbm_thankyou_page_single_upload_file_button").live("click",function(a){var t,n;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!1})).on("select",function(){n=t.state().get("selection").first().toJSON(),e(".wbm_thankyou_page_cat_banner_img_admin_single").attr("src",n.url),e(".wbm_thankyou_page_cat_banner_img_admin_single").css("display","block")}),t.open())}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_thank_you_page_upload_file_button").live("click",function(a){var t,n,i;a.preventDefault(),t?t.open():((t=wp.media.frames.fileFrame=wp.media({title:jQuery(this).data("uploader_title"),button:{text:jQuery(this).data("uploader_button_text")},multiple:!0})).on("select",function(){n=t.state().get("selection").toJSON(),e.each(n,function(a,t){var n,_,c,r;i=e.now()+""+a+"-"+t.id,n=e("<td />"),_=e("<td />"),c=e("<td />"),e("<img />",{class:"wbm_thankyou_page_cat_banner_img_admin banner_thankyou_image_"+i,src:t.url}).appendTo(n),e("<input />",{type:"text",placeholder:"Enter banner image link",title:"Example: https://multidots.com",class:"banner_thankyou_input_"+i}).appendTo(_),e("<a />",{class:"thankyou-single-image-delete single-image-delete",id:i,text:"Delete"}).appendTo(c),r=e("<tr />",{id:"banner_thankyou_"+i,class:"banner_thankyou_dynamic_div"}),e(n).appendTo(r),e(_).appendTo(r),e(c).appendTo(r),e(r).appendTo(".thankyou_banner_images table")})}),t.open())}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".mdwbm_remove_file").live("click",function(a){e(".wbm_add_cat_banner_img_admin").attr("value",""),e(".wbm_cat_page_cat_banner_link_admin").attr("value",""),e(".wbm_add_cat_banner_img_admin").css("display","none"),e(".wbm_cat_page_cat_banner_link_admin").css("display","none"),e(".add_category_dynamic_div").css("display","none")}),e(".wbm_shop_page_remove_single_file").live("click",function(a){e(".wbm_shop_page_cat_banner_img_admin_single").attr("src",""),e(".wbm_shop_page_cat_banner_img_admin_single").css("display","none"),e("#shop_page_banner_single_image_link").attr("value","")}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_shop_page_remove_file").live("click",function(a){e(".wbm_shop_page_cat_banner_img_admin").attr("src",""),e(".wbm_shop_page_cat_banner_img_admin").css("display","none"),e(".banner_shop_dynamic_div").css("display","none")}),e(".wbm_cart_page_remove_single_file").live("click",function(a){e(".wbm_cart_page_cat_banner_img_admin_single").attr("src",""),e(".wbm_cart_page_cat_banner_img_admin_single").css("display","none"),e("#cart_page_banner_single_image_link").attr("value","")}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_cart_page_remove_file").live("click",function(a){e(".wbm_cart_page_cat_banner_img_admin").attr("src",""),e(".wbm_cart_page_cat_banner_img_admin").css("display","none"),e(".banner_cart_dynamic_div").css("display","none")}),e(".wbm_checkout_page_remove_single_file").live("click",function(a){e(".wbm_checkout_page_cat_banner_img_admin_single").attr("src",""),e(".wbm_checkout_page_cat_banner_img_admin_single").css("display","none"),e("#checkout_page_banner_single_image_link").attr("value","")}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_checkout_page_remove_file").live("click",function(a){e(".wbm_checkout_page_cat_banner_img_admin").attr("src",""),e(".wbm_checkout_page_cat_banner_img_admin").css("display","none"),e(".banner_checkout_dynamic_div").css("display","none")}),e(".wbm_thankyou_page_remove_single_file").live("click",function(a){e(".wbm_thankyou_page_cat_banner_img_admin_single").attr("src",""),e(".wbm_thankyou_page_cat_banner_img_admin_single").css("display","none"),e("#thankyou_page_banner_single_image_link").attr("value","")}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||e(".wbm_checkout_page_remove_file").live("click",function(a){e(".wbm_thankyou_page_cat_banner_img_admin").attr("src",""),e(".wbm_thankyou_page_cat_banner_img_admin").css("display","none"),e(".banner_thankyou_dynamic_div").css("display","none")}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||(jQuery("#shop_start_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0",onSelect:function(){var e;(e=jQuery(this).datepicker("getDate")).setDate(e.getDate()+1),jQuery("#shop_end_date").datepicker("option","minDate",e)}}),jQuery("#shop_end_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0"}),jQuery("#cart_start_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0",onSelect:function(){var e;(e=jQuery(this).datepicker("getDate")).setDate(e.getDate()+1),jQuery("#cart_end_date").datepicker("option","minDate",e)}}),jQuery("#cart_end_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0"}),jQuery("#checkout_start_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0",onSelect:function(){var e;(e=jQuery(this).datepicker("getDate")).setDate(e.getDate()+1),jQuery("#checkout_end_date").datepicker("option","minDate",e)}}),jQuery("#checkout_end_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0"}),jQuery("#thankyou_start_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0",onSelect:function(){var e;(e=jQuery(this).datepicker("getDate")).setDate(e.getDate()+1),jQuery("#thankyou_end_date").datepicker("option","minDate",e)}}),jQuery("#thankyou_end_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0"}),jQuery("#cat_banner_start_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0",onSelect:function(){var e;(e=jQuery(this).datepicker("getDate")).setDate(e.getDate()+1),jQuery("#cat_banner_end_date").datepicker("option","minDate",e)}}),jQuery("#cat_banner_end_date").datepicker({dateFormat:"dd-mm-yy",minDate:"0"})),e(".cat-single-image-delete").live("click",function(a){var t;confirm(wbmAdminVars.alert)&&(t=e(this).attr("id"),e(".banner_cat_image_"+t).attr("value",""),e(".banner_cat_image_"+t).css("display","none"),e(".wbm_add_cat_banner_img_"+t).attr("src",""),e(".wbm_add_cat_banner_img_"+t).css("display","none"),e(".add_category_input_"+t).attr("value",""),e(".add_category_input_"+t).css("display","none"),e("#add_category_"+t).css("display","none"),e("#"+t).css("display","none"))}),e(".shop-single-image-delete").live("click",function(a){var t;confirm(wbmAdminVars.alert)&&(t=e(this).attr("id"),e(".banner_shop_image_"+t).attr("src",""),e(".banner_shop_image_"+t).css("display","none"),e(".banner_shop_input_"+t).attr("value",""),e(".banner_shop_input_"+t).css("display","none"),e("#"+t).css("display","none"),e("#banner_shop_"+t).css("display","none"))}),e(".cart-single-image-delete").live("click",function(a){var t;confirm(wbmAdminVars.alert)&&(t=e(this).attr("id"),e(".banner_cart_image_"+t).attr("src",""),e(".banner_cart_image_"+t).css("display","none"),e(".banner_cart_input_"+t).attr("value",""),e(".banner_cart_input_"+t).css("display","none"),e("#"+t).css("display","none"),e("#banner_cart_"+t).css("display","none"))}),e(".checkout-single-image-delete").live("click",function(a){var t;confirm(wbmAdminVars.alert)&&(t=e(this).attr("id"),e(".banner_checkout_image_"+t).attr("src",""),e(".banner_checkout_image_"+t).css("display","none"),e(".banner_checkout_input_"+t).attr("value",""),e(".banner_checkout_input_"+t).css("display","none"),e("#"+t).css("display","none"),e("#banner_checkout_"+t).css("display","none"))}),e(".thankyou-single-image-delete").live("click",function(a){var t;confirm(wbmAdminVars.alert)&&(t=e(this).attr("id"),e(".banner_thankyou_image_"+t).attr("src",""),e(".banner_thankyou_image_"+t).css("display","none"),e(".banner_thankyou_input_"+t).attr("value",""),e(".banner_thankyou_input_"+t).css("display","none"),e("#"+t).css("display","none"),e("#banner_thankyou_"+t).css("display","none"))}),"true"!==wbmAdminVars.can_use_premium_code&&!0!==wbmAdminVars.can_use_premium_code||(e("input[name='term_meta[cat_banner_image_type]']").click(function(){"cat_slider"===e(this).val()?e("#cat-slider-setting").show():e("#cat-slider-setting").hide()}),e("input[name='wbm_shop_setting_enable_random_images']").click(function(){"shop_slider"===e(this).val()?e("#shop-slider-setting").show():e("#shop-slider-setting").hide()}),e("input[name='wbm_cart_setting_enable_random_images']").click(function(){"cart_slider"===e(this).val()?e("#cart-slider-setting").show():e("#cart-slider-setting").hide()}),e("input[name='wbm_checkout_setting_enable_random_images']").click(function(){"checkout_slider"===e(this).val()?e("#checkout-slider-setting").show():e("#checkout-slider-setting").hide()}),e("input[name='wbm_thankyou_setting_enable_random_images']").click(function(){"thankyou_slider"===e(this).val()?e("#thankyou-slider-setting").show():e("#thankyou-slider-setting").hide()}),e("select.cat-select-image-type").change(function(){e("#cat-multiple-banner-type,#cat-multiple-banner-image,#cat-slider-setting,#cat-single-banner-upload,#cat-single-banner-image,#cat-single-image-link").hide(),"cat-multiple-images"==e(this).attr("value")?(e("#cat-multiple-banner-type").show(),e("#cat-multiple-banner-image").show()):(e("#cat-single-banner-upload").show(),e("#cat-single-banner-image").show(),e("#cat-single-image-link").show())}),e("select.shop-select-image-type").change(function(){var a;e("#shop-single-image,#shop-multiple-images").hide(),a=e(this).attr("value"),e("#"+a).show()}),e("select.cart-select-image-type").change(function(){var a;e("#cart-single-image,#cart-multiple-images").hide(),a=e(this).attr("value"),e("#"+a).show()}),e("select.checkout-select-image-type").change(function(){var a;e("#checkout-single-image,#checkout-multiple-images").hide(),a=e(this).attr("value"),e("#"+a).show()}),e("select.thankyou-select-image-type").change(function(){var a;e("#thankyou-single-image,#thankyou-multiple-images").hide(),a=e(this).attr("value"),e("#"+a).show()}))}),"true"===wbmAdminVars.can_use_premium_code||!0===wbmAdminVars.can_use_premium_code)function renumberTable(e){var a;jQuery(e+" tr").each(function(){a=jQuery(this).parent().children().index(jQuery(this))+1,jQuery(this).find(".priority").text(a)})}