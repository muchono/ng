<?php

class CronController extends Controller
{
	/**
     * Update Sites Statistics
	 */
	public function actionUpdateStats()
	{
        Product::model()->updateStatsForGroup();
        Yii::app()->end();
	}
}
