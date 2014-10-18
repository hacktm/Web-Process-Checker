    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
	
	<script>
		Morris.Bar({
		  element: 'chart',
		  data: [
			{ y: '<?php echo date('H:m',strtotime($process['date'])); ?>', ram: '<?php echo SizeSuffix($process['ram']); ?>', peak: '<?php echo SizeSuffix($process['peak']); ?>' }
		  ],
		  xkey: 'y',
		  ykeys: ['ram', 'peak'],
		  labels: ['RAM', 'Peak']
		});
	</script>

    <!-- Custom Theme JavaScript -->
    <script src="js/script.js"></script>

</body>

</html>