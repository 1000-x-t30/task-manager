<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Shinzo SAITO">
		<title>科目情報編集 | 就職作品プレゼンテーション</title>
		<link rel="stylesheet" href="/css/destyle.css" type="text/css">
    <link rel="stylesheet" href="/css/template.css" type="text/css">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
	</head>
	<body>
		<header>
			<h1>科目情報編集</h1>
			<p><a href="/logout">ログアウト</a></p>
		</header>
		<nav id="breadcrumbs">
			<ul>
				<li><a href="/goTop">TOP</a></li>
				<li><a href="/subject/showSubjectList">科目リスト</a></li>
				<li>科目情報編集</li>
			</ul>
		</nav>
		@isset($validationMsgs)
		<section id="errorMsg">
			<p>以下のメッセージをご確認ください。</p>
			<ul>
				@foreach($validationMsgs as $msg)
				<li>{{$msg}}</li>
				@endforeach
			</ul>
		</section>
		@endisset
		<section>
			<p>情報を入力し、更新ボタンをクリックしてください。</p>
			<form action="/subject/subjectEdit" method="post" class="box">
			@csrf
			科目記号:&nbsp;{{$subject->getMark()}}<br>
			<input type="hidden" name="editMark" value="{{$subject->getMark()}}">
			<label for="editName">
				科目名&nbsp;<span class="required">必須</span>
				<input type="text" id="editName" name="editName" value="{{$subject->getName()}}" required />
			</label><br>
			<button type="submit">更新</button>
			</form>
		</section>
	</body>
</html>