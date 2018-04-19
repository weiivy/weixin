<?php if(!empty($rightAds)):?>
    <div class="rightad-list" style="height: 170px;">
          <div class="ad-list" id="listrightWrapper">
                <ul>
                    <?php foreach($rightAds as $ad):?>
                        <li><a <?php if(!empty($ad['link'])): ?> href="<?= $ad['link']?>" target="_blank"<?php else: ?> href="javascript:volid(0);" <?php endif; ?>><img width="254" height="170" src="<?= Yii::$app->helper->getImgDomain() ?>/<?= $ad['pic']?>"></a></li>
                    <?php endforeach;?>
                </ul>
          </div>
          <div class="ctrl-btn" id="listrightBtn">
              <?php foreach($rightAds as $key => $ad):?>
                  <span <?php if($key == 0):?>class="on"<?php endif;?>></span>
              <?php endforeach;?>

          </div>
    </div>
<?php endif;?>
