<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Shinzo SAITO" >
		<title>科目情報削除 | 就職作品プレゼンテーション</title>
		<link rel="stylesheet" href="/css/destyle.css" type="text/css">
    <link rel="stylesheet" href="/css/template.css" type="text/css">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
	</head>
	<body>
		<header>
			<h1>部門情報削除</h1>
			<p><a href="/logout">ログアウト</a></p>
		</header>
		<nav id="breadcrumbs">
			<ul>
				<li><a href="/">TOP</a></li>
				<li><a href="/subject/showSubjectList">部門リスト</a></li>
				<li>部門情報削除確認</li>
			</ul>
		</nav>
		<section>
			<p>以下の部門情報を削除します。<br>
			よろしければ、削除ボタンをクリックしてください。
		</p>
		<dl>
			<dt>科目記号</dt>
			<dd>{{$subject->getMark()}}</dd>
			<dt>科目名</dt>
			<dd>{{$subject->getName()}}</dd>
		</dl>
		<form action="/subject/subjectDelete" method="post">
		@csrf
		<input type="hidden" id="deleteMark" name="deleteMark" value="{{$subject->getMark()}}">
		<button type="submit">削除</button>
		</form>
		</section>
	</body>
</html>