<?php 
	include './includes/inc.php';
 	if($mod){
 		if(file_exists('view/huzan/'.$mod.'.php')){
			include 'view/huzan/'.$mod.'.php';
		}else{
			exit('<script>alert("功能未启用");location="/";</script>');
		}
 	}else{
 		include 'view/huzan/index.php';	
 	}
 ?> 
 </div>
</div>
<style>
body {
    width:100%;
    max-width:380px;
    margin-left: auto;
    margin-right: auto;
}
</style>
</body>
</html>