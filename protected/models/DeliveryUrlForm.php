<?php
class DeliveryUrlForm extends CFormModel
{
	public $id;
	public $url;
    
    public function rules()
	{
		return array(
			array('id, url', 'required', 'message'=>'Please enter an {attribute}.'),
            array('url','url'),
		);
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'id'=>'ID',
			'url' => 'Post URL',
		);
	}
}