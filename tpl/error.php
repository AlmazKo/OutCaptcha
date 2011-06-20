<img src="<?=$pathToImg?>" />
<p class="comment">Ошибка, это не <b>"<?=$answer?>"</b>, <a href="/out/">показать другие картинки</a></p>

<form action="/out/" method="POST">
    <input type="text" name="answer">
    <input type="submit" value="Ответить"/>
</form>