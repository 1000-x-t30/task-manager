<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>課題情報追加 | 就職作品プレゼンテーション</title>
    <link rel="stylesheet" href="/css/destyle.css" type="text/css">
    <link rel="stylesheet" href="/css/template.css" type="text/css">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
</head>
<body>
    <header>
        <h1>従業員情報追加</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
        <nav id="breadcrumbs">
			<ul>
				<li><a href="/goTop">TOP</a></li>
				<li><a href="/task/showTaskList">課題リスト</a></li>
				<li>課題情報追加</li>
			</ul>
		</nav>
        @isset($validationMsgs)
		<section id="errorMsg">
			<p>以下のメッセージをご確認ください。</p>
			<ul>
				@foreach($validationMsgs as $msg)
				<li>{{ $msg }}</li>
				@endforeach
			</ul>
		</section>
		@endisset
		<section>
            <p>情報を入力し、登録ボタンをクリックしてください。</p>
            <form action="/task/taskAdd" method="post" class="box">
                @csrf
                <label for="addMark">
                    科目記号&nbsp;<span class="required">必須</span>
                    <select name="addMark" required>
                        <option value="">--</option>
                        @foreach($subjectAll as $subject)
                        <option
                            value="{{ $subject->getMark() }}"
                            {{ ($task->getMark() && $task->getMark() == $subject->getMark()) ? 'selected' : '' }}
                        >
                            {{ $subject->getMark() }}: {{ $subject->getName() }}
                        </option>
                        @endforeach
                    </select>
                </label><br>
                <label for="addName">
                    課題名&nbsp;<span class="required">必須</span>
                    <input type="text" min="1" max="30" id="addName" name="addName" value="{{ $task->getName() }}" required/>
                </label><br>
                <label for="addTaskNo">
                    課題番号&nbsp;<span class="required">必須</span>
                    <input type="number" min="1" max="99" id="addTaskNo" name="addTaskNo" value="{{ $task->getTaskNo() }}" required/>
                </label><br>
                <label for="addDescription">
                    課題内容&nbsp;
                    <textarea name="addDescription" id="addDescription" cols="30" rows="10">{{ $task->getDescription() }}</textarea>
                </label><br>
                <label for="addLimit">
                    提出期限&nbsp;<span class="required">必須</span>
                    <input type="date" id="addLimit" name="addLimit" value="{{ $task->getLimit() }}" required/>
                </label><br>
                <button type="submit">登録</button>
            </form>
        </section>
    </body>
</html>