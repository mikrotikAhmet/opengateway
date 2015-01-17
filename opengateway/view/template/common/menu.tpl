<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
    <li id="suit"><a class="parent"><i class="fa fa-leaf fa-fw"></i> <span><?php echo $text_suit; ?></span></a>
        <ul>
            <li><a class="parent"><?php echo $text_account; ?></a>
                <ul>
                    <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                    <li><a href="<?php echo $account_group; ?>"><?php echo $text_account_group; ?></a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_system; ?></span></a>
        <ul>
            <li><a class="parent"><?php echo $text_users; ?></a>
                <ul>
                    <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
                    <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
