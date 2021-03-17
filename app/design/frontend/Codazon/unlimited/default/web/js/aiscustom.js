require(["Magento_Theme/js/theme"], function(){
	
	jQuery(document).ready(function(){
	 jQuery('.cnt-btn').click(function(){
		 
		var lb = jQuery(this).attr('deci');
		var t = jQuery(this).attr('id');
		var res = t.split("-");
		var v = jQuery(this).closest("div.product-item-info").find("."+t).text();
		vs = parseInt(v);
		jQuery('#imgd_'+res[1]).css('display','block');
		var sqty = jQuery(this).closest("div.product-item-info").find(".product-qty-"+res[1]+" option:selected").text();
		var psqty = parseFloat(sqty);
		var tot = vs+psqty; 
		var dspl= jQuery(this).closest("div.product-item-info").find("."+t);
		if(lb==1){ var lbtxt = 'lb';}
		else{ var lbtxt = ''; }
		var cntcrt = tot+" "+lbtxt;
		setTimeout(
		function(){
		dspl.text(cntcrt);
		jQuery('#imgd_'+res[1]).css('display','none');
 },1000);
		
		
  });	  	
});
	
});
