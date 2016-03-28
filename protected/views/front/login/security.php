<?php
/* @var $this UserController */
    
    Yii::app()->clientScript->registerCoreScript('jquery');
?>

<style>
    .whitebox{
        margin: 0 auto;
        font-family: "Open Sans";
        background: none repeat scroll 0 0 #ffffff;
        border: 1px solid #d2d2d2;
        font-weight: 300;
        height: 280px;
        width: 866px;
        padding: 14px 7px;
    }
    .whitebox p{
        color: #6b6b6b;
        
        font-size: 18px;
        font-weight: 350!important;
        line-height: 1.2!important;
        text-align: left!important;
        width: 750px;
    }
    
    .whitebox b{
        font-weight: 600;
    }    
    .whitebox-img{
        float:left;
        margin: 15px 45px 0;
    }
   
    .whitebox-title{
        color: #20b718;
        font-size: 24px;
        font-weight: 600;  
        margin-top: 30px;
        text-align: left;
    }
   
    .whitebox .g-recaptcha {
        margin: 20px 20px 20px 265px;
    }
    .whitebox .g-recaptcha img{
        cursor: pointer;
        float:left;
    }
    
    .whitebox .g-recaptcha input[type="text"]{
        width: 98px!important
    }
    .whitebox .g-recaptcha input[type="submit"]{
        padding: 9px 5px 9px 5px;
    } 
    
</style>
        <div class="page sign-up">
            <div class="sign-up-wrap">
                <div class="whitebox">
                    <div class="whitebox-img">
                        <img src="/img/security.jpg"/>
                    </div>
                    <div class="whitebox-title">
                        Complition - on Picture Verification
                    </div>
                    <p>
                        Please enter the text shown on the picture below.
                    </p>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'security-form',
                    )); ?>
                    <div class="g-recaptcha">
                        <img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="<?php echo $this->createUrl('register/SecureImage')?>?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
                        <input type="text" name="g-recaptcha-response" placeholder=" Enter Code"/><br/>
                        <input type="submit" name="sub" value="Submit Code"/>
                    </div>
                    <!--<div class="g-recaptcha" data-sitekey="<?php echo Yii::app()->params['recapcha']['sitekey']?>" data-callback="onloadCallback"></div>-->
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
<?php
    Yii::app()->clientScript->registerScript('choose_payment_script',"
    $('#siimage').click(function(e){
        $(this).prop('src', '".$this->createUrl('register/SecureImage')."?sid='+ Math.random());
    });
    ",CClientScript::POS_READY);
?>
