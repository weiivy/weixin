<?php if(!empty($hotDestination) && !empty($hotDestination['products'])):?>
    <div class="hot-destination-list">
      <div class="tit"><span id="hot-destination-tit"><?=$hotDestination['title']?></span>人气热卖</div>
      <div class="cont">
        <?php foreach($hotDestination['products'] as $product):?>
            <div class="hot-li">
              <a href="<?=$product['link']?>" target="_blank">
                <div class="img"><img src="<?= $product['image'];?>" alt="<?=$product['title']?>" width="234" height="137"></div>
                <div class="name" title="<?=$product['title']?>"><?=$product['title']?></div>
                <div class="price">
                  <strong><?=$product['sign']?><span><?=$product['price']?></span></strong> 起
                </div>
              </a>
            </div>
        <?php endforeach;?>
      </div>
    </div>
<?php endif;?>
