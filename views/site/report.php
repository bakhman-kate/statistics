<?php

use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;

$this->title = Yii::t('app', 'Report');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
    $(document).on("change", "#days_in_period", function(event) {  
        window.location.assign("/report?period_days=" + $(this).val());
    });       
');?>

<div>
    <h1><?= Html::encode($this->title) ?></h1> 
    
    <?= HighCharts::widget([
        'clientOptions' => [
            'title' => [
                'text' => 'Результаты работы с клиентами'
            ],
            'subtitle' => [
                'text' => 'Отчет демонстрирует конверсию (процент зарегистрированных клиентов от общего числа всех клиентов) по периодам, начиная от даты получения первого клиента'
            ],
            'xAxis' => [
                'title' => [
                    'text' => 'Номер периода'
                ],     
            ],
            'yAxis' => [
                'title' => [
                    'text' => 'Конверсия, %'
                ],
                'min' => 0,
                'max' => 100
            ],            
            'series' => [
                ['name' => 'Конверсия по периодам', 'data' => $conversion],                
            ],                        
        ]
    ]);?>
    
    <form class="form-horizontal">
        <div class="form-group">
            <label for="days_in_period" class="col-md-3 control-label">Количество дней в периоде:</label>
            <div class="col-md-2">
                <select id="days_in_period" class="form-control">
                    <?php foreach($available_period_days as $number):?>
                        <option valie="<?=$number?>" <?php if($number == $period_days):?>selected<?php endif;?>><?=$number?></option>
                    <?php endforeach;?>                    
                </select>
            </div>
        </div>
    </form>
</div>
