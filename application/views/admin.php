<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>¿Quién compró? Plataforma web de información sobre el uso del dinero público en el Congreso de México</title>
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
strong { font-size:16px; }
.link { cursor:pointer; color:blue; font-size:14px; }
#catalogos { display:none; padding:0;}
</style>
</head>
<body>
	<div>
		<a href="<?php echo site_url('admin/facturas')?>">
			<?php if($this->uri->segment(2) == "facturas") { ?><strong>Facturas</strong><?php } else { ?>Facturas<?php } ?>
		</a> |
		<a href="<?php echo site_url('admin/solicitudes')?>">
			<?php if($this->uri->segment(2) == "solicitudes") { ?><strong>Solicitudes</strong><?php } else { ?>Solicitudes<?php } ?>
		</a> |
		
		<?php if(isset($_SESSION['user_id'])) { ?>
			<a href="<?php echo site_url('admin/logout')?>">Cerrar sesión</a> | 
		<?php } ?>
		
		<span class="link" id="ver-catalogos">Mostrar/Ocultar Catalogos</span>
		
		<span id="catalogos" class="hide">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="<?php echo site_url('admin/conceptos')?>">
				<?php if($this->uri->segment(2) == "conceptos") { ?><strong>Conceptos</strong><?php } else { ?>Conceptos<?php } ?>
			</a> |
			<a href="<?php echo site_url('admin/legisladores')?>">
				<?php if($this->uri->segment(2) == "legisladores") { ?><strong>Legisladores</strong><?php } else { ?>Legisladores<?php } ?>
			</a>
		</span>
	</div>
	
	
		
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
    <script type="text/javascript">
		$(document).ready( function () {
			$("#ver-catalogos").click( function () {
				$("#catalogos").toggle();
			});
		});
    </script>
</body>
</html>
