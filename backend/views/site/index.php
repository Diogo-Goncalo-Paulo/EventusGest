<?php

/* @var $this yii\web\View */

$this->registerJsFile('js/jquery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js/select2.js', ['depends' => [\pcrt\widgets\select2\Select2Asset::className()]]);

$this->title = 'Dashboard';


?>

