<?php

/**
 * This is the model class for table "faq".
 *
 * The followings are the available columns in table 'faq':
 * @property string $id
 * @property string $title
 * @property string $answer
 * @property boolean $popular_question
 */
class Faq extends ManyManyActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, categories, answer', 'required'),
			array('popular_question', 'safe'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, answer', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'categories' => array(self::MANY_MANY, 'FaqCategory', 'faq_to_category(faq_id, category_id)'),            
            'faq_to_category' => array(self::HAS_MANY, 'FaqToCategory', 'faq_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Question',
			'answer' => 'Answer',
            'categories'=>'Categories',            
            'popular_question'=>'Popular Question',            
		);
	}

    
    /**
     * delete
     */
    public function delete()
    {
        Yii::app()->db->createCommand()
                  ->delete('faq_to_category', 'faq_id=:fid', array(':fid'=>$this->id));
        parent::delete();
    }
    
    
    /**
     * Get Categories list
     * @return string categories list
     */
    public function getCategoriesList()
    {
        $tmp = array();
        foreach ($this->categories as $c) {
            $tmp[] = $c->title;
        }
        return join(', ', $tmp);
    }
    
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $sort=new CSort;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
        
        if ($this->categories) {
            $criteria->with = array( 
                'categories' => array(
                    'select' =>false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'category_id = :cid',
                    'params'=> array(':cid' => $this->categories),
                )
            ); 
            $criteria->together = true;            
        }
        
        $sort->defaultOrder= array(
            'title'=>CSort::SORT_ASC,
        ); 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>$sort,
		));
	}
}