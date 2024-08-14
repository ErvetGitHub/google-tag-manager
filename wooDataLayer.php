<?php
/*
- See on Google Tag Manager Woocommerce "purchase" event registreerimise jaoks vajalik dataLayaer
- See tuleks lisada näiteks thank-you.php lehe alumisse osasse või muul võimalusel nii, et see script 
käivitub peale ostu sooritamist. Siis saadab see script info Google Tag Manager-i.


*/
?>
<script >
	// WOOCOMMERCE DATALAYER
dataLayer.push({
  'event': 'purchase',
  'ecommerce': {
	'purchase': {
	'transaction_id': '<?php echo $order->get_order_number(); ?>',
	'affiliation': '<?php echo get_option("blogname"); ?>',
	'value': '<?php echo number_format($order->get_subtotal(), 2, ".", ""); ?>',
	'tax': '<?php echo number_format($order->get_total_tax(), 2 ,".", ""); ?>',
	'shipping': '<?php echo number_format($order->calculate_shipping(), 2 , ".", ""); ?>',
	'currency': 'EUR',
	<?php if($order->get_used_coupons()) : ?>
	'coupon': '<?php echo implode("-", $order->get_used_coupons()); ?>',
	<?php endif; ?>
	'items': [
			// LOOP ALGAB SIIT => EEMALDA SEE TEKST PEALE KOODI TÖÖKORDA SAAMIST
		<?php
				foreach ( $order->get_items() as $key => $item ) :
				$product = $order->get_product_from_item($item);
				$variant_name = ($item['variation_id']) ? wc_get_product($item['variation_id']) : '';
			?>
			{
			'item_name': '<?php echo $item['name']; ?>',
			'item_id': '<?php echo $item['product_id']; ?>',
			'item_price': '<?php echo number_format($order->get_line_subtotal($item), 2, ".", ""); ?>',
			'item_brand': '',
			'item_category': '<?php echo strip_tags($product->get_categories(', ', '', '')); ?>',
			'item_variant': '<?php echo ($variant_name) ? implode("-" , $variant_name->get_variation_attributes()) : ''; ?>',
			'quantity': <?php echo $item['qty']; ?>,
			'item_coupon': ''
		},
		<?php endforeach; ?>
		]
	}
  } 
});
</script>