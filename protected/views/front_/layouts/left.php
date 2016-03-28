                    <nav>
                        <ul class="menu">
                            <li class="about"><a href="?">О компании</a></li>
                            <li class="news"><a href="<?php echo $this->createUrl('front/news')?>">Новости</a></li>
                            <li class="project"><a href="<?php echo $this->createUrl('front/content', array('id' => 'projects'))?>">Проекты</a></li>
                            <li class="product has-sub-menu">
                                <a href="<?php echo $this->createUrl('front/content', array('id' => 'products'))?>">Наша продукция <span class="icon"></span></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo $this->createUrl('front/content', array('id' => 'chmt'))?>">СХТМ</a></li>
                                    <li><a href="<?php echo $this->createUrl('front/content', array('id' => 'ustrojstvo-podgotovki-probi'))?>">Устройство подготовки пробы</a></li>
                                    <li><a href="<?php echo $this->createUrl('front/content', array('id' => 'promishlennie-producti'))?>">Промышленные продукты</a></li>
                                </ul>
                            </li>
                            <li class="manuals"><a href="<?php echo $this->createUrl('front/content', array('id' => 'instructions'))?>">Руководства по эксплуатации</a></li>
                            <li class="documents"><a href="<?php echo $this->createUrl('front/content', array('id' => 'docs'))?>">Разрешительная документация</a></li>
                            <li class="contact"><a href="<?php echo $this->createUrl('front/content', array('id' => 'contacts'))?>">Контакты</a></li>
                        </ul>
                    </nav>
                    <div class="title-h2">
                        <h2>Наша продукция<a href="<?php echo $this->createUrl('front/content', array('id' => 'products'))?>" class="icon"></a></h2>
                    </div>
                    <img src="img/side-img-1.jpg" alt="">
                    <div class="title">
                        <h3>ПТК СХТМ, экспересс-лаборатория</h3>
                    </div>
                    <img src="img/side-img-2.jpg" alt="">
                    <div class="title">
                        <h3>ПТК СХТМ, экспересс-лаборатория</h3>
                    </div>
                    <img src="img/side-img-3.jpg" alt="">
                    <div class="title-h4">
                        <h4><a href="<?php echo $this->createUrl('front/content', array('id' => 'products'))?>">Вся продукция</a><a  class="icon" href="<?php echo $this->createUrl('front/content', array('id' => 'products'))?>"></a></h4>
                    </div>