
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>課題情報削除 | 就職作品プレゼンテーション</title>
        <link rel="stylesheet" href="/css/destyle.css" type="text/css">
        <link rel="stylesheet" href="/css/template.css" type="text/css">
        <link rel="stylesheet" href="/css/style.css" type="text/css">
    </head>
    <body>
        <header>
            <h1>課題情報削除</h1>
            <p><a href="/logout">ログアウト</a></p>
        </header>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/goTop">TOP</a></li>
                <li><a href="/task/showTaskList">課題リスト</a></li>
                <li>課題情報削除確認</li>
            </ul>
        </nav>
        <section>
            <p>
                以下の課題情報を削除します。<br>
                よろしければ、削除ボタンをクリックしてください。
            </p>
            <dl>
                <dt>課題ID</dt>
                <dd>{{ $task->getId() }}</dd>
                <dt>科目記号</dt>
                <dd>{{ $task->getMark() }}</dd>
                <dt>課題名</dt>
                <dd>{{ $task->getName() }}</dd>
                <dt>課題番号</dt>
                <dd>{{ $task->getTaskNo() }}</dd>
                <dt>詳細内容</dt>
                <dd>{{ $task->getDescription() }}</dd>
                <dt>提出期限</dt>
                <dd>{{ $task->getLimit() }}</dd>
            </dl>
            <form action="/task/taskDelete" method="post">
                @csrf
                <input type="hidden" id="deleteId" name="deleteId" value="{{ $task->getId() }}">
                <button type="submit">削除</button>
            </form>
        </section>
    </body>
</html>