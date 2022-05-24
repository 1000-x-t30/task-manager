<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>課題情報編集 | 就職作品プレゼンテーション</title>
    <link rel="stylesheet" href="/css/destyle.css" type="text/css">
    <link rel="stylesheet" href="/css/template.css" type="text/css">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
  </head>
  <body>
    <header>
      <h1>部門情報編集</h1>
      <p><a href="/logout">ログアウト</a></p>
  </header>
    <nav id="breadcrumbs">
      <ul>
        <li><a href="/goTop">TOP</a></li>
        <li><a href="/task/showTaskList">課題リスト</a></li>
        <li>部門情報編集</li>
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
      <p>情報を入力し、更新ボタンをクリックしてください。</p>
      <form action="/task/taskEdit" method="post" class="box">
        @csrf
        <label for="editId">
          課題ID:&nbsp;{{ $task->getId() }}<br>
          <input type="hidden" name="editId" value="{{ $task->getId() }}">
        </label>
        <label for="addMark">
          科目記号&nbsp;<span class="required">必須</span>
          <select name="editMark" required>
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
        <label for="editName">
          課題名&nbsp;<span class="required">必須</span>
          <input type="text" id="editName" name="editName" value="{{ $task->getName() }}" required/>
        </label><br>
        <label for="editTaskNo">
          課題番号&nbsp;<span class="required">必須</span>
          <input type="number" min="1" max="99" id="editTaskNo" name="editTaskNo" value="{{ $task->getTaskNo() }}" required/>
        </label><br>
        <label for="editDescription">
          課題内容&nbsp;
          <textarea name="editDescription" id="editDescription" cols="30" rows="10">{{ $task->getDescription() }}</textarea>
        </label><br>
        <label for="editLimit">
          提出期限&nbsp;<span class="required">必須</span>
          <input type="date" id="editLimit" name="editLimit" value="{{ $task->getLimit() }}" required/>
        </label><br>
        <button type="submit">更新</button>
      </form>
    </section>
  </body>
</html>