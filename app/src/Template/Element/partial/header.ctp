<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">ねこがいますか？</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/pages/top">これはなに？</a>
                </li>
                <li>
                    <a href="/policy/index">利用規約</a>
                </li>
                <li>
                    <a href="/policy/contact">お問い合わせ</a>
                </li>
            </ul>
            <?php
            if (!$auth):
            ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/login">ログイン</a></li>
                </ul>
            <?php
            else:
            ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/profiles/user/<?=$auth['username']?>">マイページ</a></li>
                    <li><a href="/logout">ログアウト</a></li>
                </ul>
            <?php
            endif;
            ?>
            
        </div>
        <!-- /.navbaｃr-collapse -->
    </div>
    <!-- /.container -->
</nav>
