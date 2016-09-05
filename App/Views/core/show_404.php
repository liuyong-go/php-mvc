<?php echo views('common/header')?>
	<div class="container-fluid content">
		<div class="row">
				<div id="content" class="col-sm-12 full">
			
			<div class="row box-error">
				
				<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
				
				<h1>404</h1>
				<h2>你查找的页面不存在</h2>
				<p>2秒钟后跳转到首页</p>
				
				</div><!--/col-->
				
			</div><!--/row-->
		
		</div><!--/content-->	
			
				</div><!--/row-->		
		
	</div><!--/container-->

<?php echo views('common/footer')?>
<script type="text/javascript">
	timeToUrl('/index',2000);
</script>
