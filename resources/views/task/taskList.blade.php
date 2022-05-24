<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="1000">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>課題情報リスト | 就職作品プレゼンテーション</title>
        <link rel="stylesheet" href="/css/destyle.css" type="text/css">
        <link rel="stylesheet" href="/css/template.css" type="text/css">
        <link rel="stylesheet" href="/css/style.css" type="text/css">
    </head>
    <body>
        <header>
            <h1>課題リスト</h1>
            <p><a href="/logout">ログアウト</a></p>
        </header>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/goTop">TOP</a></li>
                <li>課題情報リスト</li>
            </ul>
        </nav>
        @if(session('flashMsg'))
        <section id="flashMsg">
            <p>{{ session('flashMsg') }}</p>
        </section>
        @endif
        <section>
            <p>課題登録は<a href="/task/goTaskAdd">こちら</a>から</p>
        </section>
        <section>
            <table>
                <thead>
                    <tr>
                        <th>課題ID</th>
                        <th>科目記号</th>
                        <th>課題名</th>
                        <th>課題番号</th>
                        <th>詳細内容</th>
                        <th>提出期限</th>
                        <th colspan="2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($taskList as $id => $task)
                    <tr class="{{ ($task->getLimit() && $task->getLimit() < date('Y-m-d', strtotime('today')) ) ? 'finished' : '' }}">
                        <td>{{ $id }}</td>
                        <td>{{ $task->getMark() }}</td>
                        <td>{{ $task->getName() }}</td>
                        <td>{{ $task->getTaskNo() }}</td>
                        <td>{{ $task->getDescription() }}</td>
                        <td>{{ $task->getLimit() }}</td>
                        <td><a href="/task/prepareTaskEdit/{{ $id }}">編集</a></td>
                        <td><a href="/task/confirmTaskDelete/{{ $id }}">削除</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">該当従業員は存在しません。</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </body>
</html>