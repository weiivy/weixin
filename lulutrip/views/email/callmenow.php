<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lulutrip</title>
<style type="text/css">
body {
	background: #FFF;
	margin: 0;
	font-size: 12px;
	font-family: Arial;
}

td,  {
	font-size: 12px;
	font-family: Arial;
}
form {
	margin: 0;
	padding: 0;
}

input, textarea, select {
	font-size: 12px;
	font-family: Arial;
	color: #818A89;
	border: 1px solid #A6CBE7;
	border-width: 1px;
	margin: 0;
	padding: 1px;
	width: 220px;
}

textarea {
	height: 80px;
}

#MainFrame {
	width: 500px;
	margin: 5px auto;
	border: 1px solid #A6CBE7;
}

.TitleFrame {
	margin: 1px 1px 10px 1px;
	padding: 5px;
	background: #58A6EA;
	color: red;
	font-weight: bold;
}

.TableFrame {
	margin: 1px;
}

.TitleTd {
	font-weight: bold;
	color: #000;
	text-align: right;
	background: #F4FBFF;
}
.ContentTd {
	background: #FFF;
}
.TableStyle {
	background: #D4EFF7;
}
</style>
</head>

<body>
<div id="MainFrame">
	<div class="TitleFrame" style="color: #ff6600;margin-bottom: 10px;">您有新的路路回电，请尽快登录admin3进行回电！<a href="<?=\Yii::$app->params['service']['admin']?>/callmenow/edit/id-<?=$data['id']?>" target="_blank">点击进入</a></div>
    <div class="TableFrame">
    	<table class="TableStyle" width="100%" align="left" cellpadding="5" cellspacing="1">
        	<tr>
            	<td width="7%" class="TitleTd">ID</td>
                <td width="73%" class="ContentTd"><?=$data['id']?></td>
            </tr>
            <tr>
                <td width="7%" class="TitleTd">用户所在国家</td>
                <td width="73%" class="ContentTd"><?=$data['country']?></td>
            </tr>
        	<tr>
            	<td width="7%" class="TitleTd">用户电话</td>
                <td width="73%" class="ContentTd"><?=$data['phone']?></td>
            </tr>
        	<tr>
            	<td width="7%" class="TitleTd">提交时间</td>
                <td width="73%" class="ContentTd"><?=date('Y-m-d', $data['submit_time'])?></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>