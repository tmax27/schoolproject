<div class="menu">
    <?php $result = $db->query("select id, menuitem from articles");
    while ($menuitem = $result->fetch_assoc()) {
        //print("<li> <a href='?id=".$menuitem["id"]."'>".$menuitem["menuitem"]."</a> </li>");
        ?>
        <div class="buttonwrapper">
            <div class="buttonleft">&nbsp;</div><!--
	--><div class="buttoncenter"><a
                        href="?id=<?php print($menuitem["id"]); ?>"><?php print($menuitem["menuitem"]); ?></a></div><!--
	--><div class="buttonright">&nbsp;</div>
        </div> <br/>
        <?php
    }
    ?>
</div>