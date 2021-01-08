<?php

/* @var $this yii\web\View */

use pcrt\widgets\select2\Select2;

$this->registerJsFile('js/jquery.min.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js/js/select2.js', ['depends' => [\pcrt\widgets\select2\Select2Asset::className()]]);

$this->title = 'Dashboard';

//echo Select2::widget([
//    'name' => 'my-name',
//    'ajax' => [
//        'url' => "http://localhost/eventusgest/backend/web/api/accesspoint",
//        'dataType' => 'json',
//    ]
//]);

echo '<select class="js-data-example-ajax w-100"></select>';
$authKey = Yii::$app->getRequest()->getCookies()->getValue('user-auth');

$js = <<<SCRIPT

$('.js-data-example-ajax').select2({
    ajax: {
        url: 'http://localhost/eventusgest/backend/web/api/accesspoint',
       headers: {
           Authorization: 'Basic $authKey'
       },
        dataType: 'json',
        delay: 200,
        processResults: function (data, params) {
            console.log(data)
            
            return data.map( (val, i) => {
                console.log(val)
                console.log(i)
                let newArr = [];
                newArr[i]["id"] = val.id;
                newArr[i]["name"] = val.name;
                
                return newArr;
            } );
        },
        cache: true
    },
    minimumInputLength: 3
});
SCRIPT;
$this->registerJs($js);
?>

