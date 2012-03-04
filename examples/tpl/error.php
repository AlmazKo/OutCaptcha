<img src="<? echo $pathToImg?>" />
<p class="comment">Error. It is not <b>"<? echo $answer?>"</b>. <a href="/out/">Show is other pictures</a></p>

<form action="<? echo $addr?>" method="POST">
    <input type="text" name="answer">
    <input type="submit" value="Answer"/>
</form>