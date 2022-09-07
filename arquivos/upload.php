<?php include_once("../config/conexao.php");
   session_start();  
   $id_user =  $_SESSION['id_user'];
   $conn = mysqli_connect($host, $user, $pass, $db);


   if($_FILES && !empty($_FILES['arquivo']['name'])) {


      //VARS FORMULARIO
         $titulo = utf8_encode($_POST['titulo']);
         $descricao = utf8_encode($_POST['descricao']);
         $regiao = $_POST['regiao'];
         $distrito = $_POST['distrito'];
         $igreja = $_POST['igreja'];
         $categoria = $_POST['categoria'];
         $subcategoria = $_POST['subcategoria'];

      //CRIANDO PASTA DOCS SE NÃO EXISTIR
        $folder = __DIR__ . "/docs";
        if(!file_exists($folder) || !is_dir($folder)) {
           mkdir($folder, 0755);
        }


  
      //DEFININDO VAR FILES
   //   echo(json_encode([$fileUpload = $_FILES["arquivo0"]]) );
   //   echo(json_encode([$fileUpload = $_FILES["arquivo1"]]) );
   }
      
//       //EXTENSÕES PERMITIDAS
      $allowedTypes = [
         "image/jpg",
         "image/jpeg",
         "image/png",
         "image/gif",
         "image/bmp",
         "image/svg+xml",
         "application/pdf",
         "application/zip",
         "application/x-rar-compressed", 
         "image/vnd.adobe.photoshop", 
         "application/msword",
         "application/rtf",
         "text/html",
         "text/plain",
         "application/vnd.ms-excel",
         "application/vnd.ms-powerpoint",
         "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
         "application/vnd.oasis.opendocument.text",
         "application/vnd.oasis.opendocument.spreadsheet",
         "audio/mp3",
         "video/x-flv",
         "audio/x-ms-wmv",
         "video/avi",
         "video/mp4",
         "application/vnd.stardivision.mail",
         "application/vnd.stardivision.chart",
         "application/vnd.stardivision.math",
         "application/vnd.stardivision.impress-packed",
         "application/vnd.stardivision.impress",
         "application/vnd.stardivision.draw",
         "application/vnd.stardivision.calc",
         "application/vnd.stardivision.writer-global",
         "application/vnd.stardivision.writer",
         "application/vnd.sun.xml.math",
         "application/vnd.sun.xml.writer.global",
         "application/vnd.sun.xml.impress.template",
         "application/vnd.sun.xml.impress",
         "application/vnd.sun.xml.draw.template",
         "application/vnd.sun.xml.draw",
         "application/vnd.sun.xml.calc.template",
         "application/vnd.sun.xml.calc",
         "application/vnd.sun.xml.writer.template",
         "application/vnd.sun.xml.writer",
         "application/vnd.openofficeorg.extension",
         "application/vnd.oasis.opendocument.image",
         "application/vnd.oasis.opendocument.database",
         "application/vnd.oasis.opendocument.formula",
         "application/vnd.oasis.opendocument.chart",
         "application/vnd.oasis.opendocument.spreadsheet-template",
         "application/vnd.oasis.opendocument.spreadsheet",
         "application/vnd.oasis.opendocument.presentation-template",
         "application/vnd.oasis.opendocument.presentation",
         "application/vnd.oasis.opendocument.graphics-template",
         "application/vnd.oasis.opendocument.graphics",
         "application/vnd.oasis.opendocument.text-master",
         "application/vnd.oasis.opendocument.text-web",
         "application/vnd.oasis.opendocument.text-template",
         "application/vnd.oasis.opendocument.text",
         "image/x-photo-cd",
         "audio/x-pn-realaudio",
         "application/wordperfect5.1",
         "application/sgml",
         "application/x-dvi",
         "application/x-tex",
         "application/x-latex",
         "application/mathematica",
         "application/vnd.ms-project",
         "audio/x-mpeg",
         "video/quicktime",
         "application/postscript",
         "application/x-photoshop",
         "image/x-ms-bmp",
         "application/x-filemaker",
         "application/vnd.visio",
         "text/richtext",
         "video/mpeg",
         "audio/x-wav",
         "audio/basic",
         "audio/x-aiff",
         "image/tiff",
         "application/marc",
         "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
         "application/vnd.openxmlformats-officedocument.presentationml.presentation"
      ];
    

           
             


      foreach( $_FILES['arquivo'] as $file){
         var_dump($file['type']);
      }

      // die;

      //           for($i=0;$i<$countfiles;$i++){

      //             // try {$newFilename = time() . mb_strstr($_FILES['name'], ".");
      
      //                if(in_array($_FILES['type'], $allowedTypes)) {

      //             $filename = $_FILES['arquivo']['name'][$i];
      //             move_uploaded_file($fileUpload['tmp_name'][$i], __DIR__."/docs/{$newFilename}");
      //             $query = "INSERT INTO arq_arquivos (nome, titulo, descricao, user_id, pae_regiao_id, pae_distrito_id, pae_igreja_id, arq_categoria_id, arq_subcategoria_id, status) VALUES ('$newFilename', '$titulo', '$descricao', '$id_user', '$regiao', '$distrito', '$igreja', '$categoria', '$subcategoria','0')";
      //             echo $query;
                  
      //             mysqli_query($conn, $query); {


      //                echo(json_encode(
      //                   [
      //                      $fileUpload
      //                   ]
      //                ));
      //            }
      //       } }
            
      //    }catch (\Throwable $th) {
      //          echo(json_encode(
      //              [
      //                 "falhou" => "Erro inesperado!"
      //              ]
      //           ));
      //       }




            
            //
            //if() {
                 //// if( else {
                     //echo(json_encode(
                        //[
                          // "falhou" => mysqli_error($conn)
                       // ]
                  //   ));
                 // } }else {
             // 
           // }
            
             
     // } 
   
 

?>