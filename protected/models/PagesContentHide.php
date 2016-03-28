<?php

/**
 * This is the model class for table "pages_content_hide".
 *
 * The followings are the available columns in table 'pages_content_hide':
 * @property string $id
 * @property string $user_id
 * @property string $href
 */
class PagesContentHide extends CActiveRecord
{
    protected $_available_href = array('sdfsdf');
    
    public function getAvailable()
    {
        $r = $this->_available_href;
        $content_hrefs = PagesContent::model()->findAll(array('select'=>'id, href'));
        foreach($content_hrefs as $h){
            $r[] = $h->href;
        }
        return $r; 
    }

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PagesContentHide the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function hide()
    {
        $this->save();
    }

    public function isHidden()
    {
        $item = $this->find('user_id=:uid AND href=:href', array('uid'=>$this->user_id, 'href'=>$this->href));
        return !empty($item);
    }
    
	/**
	 * Check if in table already.
     * This is the validator as declared in rules().
	 */    
    public function isInTable()
    {
        if ($this->isHidden()) {
            $this->addError('href', 'The item is in table already');
        }
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages_content_hide';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'length', 'max'=>11),
			array('href', 'length', 'max'=>255),
			array('user_id, href', 'required'),
			array('href', 'isInTable'),
			array('href', 'in', 'range'=>$this->getAvailable()),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'href' => 'Href',
		);
	}
}