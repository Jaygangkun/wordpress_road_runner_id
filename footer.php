					<footer class="footer text-center" role="contentinfo">
						<p class="footer-copyright-text">©2021 ROAD RUNNER ID. All Rights Reserved. By C2 Digital.</p>
				
					</footer> <!-- end footer -->
				</div><!-- page-content -->
			</div><!-- page-content-container -->
		
		</div> <!-- end #container -->
		
		<!-- all js scripts are loaded in library/primer.php -->
		<?php wp_footer(); ?>
		
		<!-- Bootstrap JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
		<script src="<?php echo get_stylesheet_directory_uri() . '/library/js/libs/bootstrap-datetimepicker.min.js'?>"></script>
		<script>
		  jQuery(document).ready(function() {
			  jQuery(document).on('click', '#header_nav_logout', function() {
				jQuery.ajax({
					url: wp_admin_url,
					type: 'post',
					data: {
						action: 'logout'
					},
					dataType: 'json',
					success: function(resp) {
						if(resp.logout) {
							document.location.href = logout_redirecturl;
						}
					}
				})
			  })
		  })
		</script>
	</body>

</html> <!-- end page. what a ride! -->
