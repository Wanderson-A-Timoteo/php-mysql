<?php
	error_reporting(0);
    include_once("../classes/manipulacaoDeDados.php");
    include_once("../biblio.php");

    $acao = $_POST["acao"];
    $id	  = $_POST["id"];


    $cad = new manipulacaoDeDados();
    $cad->setTabela("produto");
	
	
	$txt_id_categoria		= $_POST["txt_id_categoria"];
	$txt_titulo				= $_POST["txt_titulo"];	 
	$txt_preco				= $_POST["txt_preco"];
	$txt_ativo				= $_POST["txt_ativo"];
	$txt_fabricante			= $_POST["txt_fabricante"];
	$txt_modelo				= $_POST["txt_modelo"];	
	$txt_slug_produto		= gen_slug($txt_titulo);	                    
	

	
	
	$txt_descricao			= htmlentities($_POST["txt_desc"], ENT_QUOTES);	
	$txt_conteudo			= htmlentities($_POST["txt_conteudo"],ENT_QUOTES);
	
	$txt_nomeimagem = $_POST["nome_imagem"];
    
    
	/***************************UPLOAD************************/

	$extensoes_validas = array(".gif", ".png",".jpg",".jpeg");
	$caminho_absoluto  = "C:/xampp/htdocs/php-mysql/admin/fotos";
	
	$nome_arquivo 		= $_FILES['img']['name'];
	$arquivo_temporario = $_FILES['img']['tmp_name'];
	
	$ext = strrchr($nome_arquivo,'.');

	

	//$nome_arquivo =md5(uniqid(rand(),true)) .$ext;
	
	if(!empty($nome_arquivo)){
		if(!in_array($ext,$extensoes_validas)){
			die("Este arquivo com estas extensão não é válido");
		}else{
		if(move_uploaded_file($arquivo_temporario,"$caminho_absoluto/$nome_arquivo")){
			$txt_nomeimagem = $nome_arquivo	;
			echo "nome = " .$txt_nomeimagem;
		}else {
			die("Erro no envio do arquivo");
		}
	}
	}
	/***************************UPLOAD************************/
	


	if($acao=="Inserir"){
		$cad ->setCampos("id_categoria, titulo_produto, preco, fabricante, modelo, descricao, conteudo, slug_produto, ativo_produto, imagem_produto");
		$cad ->setDados("'$txt_id_categoria', '$txt_titulo', '$txt_preco', '$txt_fabricante', '$txt_modelo', '$txt_descricao', '$txt_conteudo', '$txt_slug_produto', '$txt_ativo','$txt_nomeimagem'");
		$cad-> inserir();
		
		echo "<script type='text/javascript'> location.href='../index.php?link=6' </script> ";
	}
	
	if($acao=="Alterar"){
		$cad ->setCampos("	id_categoria		='$txt_id_categoria', 
							titulo_produto		='$txt_titulo', 
							preco 			 	='$txt_preco',
							fabricante          ='$txt_fabricante',
							modelo              ='$txt_modelo',
							descricao           ='$txt_descricao',
							conteudo 	        ='$txt_conteudo',
							slug_produto        ='$txt_slug_produto',
							ativo_produto       ='$txt_ativo',
							imagem_produto      ='$txt_nomeimagem'");
		$cad->setValorNaTabela("id_produto");
		$cad->setValorPesquisa("$id");
		$cad->alterar();
		
		echo "<script type='text/javascript'> location.href='../index.php?link=6' </script> ";
	}
	
	if($acao=="Excluir"){
		
		$cad->setValorNaTabela("id_produto");
		$cad->setValorPesquisa("$id");
		$cad->excluir();
		
		echo "<script type='text/javascript'> location.href='../index.php?link=6' </script> ";
	}
?>