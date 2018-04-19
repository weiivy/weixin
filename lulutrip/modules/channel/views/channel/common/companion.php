<?php if(!empty($topics)):?>
    <div class="joinmate">
        <div class="wrap">
            <h2 class="tit">路路结伴<span>找个旅伴一同出发吧！</span></h2>
            <div class="cont clearfix">
                <div class="joinmate_text">
                    <i class="join-icon"></i>
                    <h3>加入路路结伴</h3>
                    <p>爱旅行，爱热闹</p>
                    <p>也爱分享旅途中的快乐</p>
                    <p>要省钱，更要赚友情</p>
                    <p>不甘寂寞，不要独来独往</p>
                    <p>不做宅男剩女，我是根正苗红好青年</p>
                    <p>求勾搭，求被捡，我要走出去</p>
                    <p>Lulu结伴，告别一个人的旅行！</p>
                </div>
                <ul class="joinmate_ul">
                    <?php foreach($topics as $value):?>
                    <li>
                        <a href="<?= Yii::$app->params['service']['forum']?>/topic/view/id-<?= $value['id'] ?>" target="_blank">
                            <i class="topic_icon topic_icon3"></i>
                            <span class="topic_name"><?= $value['screenname'] ?></span>
                            <h4 class="topic_txt"><?= $value['subject'] ?></h4>
                            <span class="topic_date">出发日: <?= $value['start_date'] ?></span>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
<?php endif;?>