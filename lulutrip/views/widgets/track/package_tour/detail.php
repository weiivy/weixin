<script type="text/javascript">
    var dataLayer = dataLayer || [];
    dataLayer.push({
        'PageType': 'Productpage',
        'HashedEmail': '<?= $email;?>',
        'userId': '<?= $memberid;?>',
        'ProductID': '<?= $productId;?>',
        'Currency': '<?= Yii::$app->params['curCurrency'] == 'RMB' ?  'CNY' : Yii::$app->params['curCurrency'];?>'
    });


    dataLayer.push({
        'currencyCode': '<?= Yii::$app->params['curCurrency'] == 'RMB' ?  'CNY' : Yii::$app->params['curCurrency'];?>',
        'ecommerce': {
            'detail' : {
                'products':  [{
                    'name': '<?= $packagetour['packmaintitle_cn'];?>(包团<?= $packagetour['packid'];?>)',
                    'id': '<?= $productId;?>',
                    'price': '',
                    'brand': '',
                    'category': ''
                }]
            }
        }
    });
    function ga_addtocart_privatetour() {
        var person_num = parseInt($("#pt_peoplenums").html());
        dataLayer.push({
            'event': 'addToCart',
            'currencyCode': '<?= Yii::$app->params['curCurrency'] == 'RMB' ?  'CNY' : Yii::$app->params['curCurrency'];?>',
            'ecommerce': {
                'add': {
                    'products': [{
                        'name': '<?= $packagetour['packmaintitle_cn'];?>(包团<?= $packagetour['packid'];?>)',
                        'id': '<?= $productId;?>',
                        'price': parseInt($(".c_price").html()),
                        'brand': '',
                        'category': '',
                        'quantity': person_num
                    }]
                }
            }
        });
    }
</script>
<?= Yii::$app->view->renderFile('@lulutrip/views/widgets/track/common.php');?>

<!-- LSM -->
<script language="javascript" type="text/javascript" src="//sdc.lulutrip.com/track/seed"></script>
<script language="javascript" type="text/javascript">
    lsm.vi('<?= $packagetour['packid'];?>', 'privatetour');
    lsm.sd();
</script>
<!-- LSM -->