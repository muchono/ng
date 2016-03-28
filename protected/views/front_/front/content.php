    <div class="top">
        <div class="breadcrambs">
            <ul>
                <li class="home">
                    <a href="">
                        <img src="img/crambs-icon.png" alt="">
                    </a>
                </li>
                <li><a href="?">Главная</a>/</li>
                <li><a href=""><?php echo $pc->name?></a></li>
            </ul>
        </div>
        <div class="search">
            <form class="search">  
                <input type="search" name="" placeholder="Поиск" class="input" />
                <button  type="submit" name="" value="" class="submit gradient-1">
                    <img src="img/search-icon.png" alt="">
                </button>  
            </form> 
        </div>
    </div>
<?php echo $pc->content?>
<?php if ($pc->submenu) {?>
<script>
    submenu_click('product');
</script>    
<?php }?>
