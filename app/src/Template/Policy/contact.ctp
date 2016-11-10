<div class="container">
    <div class="row">
        <div class="box">
            <div class="col-lg-12 text-center">

                <img class="img-responsive img-border img-left" src="/img/banner.png" alt="">
                <h2 class="brand-before">
                    <small>崇城大学 和泉研究室</small>
                </h2>
                <h3 class="brand-name">ねこでる開発チーム</h3>
                <div class="row"><?= $this->Flash->render() ?>
                    <div class="col-sm-offset-1 col-sm-9">
                        <form method="post" action="#" class="form-horizontal">
                            <div class="form-group">
                                <label for="input-name" class="col-sm-3 control-label">お名前</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="input-name" name="name" placeholder="お名前"
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-mail" class="col-sm-3 control-label">メールアドレス</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="input-mail" name="email" placeholder="メールアドレス"
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ご用件</label>
                                <div class="col-sm-9">
                                    <select name="subject" class="form-control">
                                        <option value="">選択してください</option>
                                        <option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
                                        <option value="ご意見・ご感想">ご意見・ご感想</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">お問い合わせ内容</label>
                                <div class="col-sm-9">
                                    <textarea name="body" class="form-control" rows="5" required="required"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-default">送信</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>
                    <small>Copyright &copy; 竜之介動物病院 崇城大学和泉研究室 2016</small>
                </p>
            </div>
        </div>
    </div>
</footer>

</body>