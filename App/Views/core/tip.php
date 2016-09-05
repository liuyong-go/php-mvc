<?php echo views('common/header')?>
	<div class="container-fluid content">
		<div class="row">
				<div id="content" class="col-sm-12 full">
			
			<div class="row box-error">
				
				<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
				
				<h1>Tip</h1>
				<h2><?php echo $message?></h2>
				<p>2秒钟后跳转到指定页,<a href="<?php echo $url ? $url : '/index';?>">点击这里</a>,直接跳转</p>
				
				</div><!--/col-->
				
			</div><!--/row-->
		
		</div><!--/content-->	
			
				</div><!--/row-->		
		
	</div><!--/container-->
<script type="text/javascript">
	timeToUrl('<?php echo $url ? $url : '/index';?>',2000);
</script>
<?php echo views('common/footer')?>
