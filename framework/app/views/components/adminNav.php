<nav class="navbar navbar-default navigationRow"> 
    <ul class="nav navbar-nav">
        <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/adminAll">All</a></li>
        <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/adminNew">New</a></li>
    </ul>
    <ul class="nav navbar-nav pull-right">
        <?php if (isset($_SESSION['admin'])) {
            ?>
            <li class="dropdown" style="float:right;">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Admin<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/adminAll">All Pets</a></li>
                    <li><a href="/~<?php echo USER; ?>/index.php/PetBasket/adminNew">New Pets</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Log Out</a></li>
                </ul>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>