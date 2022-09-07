Simple-Lightbox-Video-jQuery
============================

Lightbox simples para vídeos usando jQuery

<h2>Como instalar</h2>

Adicione o arquivo CSS no head do html

```html
<head>
	<title>Lightbox</title>
	<link rel="stylesheet" type="text/css" href="css/lightbox.min.css">
</head>
```

Após isso adicione a biblioteca jQuery e o arquivo JS também no head do html

```html
<head>
	<title>Lightbox</title>
	<link rel="stylesheet" type="text/css" href="css/lightbox.min.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/lightbox.min.js"></script>
</head>
```

Agora faça a chamada do método no final do html

```html
	<script type="text/javascript">
		$('.video').simpleLightboxVideo();
	</script>
</body>
```

<table style="width:100%;">
	<thead>
		<tr>
			<th>ATRIBUTO</th>
			<th>DESCRIÇÃO</th>
			<th>VALOR</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>data-videoid</td>
			<td>Atributo contendo o id do vídeo</td>
			<td>ID do vídeo</td>
		</tr>
		<tr>
			<td>data-videosite</td>
			<td>Atributo contendo o site que contém o vídeo</td>
			<td>youtube, vimeo</td>
		</tr>
	</tbody>
</table>