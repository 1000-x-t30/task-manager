<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="1000">
		<title>科目情報リスト | 就職作品プレゼンテーション</title>
		<link rel="stylesheet" href="/css/destyle.css" type="text/css">
		<link rel="stylesheet" href="/css/template.css" type="text/css">
		<link rel="stylesheet" href="/css/style.css" type="text/css">
	</head>
	<body>
		<header>
			<h1>科目リスト</h1>
			<p><a href="/logout">ログアウト</a></p>
		</header>
		<nav id="breadcrumbs">
			<ul>
				<li><a href="/goTop">TOP</a></li>
				<li>科目情報リスト</li>
			</ul>
		</nav>
		@if(session("flashMsg"))
		<section id="flashMsg">
			<p>{{session("flashMsg")}}</p>
		</section>
		@endif
		<section>
			<p>科目登録は<a href="/subject/goSubjectAdd">こちら</a>から</p>
		</section>
		<section>
			<table>
				<thead>
					<tr>
						<th>科目記号</th>
						<th>科目名</th>
						<th colspan="2">操作</th>
					</tr>
				</thead>
				<tbody>
					@forelse($subjectList as $mark => $subject)
					<tr>
						<td>{{$mark}}</td>
						<td>{{$subject->getName()}}</td>
						<td>
							<a href="/subject/prepareSubjectEdit/{{$mark}}">編集</a>
						</td>
						<td>
							<a href="/subject/confirmSubjectDelete/{{$mark}}">削除</a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="5">該当科目は存在しません。</td>
					</tr>
					@endforelse
				</tbody>
			</table>
			</section>
		</body>
	</html>