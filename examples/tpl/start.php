<p>What is there in the picture?</p>
<img src="<? echo $webPath?>" />
<p><a href="<? echo $addr?>">Show the other pictures</a></p>
<form action="<? echo $addr?>" method="POST">
    <input type="text" name="answer">
    <input type="submit" value="Answer"/>
</form>