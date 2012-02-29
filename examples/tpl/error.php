<img src="<?=$pathToImg?>" />
<p class="comment">Error. It is not <b>"<?=$answer?>"</b>. <a href="/out/">Show is other pictures</a></p>

<form action="/out/" method="POST">
    <input type="text" name="answer">
    <input type="submit" value="Answer"/>
</form>