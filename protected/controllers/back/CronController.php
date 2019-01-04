<?php

class CronController extends Controller
{
	/**
     * Update Sites Statistics
	 */
	public function actionUpdateStats()
	{
            Product::updateStatsForGroup();
            print date('d-m-Y H:i:s') . ' - update done' . "\n";
            Yii::app()->end();
	}
}
